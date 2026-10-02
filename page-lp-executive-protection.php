<?php
/**
 * Template Name: Landing Page - Executive Protection
 */
get_header();
?>
<!-- CSS base del tema -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/letra.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/banner-full-screen.css">

<style>
    /* ============================================================
       EXECUTIVE PROTECTION LP — DIRECT RESPONSE / CALL-FIRST
       Mobile-First | CRO Optimized | Premium Aesthetic
       ============================================================ */

    /* Restore the rem scale expected by this landing after Bootstrap's 10px root. */
    html { font-size: 100%; }
    body { margin: 0; background: #0a0a0a; }
    :root {
        --ep-content-width: 1200px;
        --ep-gutter: clamp(20px, 4vw, 60px);
        --ep-bar-height: 70px;
    }
    .ep-hero, .ep-section, .ep-form-section, .ep-sticky-bar,
    .ep-hero *, .ep-section *, .ep-form-section *, .ep-sticky-bar * {
        box-sizing: border-box;
    }

    /* --- RESET: Ocultar el nav/menu global del tema para esta LP --- */
    #menupc, .main-nav, .menumv, .checkout.btn,
    .morph-dropdown-wrapper, .logo_pc, .nav-trigger,
    .cd-header > a, .cd-header > nav { display: none !important; }
    /* Colapsar el contenedor del menú para eliminar espacio blanco */
    body > .container-fluid:has(> #bloque1.cd-header), #bloque1.cd-header {
        height: 0 !important; min-height: 0 !important; max-height: 0 !important;
        padding: 0 !important; margin: 0 !important; overflow: hidden !important;
        background: none !important;
    }

    /* --- STICKY CALL BAR (visible siempre, top fijo) --- */
    .ep-sticky-bar {
        position: sticky; top: 0; width: 100%; z-index: 9999;
        background: #0d0d0d; border-bottom: 1px solid rgba(188,158,82,0.3);
        display: flex; align-items: center; justify-content: space-between;
        min-height: var(--ep-bar-height); gap: 10px;
        padding: 10px var(--ep-gutter); box-sizing: border-box;
    }
    .ep-sticky-bar .ep-logo {
        max-height: 32px; max-width: 25%; width: auto; height: auto;
    }
    .ep-sticky-bar .ep-call-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #bc9e52; color: #000; text-decoration: none;
        font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 12px;
        padding: 10px 12px; border-radius: 30px; letter-spacing: 0.5px;
        text-align: center;
        transition: background 0.3s;
    }
    .ep-sticky-bar .ep-call-btn:hover { background: #d4b96a; }
    @media (min-width: 768px) {
        .ep-sticky-bar .ep-logo { max-height: 38px; }
        .ep-sticky-bar .ep-call-btn { font-size: 15px; padding: 12px 28px; }
    }

    /* --- HERO SECTION --- */
    .ep-hero {
        background: #0a0a0a;
        background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/ep-vip-arrival.png");
        background-size: cover; background-position: center top;
        min-height: calc(100dvh - var(--ep-bar-height)); display: grid; align-items: center;
        position: relative; text-align: center; padding: 60px var(--ep-gutter);
    }
    .ep-hero::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.6) 0%, rgba(5,15,30,0.5) 50%, rgba(0,0,0,0.85) 100%);
    }
    .ep-hero-inner { position: relative; z-index: 2; width: 100%; max-width: var(--ep-content-width); margin: 0 auto; }
    .ep-hero-content { max-width: 700px; margin: 0 auto; min-width: 0; }
    @media (min-width: 992px) {
        .ep-hero { text-align: left; }
        .ep-hero::before { background: linear-gradient(90deg, rgba(0,0,0,0.85), rgba(5,15,30,0.6) 50%, rgba(0,0,0,0.3)); }
        .ep-hero-inner { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 40px; }
        .ep-hero-content { margin: 0; }
        .ep-hero .ep-trust { justify-content: flex-start; }
    }

    .ep-hero h1 {
        font-family: 'Roc Grotesk Wide', sans-serif; font-weight: 700;
        color: #fff; font-size: clamp(1.6rem, 5vw, 2.8rem);
        line-height: 1.15; margin: 0 0 18px 0; text-transform: uppercase;
    }
    .ep-hero h1 span { color: #bc9e52; }
    .ep-hero .ep-sub {
        font-family: 'Lato', sans-serif; color: rgba(255,255,255,0.85);
        font-size: clamp(0.95rem, 2.2vw, 1.15rem); line-height: 1.7;
        margin: 0 0 35px 0; font-weight: 300;
    }

    /* Primary CTA — Giant Call Button */
    .ep-cta-primary {
        display: inline-flex; align-items: center; gap: 10px;
        background: #bc9e52; color: #000; text-decoration: none;
        font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: clamp(1rem, 3vw, 1.3rem);
        padding: 20px 35px; border-radius: 50px; letter-spacing: 1px;
        transition: all 0.3s ease; box-shadow: 0 0 30px rgba(188,158,82,0.3);
        text-transform: uppercase;
        margin-top: 15px !important; margin-bottom: 25px !important;
        max-width: 100%; justify-content: center; text-align: center;
        white-space: normal; overflow-wrap: anywhere;
    }
    .ep-cta-primary:hover { background: #d4b96a; box-shadow: 0 0 50px rgba(188,158,82,0.5); transform: scale(1.03); }

    /* Pulsing glow animation */
    @keyframes ep-pulse { 0%, 100% { box-shadow: 0 0 20px rgba(188,158,82,0.3); } 50% { box-shadow: 0 0 40px rgba(188,158,82,0.6); } }
    .ep-cta-primary { animation: ep-pulse 2.5s infinite; }
    .ep-cta-primary:hover { animation: none; }

    /* Secondary CTA */
    .ep-cta-secondary {
        display: inline-block; margin-top: 15px !important; margin-bottom: 25px !important;
        color: #fff; text-decoration: none; font-family: 'Montserrat', sans-serif;
        font-size: 14px; font-weight: 400; letter-spacing: 1.5px; text-transform: uppercase;
        border: 1px solid rgba(255,255,255,0.4); padding: 14px 30px; border-radius: 40px;
        transition: all 0.3s;
    }
    .ep-cta-secondary:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

    /* Trust badges */
    .ep-trust {
        margin-top: 35px; display: flex; flex-wrap: wrap; justify-content: center; gap: 15px 25px;
    }
    .ep-trust span {
        font-family: 'Lato', sans-serif; font-size: 12px; color: rgba(255,255,255,0.65);
        letter-spacing: 0.5px;
    }
    @media (min-width: 768px) {
        .ep-trust span { font-size: 13px; }
    }

    /* --- SECTION 2: Why Trust --- */
    .ep-section { padding: 70px var(--ep-gutter); text-align: center; }
    .ep-section.dark { background: #0d0d0d; }
    .ep-section.darker { background: #080808; }

    .ep-section-inner { max-width: var(--ep-content-width); margin: 0 auto; }

    .ep-section h2 {
        font-family: 'Roc Grotesk Wide', sans-serif; font-weight: 300;
        color: #fff; font-size: clamp(1.3rem, 3.5vw, 2rem);
        text-transform: uppercase; letter-spacing: 2px; margin: 0 0 50px;
    }
    .ep-section h2::after {
        content: ''; display: block; width: 50px; height: 2px;
        background: #bc9e52; margin: 20px auto 0;
    }

    /* Bullet items */
    .ep-bullets { list-style: none; padding: 0; margin: 0; text-align: left; }
    .ep-bullets li {
        display: flex; gap: 18px; margin-bottom: 35px; align-items: flex-start;
    }
    .ep-bullets .ep-bullet-icon {
        flex-shrink: 0; width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center;
        margin-top: 2px;
    }
    .ep-bullets .ep-bullet-icon img {
        width: 100%; height: auto; opacity: 0.9;
    }
    .ep-bullets h3 {
        font-family: 'Montserrat', sans-serif; font-weight: 600;
        color: #fff; font-size: 1rem; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 1px;
    }
    .ep-bullets p {
        font-family: 'Lato', sans-serif; color: rgba(255,255,255,0.7);
        font-size: 0.95rem; line-height: 1.7; margin: 0;
    }

    @media (min-width: 992px) {
        .ep-bullets { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 35px; }
        .ep-bullets li { margin-bottom: 0; }
    }

    /* --- SECTION 3: Service Cards --- */
    .ep-cards { display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 10px; }
    @media (min-width: 992px) { .ep-cards { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 25px; } }

    .ep-card {
        background: rgba(255,255,255,0.03); border: 1px solid rgba(188,158,82,0.2);
        border-radius: 12px; padding: 35px 25px; text-align: center;
        transition: border-color 0.3s, transform 0.3s;
    }
    .ep-card:hover { border-color: #bc9e52; transform: translateY(-4px); }
    .ep-card-icon {
        width: 40px; height: 3px; background: #bc9e52; margin: 0 auto 20px;
    }
    .ep-card h3 {
        font-family: 'Montserrat', sans-serif; font-weight: 600;
        color: #bc9e52; font-size: 0.95rem; text-transform: uppercase;
        letter-spacing: 1px; margin: 0 0 12px;
    }
    .ep-card p {
        font-family: 'Lato', sans-serif; color: rgba(255,255,255,0.65);
        font-size: 0.9rem; line-height: 1.7; margin: 0;
    }

    /* --- MID-PAGE CTA BANNER --- */
    .ep-mid-cta {
        background: #bc9e52; padding: 40px 20px; text-align: center;
    }
    .ep-mid-cta p {
        font-family: 'Roc Grotesk Wide', sans-serif; font-weight: 300;
        color: #000; font-size: clamp(1rem, 2.5vw, 1.4rem);
        text-transform: uppercase; letter-spacing: 2px; margin: 0 0 18px;
    }
    .ep-mid-cta a {
        display: inline-flex; align-items: center; gap: 8px;
        background: #000; color: #bc9e52; text-decoration: none;
        font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 16px;
        padding: 16px 35px; border-radius: 40px; transition: all 0.3s;
    }
    .ep-mid-cta a:hover { background: #1a1a1a; }

    /* --- SECTION 4: Form --- */
    .ep-form-section {
        background: #0a0a0a;
        position: relative; padding: 80px var(--ep-gutter);
        scroll-margin-top: var(--ep-bar-height);
    }
    .ep-form-layout {
        display: grid; grid-template-columns: minmax(0, 1fr); gap: 40px;
        align-items: center; max-width: var(--ep-content-width); margin: 0 auto;
    }
    .ep-form-photo { grid-row: 2; margin: 0; }
    .ep-form-photo img { display: block; width: 100%; height: auto; aspect-ratio: 1; border-radius: 12px; }
    @media (min-width: 992px) {
        .ep-form-layout { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 60px; }
        .ep-form-photo { grid-row: auto; }
    }

    .ep-form-wrapper {
        position: relative; z-index: 2; width: 100%; min-width: 0; max-width: 480px; margin: 0 auto;
    }
    .ep-form-wrapper h2 {
        font-family: 'Roc Grotesk Wide', sans-serif; font-weight: 300;
        color: #fff; font-size: clamp(1.2rem, 3vw, 1.8rem);
        text-transform: uppercase; letter-spacing: 2px; margin: 0 0 10px;
    }
    .ep-form-wrapper .ep-form-sub {
        font-family: 'Lato', sans-serif; color: rgba(255,255,255,0.7);
        font-size: 0.95rem; line-height: 1.6; margin: 0 0 30px;
    }

    .ep-form input, .ep-form select, .ep-form textarea {
        width: 100%; padding: 16px 8px; margin-bottom: 0;
        border: none; border-bottom: 1px solid rgba(255,255,255,0.3);
        background: transparent; color: #fff;
        font-family: 'Lato', sans-serif; font-size: 16px;
        box-sizing: border-box; border-radius: 0; transition: border-color 0.3s;
        -webkit-appearance: none; appearance: none;
    }
    .ep-form input::placeholder, .ep-form select { color: rgba(255,255,255,0.55); }
    .ep-form select option { background: #111; color: #fff; }
    .ep-form input:focus, .ep-form select:focus { outline: none; border-bottom-color: #bc9e52; }

    .ep-form .ep-form-group { margin-bottom: 22px; text-align: left; }
    .ep-form label { display: none; }

    .ep-form .ep-form-submit {
        background: transparent; color: #fff;
        font-family: 'Montserrat', sans-serif; text-transform: uppercase;
        letter-spacing: 2px; border: 1px solid #fff;
        padding: 18px 50px; border-radius: 40px; font-size: 14px;
        cursor: pointer; width: 100%; max-width: 100%; display: inline-block;
        white-space: normal; overflow-wrap: anywhere;
        transition: all 0.3s; margin-top: 10px;
    }
    .ep-form .ep-form-submit:hover { background: #fff; color: #000; }

    /* --- FOOTER MINI --- */
    .ep-footer {
        background: #000; padding: 25px 20px; text-align: center;
        border-top: 1px solid rgba(188,158,82,0.15);
    }
    .ep-footer p {
        font-family: 'Lato', sans-serif; color: rgba(255,255,255,0.35);
        font-size: 12px; margin: 0; letter-spacing: 0.5px;
    }
    .ep-footer a { color: rgba(255,255,255,0.5); text-decoration: none; }
    .ep-footer a:hover { color: #bc9e52; }

    /* Ocultar checkout del footer en LPs */
    .checkout.btn { display: none !important; }
    .ep-sticky-bar a:focus-visible, .ep-hero a:focus-visible,
    .ep-mid-cta a:focus-visible, .ep-form button:focus-visible {
        outline: 2px solid #bc9e52; outline-offset: 4px;
    }
    @media (prefers-reduced-motion: reduce) {
        .ep-cta-primary { animation: none; }
        .ep-cta-primary, .ep-card { transition: none; }
    }
</style>

<!-- Cierra los divs del menu.php antes de la barra para evitar recortes y colapsos. -->
</div></div>

<!-- ============================================================
     STICKY CALL BAR
     ============================================================ -->
<div class="ep-sticky-bar">
    <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO.png" alt="A1 Security" class="ep-logo" style="filter: brightness(0) invert(1);">
    <a href="tel:+19178283434" onclick="return gtag_report_conversion('tel:917-828-3434');" class="ep-call-btn">
        CALL 24/7: (917) 828-3434
    </a>
</div>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="ep-hero">
    <div class="ep-hero-inner">
        <div class="ep-hero-content">
            <h1>Immediate <span>Executive & VIP</span> Protection in NYC</h1>
            <p class="ep-sub">Elite, highly vetted protection details ready for rapid deployment. Complete discretion and absolute security for executives, high-profile individuals, and emergency escorts.</p>

            <a href="tel:+19178283434" onclick="return gtag_report_conversion('tel:917-828-3434');" class="ep-cta-primary">
                CALL 24/7 DISPATCH: (917) 828-3434
            </a>
            <br>
            <a href="#ep-callback-form" class="ep-cta-secondary">Request Immediate Callback</a>

            <div class="ep-trust">
                <span>✓ 100% Confidential (NDA Compliant)</span>
                <span>✓ Rapid Deployment</span>
                <span>✓ Fully Licensed & Bonded</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 2: Why Trust A1 Security in a Crisis?
     ============================================================ -->
<section class="ep-section dark">
    <div class="ep-section-inner">
        <h2>Uncompromising Security. Absolute Discretion.</h2>
        <ul class="ep-bullets">
            <li>
                <div class="ep-bullet-icon"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Security"></div>
                <div>
                    <h3>Rapid Response</h3>
                    <p>Immediate deployment of armed or unarmed protection details across the New York metropolitan area.</p>
                </div>
            </li>
            <li>
                <div class="ep-bullet-icon"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Security"></div>
                <div>
                    <h3>Elite Personnel</h3>
                    <p>Our operatives are rigorously vetted, highly trained in de-escalation, and operate with high emotional intelligence.</p>
                </div>
            </li>
            <li>
                <div class="ep-bullet-icon"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Security"></div>
                <div>
                    <h3>Low-Profile Operations</h3>
                    <p>We blend seamlessly into your environment, providing impenetrable security without drawing unwanted attention.</p>
                </div>
            </li>
        </ul>
    </div>
</section>

<!-- ============================================================
     MID-PAGE CTA — Interrupt pattern
     ============================================================ -->
<div class="ep-mid-cta">
    <p>Every Minute Matters. Speak With Our Team Now.</p>
    <a href="tel:+19178283434" onclick="return gtag_report_conversion('tel:917-828-3434');">
        (917) 828-3434
    </a>
</div>

<!-- ============================================================
     SECTION 3: Specialized Urgent Services
     ============================================================ -->
<section class="ep-section darker">
    <div class="ep-section-inner">
        <h2>Specialized Urgent Services</h2>
        <div class="ep-cards">
            <div class="ep-card">
                <div class="ep-card-icon"></div>
                <h3>Executive & VIP Protection</h3>
                <p>Tailored security details for CEOs, celebrities, and high-net-worth individuals.</p>
            </div>
            <div class="ep-card">
                <div class="ep-card-icon"></div>
                <h3>Court & Legal Escorts</h3>
                <p>Safe, secure, and discreet transportation and physical protection during legal proceedings.</p>
            </div>
            <div class="ep-card">
                <div class="ep-card-icon"></div>
                <h3>High-Threat Mitigation</h3>
                <p>Immediate physical presence for individuals facing active threats, stalking, or corporate disputes.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 4: Callback Form
     ============================================================ -->
<section class="ep-form-section" id="ep-callback-form">
    <div class="ep-form-layout">
        <figure class="ep-form-photo">
            <img src="<?php echo get_template_directory_uri(); ?>/imagenes/fondos/ep-private-aviation.png" alt="Executive protection team accompanying a client to a private aircraft" width="1200" height="1200" loading="lazy" decoding="async">
        </figure>
        <div class="ep-form-wrapper">
            <h2>Need Immediate Assistance?</h2>
            <p class="ep-form-sub">Leave your number and our dispatch team will call you back within minutes. Discretion is guaranteed.</p>

            <form id="theForm" class="ep-form" action="<?php echo get_site_url(); ?>/?page_id=33" method="post" accept-charset="UTF-8" autocomplete="off">
                <input name="tipo" type="hidden" value="registrarse">
                <input type="hidden" name="hs_google_click_id" id="gclid_field" value="">

                <div class="ep-form-group">
                    <label for="ep-name">Full Name</label>
                    <input id="ep-name" name="firstname" type="text" required placeholder="FULL NAME *">
                </div>
                <div class="ep-form-group">
                    <label for="ep-phone">Phone Number</label>
                    <input id="ep-phone" name="phone" type="tel" required placeholder="PHONE NUMBER *">
                </div>
                <div class="ep-form-group">
                    <label for="ep-service">Service Required</label>
                    <select id="ep-service" name="company" required>
                        <option value="" disabled selected>SERVICE REQUIRED *</option>
                        <option value="Executive Protection">Executive Protection</option>
                        <option value="Court Escort">Court Escort</option>
                        <option value="Emergency Security">Emergency Security</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Hidden fields to satisfy page-thanks.php expected $_POST keys -->
                <input type="hidden" name="email" value="urgent-callback@a1securitynyc.com">
                <input type="hidden" name="message" value="URGENT CALLBACK REQUEST - Executive Protection LP">

                <button class="ep-form-submit" type="submit">Request Confidential Callback</button>
            </form>
        </div>
    </div>
</section>

<!-- ============================================================
     MINI FOOTER
     ============================================================ -->
<div class="ep-footer">
    <p>&copy; <?php echo date('Y'); ?> A1 Security Professionals NYC. All rights reserved. | <a href="<?php echo get_site_url(); ?>/">Home</a></p>
</div>

<!-- ============================================================
     SCRIPTS: HubSpot + GCLID capture + Form submit handler
     ============================================================ -->
<script>
    // Capture GCLID from URL params
    (function() {
        var match = window.location.search.match(/[?&]gclid=([^&]*)/);
        if (match) {
            var field = document.getElementById('gclid_field');
            if (field) field.value = decodeURIComponent(match[1]);
        }
    })();

    // Form submit handler - push to HubSpot before sending
    var theForm = document.getElementById('theForm');
    if (theForm) {
        theForm.addEventListener('submit', function(e) {
            var btn = theForm.querySelector('.ep-form-submit');
            if (btn) {
                btn.innerHTML = 'DISPATCHING...';
                btn.style.opacity = '0.7';
            }
        });
    }
</script>
<?php get_footer(); ?>
