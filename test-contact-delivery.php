<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('ABSPATH', __DIR__);
define('MINUTE_IN_SECONDS', 60);
$cache = array();
$calls = array();
$fail_recipient = '';
function add_action() {}
function sanitize_textarea_field($value) { return trim(strip_tags($value)); }
function sanitize_text_field($value) { return trim(strip_tags($value)); }
function wp_unslash($value) { return stripslashes($value); }
function is_email($value) { return filter_var($value, FILTER_VALIDATE_EMAIL); }
function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
function wp_salt($value) { return 'test-only-salt'; }
function wp_generate_uuid4() { return 'test-' . bin2hex(random_bytes(16)); }
function get_transient($key) { return $GLOBALS['cache'][$key] ?? false; }
function set_transient($key, $value, $ttl) { $GLOBALS['cache'][$key] = $value; }
function delete_transient($key) { unset($GLOBALS['cache'][$key]); }
function wp_get_environment_type() { return 'production'; }
function wp_mail($recipient, $subject, $body, $headers) {
    $GLOBALS['calls'][] = compact('recipient', 'subject', 'body', 'headers');
    return $recipient !== $GLOBALS['fail_recipient'];
}
require __DIR__ . '/contact-delivery.php';
function check($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
}
$legacy = array('nombre' => 'QA Contact', 'telefono' => '+1 202 555 0100', 'correo' => 'qa@example.com', 'empresa' => 'QA Company', 'comentarios' => 'QA request', 'hs_google_click_id' => 'TEST-NOT-AN-AD-CLICK');
$data = a1_contact_data($legacy);
check(a1_contact_valid($data), 'Legacy names must produce a valid request');
check($data['firstname'] === 'QA Contact' && $data['company'] === 'QA Company', 'Legacy values must survive mapping');
check(!a1_contact_valid(a1_contact_data(array('hs_google_click_id' => 'test'))), 'GCLID-only request must fail');
foreach (array('firstname' => '', 'phone' => '123', 'email' => 'urgent-callback@a1securitynyc.com') as $key => $value) {
    $invalid = $data; $invalid[$key] = $value;
    check(!a1_contact_valid($invalid), 'Invalid ' . $key . ' must fail');
}
check(!a1_contact_valid(a1_contact_data(array('firstname' => array('bad')))), 'Array input must fail safely');
$first = a1_contact_deliver($data);
check($first['ok'] && count($calls) === 2, 'Both recipients must be notified');
check(array_column($calls, 'recipient') === array('a1securenyc@gmail.com', 'diegoanrora@gmail.com'), 'Recipients must match user instruction');
check(str_contains($calls[0]['body'], 'QA Contact') && str_contains($calls[0]['body'], 'TEST-NOT-AN-AD-CLICK'), 'Email must contain contact and attribution');
$second = a1_contact_deliver($data);
check(count($calls) === 2 && $first['id'] === $second['id'], 'Retry must not duplicate mail or conversion ID');
$data['email'] = 'retry@example.com';
$fail_recipient = 'diegoanrora@gmail.com';
check(!a1_contact_deliver($data)['ok'], 'Partial mail failure must not count as success');
$before = count($calls); $fail_recipient = '';
check(a1_contact_deliver($data)['ok'] && count($calls) === $before + 1, 'Retry only failed destination');
$_GET = array();
check(a1_contact_take_receipt() === false, 'Direct GET must have no receipt');
$token = str_repeat('a', 40); $_GET['receipt'] = $token;
$receipt = array('id' => $first['id'], 'contact' => $data);
set_transient('a1_receipt_' . $token, $receipt, 300);
check(a1_contact_take_receipt() === $receipt && !a1_contact_take_receipt(), 'Receipt must be single use');
ob_start(); a1_contact_tracking(false); $empty = ob_get_clean();
check($empty === '', 'Direct GET must render no tracking');
ob_start(); a1_contact_tracking($receipt); $tracking = ob_get_clean();
check(str_contains($tracking, 'transaction_id') && str_contains($tracking, '51992513.js') && str_contains($tracking, 'retry@example.com'), 'Successful receipt must load HubSpot and deduplicated conversion');
echo "PASS: validation, legacy mapping, recipients, mail failure/retry, deduplication, single-use receipts and tracking.\n";
