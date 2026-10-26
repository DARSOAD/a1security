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
// WordPress/plugin boundaries: exercise the actual header output with title-tag
// support, an SEO title override, and a native title when no override is present.
$themeSupport = [];
$setupCallbacks = [];
$seoTitle = 'Executive Protection';
$nativeTitle = 'Executive Protection - A1';
function add_action($hook, $callback) {
    if ('after_setup_theme' === $hook) {
        $GLOBALS['setupCallbacks'][] = $callback;
    }
}
function add_theme_support($feature) { $GLOBALS['themeSupport'][$feature] = true; }
function add_post_type_support($type, $feature) {}
function wp_head() {
    if (!empty($GLOBALS['themeSupport']['title-tag'])) {
        $title = $GLOBALS['seoTitle'] ?? $GLOBALS['nativeTitle'];
        echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>';
    }
}
function wp_get_environment_type() { return 'local'; }
function body_class() { echo 'class="page"'; }
function get_template_part($name) { require __DIR__ . '/' . $name . '.php'; }
function get_header() { require __DIR__ . '/header.php'; }
function get_footer() { echo '</body></html>'; }

require __DIR__ . '/functions.php';
foreach ($setupCallbacks as $callback) {
    $callback();
}

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
if ($xpath->query('//form[@id="theForm"]//*[@required]')->length !== 4) {
    $failures[] = 'Callback requests must require name, phone, service, and a real email.';
}
if ($xpath->query('//form[@id="theForm"]//input[@type="email" and @name="email"]')->length !== 1
    || str_contains($html, 'urgent-callback@a1securitynyc.com')) {
    $failures[] = 'HubSpot must receive the visitor email instead of a shared placeholder.';
}

// Ordinary pages must keep their existing header styling.
$template = 'page-about-us.php';
ob_start();
get_header();
$ordinaryHeader = ob_get_clean();
if (!str_contains($ordinaryHeader, 'font:inherit;vertical-align:baseline')) {
    $failures[] = 'Ordinary pages must keep the legacy reset.';
}

// Each article must receive the title supplied through wp_head, exactly once.
foreach ([
    'Changing Condo Security Providers: A Practical Checklist',
    'Package Management for NYC Condos: A Practical Guide',
    'Choosing Security for NYC Restaurants and Nightlife Venues',
    'Hotel Security in NYC: Coordinating With the Front Desk',
    'After-Hours Office Security in NYC: A Manager’s Checklist',
    'How to Evaluate Retail Security Companies in New York',
    'Guest care & security <NYC>',
    null,
] as $articleTitle) {
    $seoTitle = $articleTitle;
    $nativeTitle = 'WordPress native article title - A1';
    ob_start();
    require __DIR__ . '/header-page.php';
    $articleHeader = ob_get_clean();
    $articleDom = new DOMDocument();
    $articleDom->loadHTML($articleHeader);
    $titles = $articleDom->getElementsByTagName('title');
    $expected = $articleTitle ?? $nativeTitle;
    if (1 !== $titles->length || $expected !== html_entity_decode($titles->item(0)->textContent, ENT_QUOTES, 'UTF-8')) {
        $failures[] = 'Article header must render one WordPress/SEO title: ' . $expected;
    }
}
// Enabling title-tag support must not add a duplicate title to regular pages.
$seoTitle = 'Regular page SEO title';
ob_start();
get_header();
$regularTitleHeader = ob_get_clean();
$regularDom = new DOMDocument();
$regularDom->loadHTML($regularTitleHeader);
$regularTitles = $regularDom->getElementsByTagName('title');
if (1 !== $regularTitles->length || 'Regular page SEO title' !== $regularTitles->item(0)->textContent) {
    $failures[] = 'Regular header must allow WordPress/SEO to render its only title.';
}

foreach ($failures as $failure) {
    fwrite(STDERR, "FAIL: $failure\n");
}
if ($failures) {
    exit(1);
}
echo "PASS: landing layout/contracts, page styles, six article titles, escaping, native fallback, and no duplicate titles.\n";
