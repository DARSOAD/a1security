<?php
/** Commercial quote requests. Email transport is shared with the legacy forms. */
if (!defined('ABSPATH')) { exit; }

function a1_quote_services() {
    return array('S02' => 'Nightlife & restaurants', 'S03' => 'Hotels', 'S01' => 'Residential & doorman', 'S04' => 'Corporate & commercial', 'S05' => 'Retail', 'S06' => 'Executive & VIP', 'S00' => 'Other or not sure');
}

function a1_quote_validate($input, $origin) {
    $limits = array('firstname' => 200, 'email' => 254, 'phone' => 40, 'company' => 300, 'location' => 400, 'service' => 3, 'coverage_type' => 20, 'message' => 5000, 'preferred_start' => 10, 'recurring_hours' => 1000, 'event_dates' => 1000, 'event_start' => 16, 'event_end' => 16);
    $data = array(); $errors = array();
    foreach ($limits as $key => $limit) {
        $raw = $input[$key] ?? '';
        $data[$key] = is_string($raw) ? sanitize_textarea_field(wp_unslash($raw)) : '';
        if (!is_string($raw) || strlen($data[$key]) > $limit) { $errors[$key] = 'Please check this field and keep it within ' . $limit . ' characters.'; }
    }
    $required = array('firstname' => 'Enter your name.', 'company' => 'Enter your business or property name.', 'location' => 'Enter the property address or neighborhood, borough, and city.', 'message' => 'Briefly describe the coverage you need.');
    foreach ($required as $key => $message) { if ($data[$key] === '') { $errors[$key] = $message; } }
    if (!is_email($data['email']) || preg_match('/[\r\n]/', $data['email'])) { $errors['email'] = 'Enter a valid email address so we can contact you.'; }
    if (!isset(a1_quote_services()[$data['service']])) { $errors['service'] = 'Choose a service. You can select “Other or not sure.”'; }
    if (!in_array($data['coverage_type'], array('recurring', 'event', 'both', 'unsure'), true)) { $errors['coverage_type'] = 'Choose a coverage type. You can select “Not sure yet.”'; }
    $digits = preg_replace('/\D/', '', $data['phone']);
    if ($data['phone'] !== '' && (!preg_match('/^[+0-9().\s-]+$/D', $data['phone']) || strlen($digits) < 7 || strlen($digits) > 15)) { $errors['phone'] = 'Check your phone number, including the country code if needed, or leave this field blank.'; }
    $data['schedule_unknown'] = ($input['schedule_unknown'] ?? '') === '1' ? '1' : '';
    foreach (array('preferred_start' => 'Y-m-d', 'event_start' => 'Y-m-d\TH:i', 'event_end' => 'Y-m-d\TH:i') as $key => $format) {
        if ($data['schedule_unknown']) { $data[$key] = ''; unset($errors[$key]); continue; }
        if ($data[$key] !== '') {
            $date = DateTimeImmutable::createFromFormat('!' . $format, $data[$key], new DateTimeZone('America/New_York'));
            if (!$date || $date->format($format) !== $data[$key]) { $errors[$key] = 'Enter a valid date, or select “Schedule not yet confirmed.”'; }
        }
    }
    if ($data['event_start'] && $data['event_end'] && $data['event_end'] <= $data['event_start']) { $errors['event_end'] = 'Check the start and end dates and times. For overnight coverage, use the following day’s end date.'; }
    // Campaign attribution is a small allowlist, never arbitrary query text or PII.
    $allowed = array('utm_source' => array('linkedin'), 'utm_medium' => array('paid_social'), 'utm_campaign' => array('a1_s02_quote_202611', 'a1_s02_quote_202612', 'a1_s03_quote_202611', 'a1_s03_quote_202612'), 'utm_content' => array('n1', 'n2', 'h1', 'h2'));
    foreach ($allowed as $key => $values) { $value = $input[$key] ?? ''; $data[$key] = is_string($value) && in_array($value, $values, true) ? $value : ''; }
    $data['origin_service'] = in_array($origin, array('S02', 'S03'), true) ? $origin : '';
    return array('data' => $data, 'errors' => $errors);
}

