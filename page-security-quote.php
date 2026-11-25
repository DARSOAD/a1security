<?php
/** Template Name: A1 Security Quote */
if (!defined('ABSPATH')) { exit; }
$origin = get_post_field('post_name', get_queried_object_id()) === 'hotel-security-quote' ? 'S03' : 'S02';
$content = require __DIR__ . '/quote-content.php';
$copy = $content[$origin];
$assets = get_template_directory_uri();
$privacy = get_privacy_policy_url();
$local = wp_get_environment_type() === 'local';
$enabled = $local || (bool) $privacy;
wp_enqueue_style('a1-quote', $assets . '/css/security-quote.css', array(), filemtime(__DIR__ . '/css/security-quote.css'));
wp_enqueue_script('a1-quote', $assets . '/js/security-quote.js', array(), filemtime(__DIR__ . '/js/security-quote.js'), true);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="referrer" content="no-referrer">
<?php wp_head(); ?></head>
<body class="a1-quote-page">
<?php wp_body_open(); ?>
<a class="skip-link" href="#quote-main">Skip to content</a>
<header class="quote-header wrap">
    <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="A1 Security Professionals home"><img class="quote-logo" src="<?php echo esc_url($assets . '/imagenes/quotes/firma-a1.png'); ?>" width="1338" height="580" alt="A1 Security Professionals"></a>
    <a class="quote-phone" href="tel:+19178283434">(917) 828-3434</a>
</header>
<main id="quote-main">
<section class="quote-hero wrap" aria-labelledby="quote-title">
    <div class="hero-copy"><p class="eyebrow"><?php echo esc_html($copy['eyebrow']); ?></p>
    <h1 id="quote-title"><?php echo esc_html($copy['title']); ?></h1>
    <p class="hero-intro"><?php echo esc_html($copy['intro']); ?></p>
    <a class="quote-button" href="#quote-form-section">Request a security quote</a>
    </div>
    <figure class="hero-scene"><picture><source media="(max-width: 600px)" srcset="<?php echo esc_url($assets . '/imagenes/quotes/' . $copy['sector'] . '-mobile.jpg'); ?>"><img src="<?php echo esc_url($assets . '/imagenes/quotes/' . $copy['sector'] . '-horizontal.jpg'); ?>" width="1600" height="900" alt="<?php echo esc_attr($copy['alt']); ?>" fetchpriority="high"></picture><figcaption><?php echo esc_html($copy['caption']); ?></figcaption></figure>
</section>
<section class="quote-operation wrap" aria-labelledby="operation-title">
    <h2 id="operation-title">Security coverage<br>around your operation</h2>
    <p><?php echo esc_html($copy['scope']); ?></p>
</section>
<section class="quote-planning wrap" aria-labelledby="planning-title"><h2 id="planning-title">What are you planning?</h2>
    <div class="planning-grid"><?php foreach ($copy['situations'] as $item) : ?><article><h3><?php echo esc_html($item[0]); ?></h3><p><?php echo esc_html($item[1]); ?></p></article><?php endforeach; ?></div>
