<?php
// Run with: php test-executive-protection.php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// Minimal WordPress boundary for rendering the actual theme header and landing.
$template = 'page-lp-executive-protection.php';
function is_home() { return false; }
function is_single() { return false; }
function is_singular($type) { return false; }
function is_page() { return true; }
function is_page_template($name) { return $name === $GLOBALS['template']; }
function get_template_directory_uri() { return '/theme'; }
function get_site_url() { return 'https://example.test'; }
function wp_title($separator) { echo 'Executive Protection'; }
function wp_head() {}
function body_class() { echo 'class="page"'; }
function get_template_part($name) { require __DIR__ . '/' . $name . '.php'; }
function get_header() { require __DIR__ . '/header.php'; }
function get_footer() { echo '</body></html>'; }

ob_start();
require __DIR__ . '/page-lp-executive-protection.php';
$html = ob_get_clean();
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$failures = [];

// The old header reset made all landing margins zero, including auto centering.
if (preg_match('/margin:\s*0\s*!important;\s*padding:\s*0;\s*border:\s*0;\s*font-size:\s*100%;\s*font:\s*inherit/', $html)) {
    $failures[] = 'Executive landing must retain its own spacing and typography.';
}
if ($xpath->query('//*[@class="ep-sticky-bar"]/ancestor::*[@id="bloque1"]')->length) {
    $failures[] = 'Call bar must be outside the collapsed theme header.';
}
$form = $xpath->query('//form[@id="theForm"]')->item(0);
if (!$form || $form->getAttribute('action') !== 'https://example.test/?page_id=33') {
    $failures[] = 'Callback requests must keep the existing submission endpoint.';
}
if ($xpath->query('//form[@id="theForm"]//*[@required]')->length !== 3) {
    $failures[] = 'Callback requests must require name, phone, and service.';
}

// Ordinary pages must keep their existing header styling.
$template = 'page-about-us.php';
ob_start();
get_header();
$ordinaryHeader = ob_get_clean();
if (!str_contains($ordinaryHeader, 'font:inherit;vertical-align:baseline')) {
    $failures[] = 'Ordinary pages must keep the legacy reset.';
}

foreach ($failures as $failure) {
    fwrite(STDERR, "FAIL: $failure\n");
}
if ($failures) {
    exit(1);
}
echo "PASS: landing spacing isolation, call bar placement, callback contract, and ordinary page styles.\n";
