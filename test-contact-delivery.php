<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('ABSPATH', __DIR__);
define('MINUTE_IN_SECONDS', 60);
$cache = array();
$calls = array();
$fail_recipient = '';
$options = array();
$purges = array();
$cache_plugin = false;
function add_action() {}
function get_option($key) { return $GLOBALS['options'][$key] ?? false; }
function update_option($key, $value, $autoload) { $GLOBALS['options'][$key] = $value; }
function has_action($hook) { return $GLOBALS['cache_plugin']; }
function home_url($path) { return 'https://example.test' . $path; }
function do_action($hook, $value) { $GLOBALS['purges'][] = array($hook, $value); }
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
ob_start(); a1_contact_tracking($receipt, false); $linkedin_tracking = ob_get_clean();
check(str_contains($linkedin_tracking, '51992513.js') && str_contains($linkedin_tracking, 'identify') && str_contains($linkedin_tracking, 'trackPageView'), 'LinkedIn receipt must reuse existing HubSpot identification');
check(!str_contains($linkedin_tracking, 'AW-11452936391') && !str_contains($linkedin_tracking, 'conversion'), 'LinkedIn receipt must not fire Google Ads conversion');
a1_contact_purge_after_deploy();
check(!$options && !$purges, 'Missing cache plugin must not mark purge as completed');
$cache_plugin = true;
a1_contact_purge_after_deploy();
check(count($purges) === 7 && in_array(array('litespeed_purge_url', 'https://example.test/thanks/'), $purges, true), 'Release must purge the fixed list of affected URLs');
a1_contact_purge_after_deploy();
check(count($purges) === 7, 'Purge must run only once for this release');
echo "PASS: validation, legacy mapping, recipients, mail failure/retry, deduplication, single-use receipts and tracking.\n";
echo "PASS: one-time release cache invalidation and missing-plugin behavior.\n";

// Quote requests: break caught = accepting missing business fields or requiring phone.
if (file_exists(__DIR__ . '/quote-request.php')) { require __DIR__ . '/quote-request.php'; }
check(function_exists('a1_quote_validate'), 'Quote validation must support the new commercial request contract');
$quote = array('firstname' => 'LOCAL QA QUOTE', 'email' => 'quote@example.com', 'phone' => '',
    'company' => 'QA Venue', 'location' => 'Manhattan, NYC', 'service' => 'S02',
    'coverage_type' => 'both', 'message' => 'QA TEST ONLY: recurring door coverage and private booking',
    'event_start' => '2026-12-03T22:00', 'event_end' => '2026-12-04T02:00',
    'utm_source' => 'linkedin', 'utm_medium' => 'paid_social', 'utm_campaign' => 'a1_s02_quote_202612', 'utm_content' => 'n1');
$validated = a1_quote_validate($quote, 'S02');
check(!$validated['errors'], 'Valid overnight quote with optional empty phone must pass');
check($validated['data']['origin_service'] === 'S02' && $validated['data']['service'] === 'S02', 'Origin and chosen service must remain separate');
foreach (array('firstname', 'email', 'company', 'location', 'service', 'coverage_type', 'message') as $field) {
    $invalid = $quote; $invalid[$field] = '';
    check(isset(a1_quote_validate($invalid, 'S02')['errors'][$field]), 'Missing ' . $field . ' must fail');
}
foreach (array('phone' => '123', 'service' => 'bad', 'email' => "qa@example.com\r\nBcc: bad@example.com", 'company' => array('bad'), 'event_end' => '2026-12-03T02:00', 'preferred_start' => '2026-02-30') as $field => $value) {
    $invalid = $quote; $invalid[$field] = $value;
    check(isset(a1_quote_validate($invalid, 'S02')['errors'][$field]), 'Malformed ' . $field . ' must fail');
}
$quote['service'] = 'S03'; $quote['utm_source'] = '<script>bad</script>'; $quote['utm_term'] = 'person@example.com';
$validated = a1_quote_validate($quote, 'S02');
check($validated['data']['service'] === 'S03' && $validated['data']['origin_service'] === 'S02', 'Changed service must not overwrite landing origin');
check($validated['data']['utm_source'] === '' && !isset($validated['data']['utm_term']), 'Unexpected attribution must not enter the record');
$quote['schedule_unknown'] = '1'; $quote['preferred_start'] = 'wrong';
check(!a1_quote_validate($quote, 'S02')['errors'], 'Unknown schedule must ignore stale date controls');
// Durable transport ledger: clearing transient cache must not resend accepted mail.
$persist_data = $data; $persist_data['email'] = 'durable@example.com';
$calls = array(); $fail_recipient = 'diegoanrora@gmail.com';
$result = a1_contact_deliver($persist_data, 'a1_quote_test');
check(!$result['ok'], 'Partial durable delivery must remain an error');
$cache = array(); $fail_recipient = '';
$result2 = a1_contact_deliver($persist_data, 'a1_quote_test');
check($result2['ok'] && count($calls) === 3 && $result['id'] === $result2['id'], 'Durable retry sends only failed recipient after transient eviction');
check(a1_contact_deliver($persist_data, 'a1_quote_test')['ok'] && count($calls) === 3, 'Durable duplicate must send no further messages');
echo "PASS: quote fields, service/origin, optional phone, overnight dates, attribution and durable retry.\n";
check(is_file(__DIR__ . '/page-privacy-policy-2.php') && str_contains(file_get_contents(__DIR__ . '/page-privacy-policy-2.php'), 'the_content()'), 'Privacy slug must render the saved WordPress content');
check(function_exists('a1_quote_expired'), 'Retention cutoff must be available');
$now = strtotime('2026-11-25T12:00:00Z');
foreach (array(89 => false, 90 => true, 91 => true) as $days => $expected) {
    $sample = array('created' => gmdate('c', $now - $days * 86400), 'status' => 'mail_accepted');
    check(a1_quote_expired($sample, $now) === $expected, '90 day creation cutoff');
}
check(!a1_quote_expired(array('created'=>'invalid'), $now), 'Invalid timestamp must be preserved');
check(!a1_quote_expired($sample + array('retention_hold'=>true), $now), 'Held record must be preserved');
