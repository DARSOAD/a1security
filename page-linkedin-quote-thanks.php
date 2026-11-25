<?php
/** Template Name: A1 LinkedIn Quote Thanks */
// Distribution copy: marketing workspace content_factory/linkedin_posts/2026-12/landings/thanks.md.
if (!defined('ABSPATH')) { exit; }
$receipt = a1_quote_take_receipt();
$assets = get_template_directory_uri();
wp_enqueue_style('a1-quote', $assets . '/css/security-quote.css', array(), filemtime(__DIR__ . '/css/security-quote.css'));
?><!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="referrer" content="no-referrer"><meta name="robots" content="noindex,nofollow">
<script>history.replaceState(null, '', location.pathname);</script>
<?php a1_contact_tracking($receipt, false); wp_head(); ?></head>
<body class="a1-quote-page">
<?php wp_body_open(); ?>
<a class="skip-link" href="#quote-main">Skip to content</a>
<header class="quote-header wrap">
<a href="<?php echo esc_url(home_url('/')); ?>" aria-label="A1 Security Professionals home"><img class="quote-logo" src="<?php echo esc_url($assets . '/imagenes/quotes/firma-a1.png'); ?>" width="1338" height="580" alt="A1 Security Professionals"></a>
<a class="quote-phone" href="tel:+19178283434">(917) 828-3434</a>
</header>
<main id="quote-main" class="quote-receipt wrap">
<?php if ($receipt) : ?>
<section id="quote-success" aria-labelledby="receipt-title" tabindex="-1">
<p class="eyebrow">REQUEST RECEIVED</p>
<h1 id="receipt-title">Thank you for your request.</h1>
<p>We received your security quote request. A1 will review your location, requested coverage and schedule, then follow up using the contact details you provided.</p>
<p>Sending this form does not reserve coverage. Availability, responsibilities and pricing are confirmed in the agreed proposal.</p>
<p id="quote-reference">Request reference: <?php echo esc_html($receipt['id']); ?></p>
</section>
<script>
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(<?php echo wp_json_encode(array('event' => 'a1_quote_received', 'request_id' => $receipt['id'], 'service' => $receipt['service']), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>);
</script>
<?php else : ?>
<section id="quote-receipt-unavailable" aria-labelledby="receipt-title">
<p class="eyebrow">A1 SECURITY PROFESSIONALS</p>
<h1 id="receipt-title">Your request confirmation</h1>
<p>This confirmation link has expired or has already been viewed. Opening this page does not send a request.</p>
<p>If you already submitted a request, please contact A1 to check its status before sending again.</p>
</section>
<?php endif; ?>
<div class="quote-next"><h2>Speak with A1</h2>
<p>Laura Libecci handles commercial conversations.</p>
<p><a href="tel:+19178283434">(917) 828-3434</a><br><a href="mailto:a1securenyc@gmail.com">a1securenyc@gmail.com</a></p></div>
<a class="quote-button" href="<?php echo esc_url(home_url('/')); ?>">Visit A1 Security Professionals</a>
</main>
<footer class="quote-footer wrap"><p>A1 Security Professionals · New York City</p></footer>
<?php wp_footer(); ?></body></html>
