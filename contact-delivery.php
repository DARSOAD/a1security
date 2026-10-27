<?php
/** Shared receiver for the site's existing contact forms. */
if (!defined('ABSPATH')) {
    exit;
}

function a1_contact_purge_after_deploy() {
    // FTP updates do not trigger WordPress's theme-update cache invalidation.
    // Invalidate only the affected pages once when this release reaches PHP.
    $version = '2026-10-27-1';
    if (wp_get_environment_type() === 'local'
        || get_option('a1_contact_cache_version') === $version
        || !has_action('litespeed_purge_url')) {
        return;
    }
    foreach (array('/', '/immediate-vip-protection/', '/hospitality-security/', '/corporate-security/', '/thanks/', '/?page_id=33', '/gracias/') as $path) {
        do_action('litespeed_purge_url', home_url($path));
    }
    update_option('a1_contact_cache_version', $version, false);
}
add_action('wp_loaded', 'a1_contact_purge_after_deploy');

function a1_contact_data($input) {
    $aliases = array('firstname' => 'nombre', 'phone' => 'telefono', 'email' => 'correo', 'company' => 'empresa', 'message' => 'comentarios');
    $data = array();
    foreach ($aliases as $key => $legacy) {
        $value = isset($input[$key]) ? $input[$key] : (isset($input[$legacy]) ? $input[$legacy] : '');
        $data[$key] = is_string($value) ? sanitize_textarea_field(wp_unslash($value)) : '';
    }
    foreach (array('service', 'hs_google_click_id') as $key) {
        $data[$key] = isset($input[$key]) && is_string($input[$key]) ? sanitize_text_field(wp_unslash($input[$key])) : '';
    }
    return $data;
}

function a1_contact_valid($data) {
    $digits = preg_replace('/\D/', '', $data['phone']);
    return strlen($data['firstname']) >= 2 && strlen($data['firstname']) <= 200
        && strlen($digits) >= 7 && strlen($digits) <= 15
        && is_email($data['email']) && strlen($data['email']) <= 254
        && strtolower($data['email']) !== 'urgent-callback@a1securitynyc.com'
        && strlen($data['company']) <= 300 && strlen($data['message']) <= 5000
        && strlen($data['hs_google_click_id']) <= 512
        && in_array($data['service'], array('', 'Executive Protection', 'Court Escort', 'Emergency Security', 'Other'), true);
}

function a1_contact_deliver($data) {
    // Deduplicate retries for ten minutes; retry only recipients that failed.
    $key = 'a1_delivery_' . hash_hmac('sha256', wp_json_encode($data), wp_salt('auth'));
    $state = get_transient($key);
    if (!is_array($state)) {
        $state = array('id' => wp_generate_uuid4(), 'sent' => array());
    }
    $labels = array('firstname' => 'Name', 'company' => 'Company', 'phone' => 'Phone', 'email' => 'Email', 'service' => 'Service required', 'message' => 'Additional information', 'hs_google_click_id' => 'Google Click ID (GCLID)');
    $body = 'New website contact request' . "\nReference: " . $state['id'] . "\n\n";
    foreach ($labels as $field => $label) {
        $body .= $label . ': ' . ($data[$field] !== '' ? $data[$field] : '(not provided)') . "\n";
    }
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $data['email']);
    foreach (array('a1securenyc@gmail.com', 'diegoanrora@gmail.com') as $recipient) {
        if (empty($state['sent'][$recipient])) {
            $state['sent'][$recipient] = wp_mail($recipient, 'A1 website contact request', $body, $headers);
            set_transient($key, $state, 10 * MINUTE_IN_SECONDS);
        }
    }
    return array('id' => $state['id'], 'ok' => !in_array(false, $state['sent'], true));
}

function a1_contact_receive() {
    if (!is_page(array(33, 'thanks', 'gracias'))) {
        return;
    }
    // Never cache receipts, contact details, or conversion markup.
    if (!defined('DONOTCACHEPAGE')) {
        define('DONOTCACHEPAGE', true);
    }
    do_action('litespeed_control_set_nocache', 'A1 contact receipt');
    nocache_headers();
    header('Referrer-Policy: no-referrer');
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return;
    }
    $data = a1_contact_data($_POST);
    if (($_POST['tipo'] ?? '') !== 'registrarse' || !a1_contact_valid($data)) {
        wp_die('Please go back and enter your name, a valid phone number and your email address. No request has been sent. You can also call (917) 828-3434.', 'Please check your details', array('response' => 422, 'back_link' => true));
    }
    $delivery = a1_contact_deliver($data);
    if (!$delivery['ok']) {
        wp_die('We could not complete your request. Please go back and try again, or call (917) 828-3434 for assistance.', 'Unable to send request', array('response' => 503, 'back_link' => true));
    }
    $token = wp_generate_password(40, false, false);
    set_transient('a1_receipt_' . $token, array('id' => $delivery['id'], 'contact' => $data), 5 * MINUTE_IN_SECONDS);
    // POST/Redirect/GET prevents refresh from resending notifications.
    wp_safe_redirect(add_query_arg('receipt', $token, get_permalink(33)), 303);
    exit;
}
add_action('template_redirect', 'a1_contact_receive', 1);

function a1_contact_take_receipt() {
    $token = isset($_GET['receipt']) && is_string($_GET['receipt']) ? $_GET['receipt'] : '';
    if (!preg_match('/^[A-Za-z0-9]{40}$/D', $token)) {
        return false;
    }
    $receipt = get_transient('a1_receipt_' . $token);
    delete_transient('a1_receipt_' . $token);
    return is_array($receipt) ? $receipt : false;
}

function a1_contact_tracking($receipt) {
    if (!$receipt || wp_get_environment_type() === 'local') {
        return;
    }
    $data = $receipt['contact'];
    $properties = array_intersect_key($data, array_flip(array('firstname', 'phone', 'email')));
    if ($data['hs_google_click_id'] !== '') {
        $properties['hs_google_click_id'] = $data['hs_google_click_id'];
    }
    if ($data['company'] !== '') {
        $properties['company'] = $data['company'];
    }
    // Identification supplements the existing collected-forms integration,
    // including GCLID, which collected forms ignores when it is hidden.
    ?>
    <script>
    history.replaceState(null, '', location.pathname);
    window._hsq = window._hsq || [];
    window._hsq.push(['identify', <?php echo wp_json_encode($properties, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>]);
    window._hsq.push(['trackPageView']);
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-11452936391');
    gtag('event', 'conversion', {
        send_to: 'AW-11452936391/qacnCOqnoPMcEMfhl9Uq',
        transaction_id: <?php echo wp_json_encode($receipt['id']); ?>,
        value: 1.0,
        currency: 'USD'
    });
    </script>
    <script async defer src="https://js.hs-scripts.com/51992513.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11452936391"></script>
    <?php
}