</section>
<section class="quote-form-section" id="quote-form-section" aria-labelledby="form-title"><div class="quote-form-layout wrap">
<aside class="quote-form-aside"><p class="eyebrow">YOUR COVERAGE, YOUR SCHEDULE</p><h2 id="form-title">Tell us about your coverage needs</h2><p>For business owners and managers requesting security services.</p>
<div class="quote-next"><h3>What happens next?</h3><p><?php echo esc_html($copy['next']); ?></p></div>
<p>Prefer a conversation?<br><a href="tel:+19178283434">(917) 828-3434</a><br><a href="mailto:a1securenyc@gmail.com">a1securenyc@gmail.com</a></p></aside>
<div class="quote-form-panel">
<?php if ($local && !$privacy) : ?><p class="local-notice">Local preview · test requests only. A published privacy policy is required before launch.</p><?php endif; ?>
<?php if (!$enabled) : ?><p>Please contact A1 at <a href="mailto:a1securenyc@gmail.com">a1securenyc@gmail.com</a> or <a href="tel:+19178283434">(917) 828-3434</a> to discuss your request.</p><?php else : ?>
<form id="quote-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" novalidate data-hs-do-not-collect="true">
<input type="hidden" name="action" value="a1_security_quote"><input type="hidden" name="origin_service" value="<?php echo esc_attr($origin); ?>">
<input type="hidden" name="quote_nonce" value="<?php echo esc_attr(wp_create_nonce('a1_quote_' . $origin)); ?>"><input type="hidden" name="request_id" value="<?php echo esc_attr(bin2hex(random_bytes(16))); ?>">
<?php foreach (array('utm_source', 'utm_medium', 'utm_campaign', 'utm_content') as $key) : ?><input type="hidden" name="<?php echo esc_attr($key); ?>" value=""><?php endforeach; ?>
<div class="quote-honey" aria-hidden="true"><label for="quote-website">Leave this field empty</label><input type="text" name="website" id="quote-website" tabindex="-1" autocomplete="off"></div>
<p class="required-note">Fields marked * are required.</p><div id="quote-errors" class="quote-errors" role="alert" tabindex="-1" hidden></div>
<div class="form-grid">
<?php
$fields = array('firstname' => array('Full name *', 'text', 'name', 200), 'email' => array('Email *', 'email', 'email', 254), 'company' => array($origin === 'S02' ? 'Business or venue name *' : 'Hotel or company name *', 'text', 'organization', 300), 'location' => array('Property location *', 'text', 'street-address', 400));
foreach ($fields as $key => $field) : ?>
<div class="field"><label for="quote-<?php echo esc_attr($key); ?>"><?php echo esc_html($field[0]); ?></label><input id="quote-<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field[1]); ?>" autocomplete="<?php echo esc_attr($field[2]); ?>" maxlength="<?php echo (int) $field[3]; ?>" required aria-describedby="quote-<?php echo esc_attr($key); ?>-error<?php echo $key === 'location' ? ' location-help' : ''; ?>"><?php if ($key === 'location') : ?><small id="location-help">Street address or neighborhood, borough, and city</small><?php endif; ?><span class="field-error" id="quote-<?php echo esc_attr($key); ?>-error"></span></div>
<?php endforeach; ?>
<div class="field"><label for="quote-service">Service *</label><select id="quote-service" name="service" required aria-describedby="quote-service-error"><?php foreach (a1_quote_services() as $key => $label) : ?><option value="<?php echo esc_attr($key); ?>" <?php selected($origin, $key); ?>><?php echo esc_html($label); ?></option><?php endforeach; ?></select><span class="field-error" id="quote-service-error"></span></div>
<div class="field"><label for="quote-coverage_type">Coverage type *</label><select id="quote-coverage_type" name="coverage_type" required aria-describedby="quote-coverage_type-error"><option value="">Choose coverage</option><option value="recurring">Recurring coverage</option><option value="event">Event coverage</option><option value="both">Both</option><option value="unsure">Not sure yet</option></select><span class="field-error" id="quote-coverage_type-error"></span></div>
<div class="field full"><label for="quote-message">Coverage details *</label><textarea id="quote-message" name="message" rows="4" maxlength="5000" required aria-describedby="message-help quote-message-error"></textarea><small id="message-help">Briefly describe your <?php echo $origin === 'S02' ? 'venue' : 'property'; ?>, the coverage you need, and how security should coordinate with your <?php echo $origin === 'S02' ? 'team' : 'front desk and operations team'; ?>.</small><span class="field-error" id="quote-message-error"></span></div>
<div class="field full"><label for="quote-phone">Phone (optional)</label><input id="quote-phone" type="tel" name="phone" autocomplete="tel" maxlength="40" aria-describedby="phone-help quote-phone-error"><small id="phone-help">Include a number if you would like us to contact you by phone</small><span class="field-error" id="quote-phone-error"></span></div>
</div>
<fieldset class="schedule"><legend>Scheduling details</legend><p>Share the dates and hours you know, using the property's local time. You can still submit a request if your schedule is not final.</p>
<label class="checkbox"><input type="checkbox" name="schedule_unknown" value="1"> Schedule not yet confirmed</label>
<div data-schedule="recurring both" class="form-grid"><div class="field"><label for="quote-preferred_start">Preferred start date</label><input id="quote-preferred_start" type="date" name="preferred_start" aria-describedby="quote-preferred_start-error"><span class="field-error" id="quote-preferred_start-error"></span></div><div class="field"><label for="quote-recurring_hours">Days and hours needed</label><textarea id="quote-recurring_hours" name="recurring_hours" rows="2" maxlength="1000" aria-describedby="quote-recurring_hours-error"></textarea><span class="field-error" id="quote-recurring_hours-error"></span></div></div>
<div data-schedule="event both" class="form-grid"><div class="field full"><label for="quote-event_dates">Event date(s)</label><input id="quote-event_dates" name="event_dates" maxlength="1000" aria-describedby="event-dates-help quote-event_dates-error"><small id="event-dates-help">Include each date if you are planning more than one event</small><span class="field-error" id="quote-event_dates-error"></span></div><div class="field"><label for="quote-event_start">Coverage start date and time</label><input id="quote-event_start" name="event_start" type="datetime-local" aria-describedby="overnight-help quote-event_start-error"><span class="field-error" id="quote-event_start-error"></span></div><div class="field"><label for="quote-event_end">Coverage end date and time</label><input id="quote-event_end" name="event_end" type="datetime-local" aria-describedby="overnight-help quote-event_end-error"><span class="field-error" id="quote-event_end-error"></span></div><small class="full" id="overnight-help">For overnight shifts, use the following day's end date.</small></div>
</fieldset>
<div class="before-send"><h3>Before you send</h3><p>Please leave out guest names, access codes and other sensitive security details.</p><p>We use the information you provide to review your security request and contact you about it. <?php if ($privacy) : ?>Read our <a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a>.<?php endif; ?></p></div>
<button class="quote-button" type="submit">Request a security quote</button><p id="quote-progress" role="status" aria-live="polite"></p>
<noscript><p>Please enable JavaScript to submit this form, or contact A1 at a1securenyc@gmail.com or (917) 828-3434.</p></noscript>
</form>
<div id="quote-success" class="quote-success" role="status" tabindex="-1" hidden><h3>Thank you. We received your security quote request.</h3><p>A1 will review the details and follow up using the contact information you provided. Coverage is not reserved until the scope and availability are confirmed.</p><p id="quote-reference"></p></div>
<?php endif; ?></div></div></section>
<section class="quote-about wrap"><h2>About A1</h2><div><p><?php echo esc_html($copy['about']); ?></p><p>Laura Libecci handles commercial conversations. You can reach A1 at <a href="mailto:a1securenyc@gmail.com">a1securenyc@gmail.com</a> or <a href="tel:+19178283434">(917) 828-3434</a>.</p></div></section>
</main>
<footer class="quote-footer wrap"><p>A1 Security Professionals · New York City</p><?php if ($privacy) : ?><a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a><?php endif; ?></footer>
<?php wp_footer(); ?></body></html>