function a1_quote_transport_data($data) {
    $message = $data['message'];
    foreach (array('location', 'coverage_type', 'preferred_start', 'recurring_hours', 'event_dates', 'event_start', 'event_end', 'schedule_unknown', 'origin_service', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content') as $key) {
        $message .= "\n" . $key . ': ' . ($data[$key] !== '' ? $data[$key] : '(not provided)');
    }
    return array('firstname' => $data['firstname'], 'email' => $data['email'], 'phone' => $data['phone'], 'company' => $data['company'], 'service' => a1_quote_services()[$data['service']], 'message' => $message, 'hs_google_click_id' => '');
}

function a1_quote_failure($unknown = false) {
    return $unknown
        ? 'We could not confirm whether your request was received. Your entries are still here. Please check with A1 at a1securenyc@gmail.com or (917) 828-3434 before sending again.'
        : 'We could not send your request. Your entries are still here. Please try again, or contact A1 at a1securenyc@gmail.com or (917) 828-3434.';
}

function a1_quote_add_once($key, $value) {
    global $wpdb;
    // add_option() has an ON DUPLICATE KEY UPDATE branch; this must be insert-only.
    $inserted = $wpdb->query($wpdb->prepare("INSERT IGNORE INTO {$wpdb->options} (option_name, option_value, autoload) VALUES (%s, %s, 'off')", $key, maybe_serialize($value)));
    if ($inserted === 1) {
        wp_cache_delete($key, 'options');
        wp_cache_delete('notoptions', 'options');
    }
    return $inserted === 1;
}

function a1_quote_allow_attempt() {
    $key = 'a1_quote_rate_' . hash_hmac('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown', wp_salt('auth'));
    $lock = $key . '_lock';
    if (!a1_quote_add_once($lock, time())) { return false; }
    try {
        $count = (int) get_transient($key);
        if ($count >= 8) { return false; }
        set_transient($key, $count + 1, 10 * MINUTE_IN_SECONDS);
        return true;
    } finally { delete_option($lock); }
}

function a1_quote_receive() {
    nocache_headers(); header('Referrer-Policy: no-referrer');
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { wp_send_json_error(array('message' => 'Please submit the quote form.'), 405); }
    if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 24000) { wp_send_json_error(array('message' => 'Please shorten your request.'), 413); }
    $origin = $_POST['origin_service'] ?? '';
    $nonce = $_POST['quote_nonce'] ?? '';
    if (!is_string($origin) || !in_array($origin, array('S02', 'S03'), true) || !is_string($nonce) || !wp_verify_nonce($nonce, 'a1_quote_' . $origin)) { wp_send_json_error(array('message' => 'Your form session expired. Reload this page before sending.'), 403); }
    if (($_POST['website'] ?? '') !== '') { wp_send_json_error(array('message' => 'Unable to send request.'), 422); }
    if (wp_get_environment_type() !== 'local' && !get_privacy_policy_url()) { wp_send_json_error(array('message' => 'Please contact A1 at a1securenyc@gmail.com or (917) 828-3434 to discuss your request.'), 503); }
    $validated = a1_quote_validate($_POST, $origin);
    if ($validated['errors']) { wp_send_json_error(array('message' => 'Please complete the required fields below.', 'errors' => $validated['errors']), 422); }
    $token = $_POST['request_id'] ?? '';
    if (!is_string($token) || !preg_match('/^[a-f0-9]{32}$/D', $token)) { wp_send_json_error(array('message' => 'Reload the page before sending.'), 422); }
    $data = $validated['data'];
    $fingerprint = hash_hmac('sha256', wp_json_encode($data), wp_salt('auth'));
    $mutex = 'a1_quote_lock_' . $fingerprint;
    // Atomic unique option prevents two PHP workers from dispatching the same request.
    // A crash leaves the lock for an administrator to reconcile, never a blind resend.
    if (!a1_quote_add_once($mutex, time())) { wp_send_json_error(array('message' => a1_quote_failure(true)), 409); }
    $response = null; $status = 200;
    try {
        $key = 'a1_quote_record_' . hash_hmac('sha256', $token, wp_salt('auth'));
        $recent_key = 'a1_quote_recent_' . $fingerprint;
        $recent = get_option($recent_key);
        if (is_array($recent) && $recent['expires'] > time()) { $key = $recent['key']; }
        $record = get_option($key);
        if (is_array($record) && $record['fingerprint'] !== $fingerprint) {
            $response = array('message' => 'This request reference was already used. Reload the page before sending a changed request.'); $status = 409;
        } else {
            if (!is_array($record)) {
                if (!a1_quote_allow_attempt()) { $response = array('message' => 'Please wait a few minutes, or contact A1 at (917) 828-3434.'); $status = 429; }
                else {
                    $record = array('id' => wp_generate_uuid4(), 'sent' => array(), 'data' => $data, 'fingerprint' => $fingerprint, 'created' => gmdate('c'), 'status' => 'pending');
                    if (!a1_quote_add_once($key, $record)) { $response = array('message' => a1_quote_failure(true)); $status = 503; }
                }
            }
            if (!$response) {
                update_option($recent_key, array('key' => $key, 'expires' => time() + 10 * MINUTE_IN_SECONDS), false);
                $delivery = a1_contact_deliver(a1_quote_transport_data($data), $key);
                if (!$delivery['ok']) { $response = array('message' => a1_quote_failure(!empty($delivery['unknown']))); $status = 503; }
                else { $response = array('id' => $delivery['id'], 'service' => $data['service'], 'message' => 'Thank you. We received your security quote request.', 'redirect' => a1_quote_receipt_url($key)); }
            }
        }
    } finally { delete_option($mutex); }
    if ($status !== 200) { wp_send_json_error($response, $status); }
    wp_send_json_success($response);
}
add_action('wp_ajax_nopriv_a1_security_quote', 'a1_quote_receive');
add_action('wp_ajax_a1_security_quote', 'a1_quote_receive');

// Called inside the submission mutex, after both mail destinations accepted.
function a1_quote_receipt_url($key) {
    $page = get_page_by_path('linkedin-quote-thanks');
    if (!$page || $page->post_status !== 'publish' || get_page_template_slug($page->ID) !== 'page-linkedin-quote-thanks.php') { return ''; }
    $record = get_option($key);
    if (!is_array($record) || ($record['status'] ?? '') !== 'mail_accepted') { return ''; }
    if (empty($record['receipt_token'])) {
        $token = wp_generate_password(40, false, false);
        $receipt_key = 'a1_quote_receipt_' . hash('sha256', $token);
        if (!a1_quote_add_once($receipt_key, array('key' => $key, 'expires' => time() + 10 * MINUTE_IN_SECONDS))) { return ''; }
        $record['receipt_token'] = $token;
        update_option($key, $record, false);
        if (get_option($key) !== $record) { delete_option($receipt_key); return ''; }
    }
    // Never issue another tracking receipt for duplicate submissions.
    return add_query_arg('receipt', $record['receipt_token'], get_permalink($page->ID));
}

function a1_quote_take_receipt() {
    $token = $_GET['receipt'] ?? '';
    if (!is_string($token) || !preg_match('/^[A-Za-z0-9]{40}$/D', $token)) { return false; }
    $key = 'a1_quote_receipt_' . hash('sha256', $token);
    $pointer = get_option($key);
    // DELETE succeeds for just one worker, including concurrent page loads.
    if (!is_array($pointer) || !delete_option($key) || $pointer['expires'] <= time()) { return false; }
    $record = get_option($pointer['key']);
    if (!is_array($record) || ($record['status'] ?? '') !== 'mail_accepted' || ($record['receipt_token'] ?? '') !== $token) { return false; }
    $contact = a1_quote_transport_data($record['data']);
    // An optional blank phone must not erase an existing HubSpot contact's phone.
    if ($contact['phone'] === '') { unset($contact['phone']); }
    return array('id' => $record['id'], 'contact' => $contact, 'service' => $record['data']['service']);
}

function a1_quote_page_prepare() {
    if (!is_page_template(array('page-security-quote.php', 'page-linkedin-quote-thanks.php'))) { return; }
    if (!defined('DONOTCACHEPAGE')) { define('DONOTCACHEPAGE', true); }
    do_action('litespeed_control_set_nocache', 'A1 quote form nonce');
    nocache_headers(); header('Referrer-Policy: no-referrer');
    if (is_page_template('page-linkedin-quote-thanks.php')) { header('X-Robots-Tag: noindex, nofollow'); }
}
add_action('template_redirect', 'a1_quote_page_prepare', 2);

function a1_quote_isolate_collection() {
    if (is_page_template(array('page-security-quote.php', 'page-linkedin-quote-thanks.php'))) {
        // Browser-collected forms may record a click before validation or receipt.
        // These requests use the durable WP inbox and existing email transport.
        wp_dequeue_script('leadin-script-loader-js');
    }
}
add_action('wp_enqueue_scripts', 'a1_quote_isolate_collection', 100);

function a1_quote_admin_menu() { add_management_page('Security quote requests', 'Security quote requests', 'manage_options', 'a1-quotes', 'a1_quote_admin_page'); }
add_action('admin_menu', 'a1_quote_admin_menu');
function a1_quote_admin_page() {
    if (!current_user_can('manage_options')) { wp_die('Access denied.', '', array('response' => 403)); }
    global $wpdb;
    $rows = $wpdb->get_col($wpdb->prepare("SELECT option_value FROM {$wpdb->options} WHERE option_name LIKE %s ORDER BY option_id DESC LIMIT 50", $wpdb->esc_like('a1_quote_record_') . '%'));
    echo '<div class="wrap"><h1>Security quote requests</h1><p>Latest 50 requests. Mail accepted is not inbox or CRM confirmation. QA tests are not leads.</p>';
    foreach ($rows as $value) {
        $record = maybe_unserialize($value);
        echo '<details><summary>' . esc_html($record['created'] . ' · ' . $record['id'] . ' · ' . ($record['status'] ?? 'pending') . ' · ' . $record['data']['company']) . '</summary><pre>' . esc_html(wp_json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) . '</pre></details>';
    }
    echo '</div>';
}
