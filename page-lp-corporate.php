<?php
/**
 * Template Name: Landing Page - Corporate
 */
get_header();
?>
<!-- CSS exactos que usa la homepage -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/letra.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bloque3.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/componentColl.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/banner-full-screen.css">
<style>
    /* Fondos del hero */
    #bloque1 { background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/bloque1.jpg") !important; }
    @media (max-width: 1199px) {
        #bloque1 { background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/Portada_inicio-mv.jpg") !important; }
    }

    /* === POSICIONAMIENTO HERO — copiado exacto de main.css que solo carga en homepage === */
    #bloque1 h1 { position: absolute; font-family: 'Roc Grotesk Wide Bold', sans-serif !important; font-weight: 900; font-size: 50px; }
    #bloque1 h3, #bloque1 h2 { position: absolute; font-family: 'Roc Grotesk Wide Bold', sans-serif !important; font-weight: 900; color: #e7d9c4; }
    #bloque1 h2 { margin-top: 50%; margin-left: 5%; text-align: center; }
    #segundoReglonTitulo { color: #bc9e52 !important; margin-top: 55%; margin-left: 5%; }
    #tercerReglonTitulo { margin-top: 66% !important; margin-left: 41% !important; text-decoration: underline; }
    #getInTouchButton { position: absolute; font-family: 'Roc Grotesk Wide', sans-serif !important; font-weight: 300; color: #bc9e52; padding: 15px 45px; border: 2px solid #bc9e52; border-radius: 15px; text-decoration: none; transition: all 0.3s ease-in-out; background: transparent; margin-top: 75% !important; margin-left: 5% !important; }
    @media only screen and (min-width: 768px) {
        #bloque1 h2 { text-align: left; margin-top: 10%; margin-left: 10%; }
        #segundoReglonTitulo { text-align: left; margin-top: 13% !important; margin-left: 10%; }
        #tercerReglonTitulo { margin-top: 17% !important; margin-left: 29% !important; }
        #getInTouchButton { margin-top: 22% !important; margin-left: 10% !important; }
    }
    @media only screen and (min-width: 1200px) {
        #tercerReglonTitulo { margin-top: 22% !important; margin-left: 10% !important; }
        #getInTouchButton { margin-top: 25% !important; margin-left: 10% !important; }
    }

    /* === MÓVIL: altura calculada para imagen 800x1200 (ratio 1.5) === */
    /* Fórmula: ancho_pantalla × 1.5 × 1.01 */
    @media only screen and (max-width: 767px) and (min-width: 700px) { #bloque1 { height: 1071px !important; } }
    @media only screen and (max-width: 699px) and (min-width: 600px) { #bloque1 { height: 955px !important; } }
    @media only screen and (max-width: 599px) and (min-width: 500px) { #bloque1 { height: 835px !important; } }
    @media only screen and (max-width: 499px) and (min-width: 400px) { #bloque1 { height: 680px !important; } }
    @media only screen and (max-width: 399px) and (min-width: 350px) { #bloque1 { height: 577px !important; } }
    @media only screen and (max-width: 349px)                        { #bloque1 { height: 508px !important; } }
    
    /* Ocultar checkout del footer en LPs */
    .checkout.btn { display: none !important; }

    /* === BLOQUE3: misma imagen de fondo que la homepage === */
    #bloque3 {
        background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/inicio_bloque3_pc.jpg") !important;
        background-size: 100% !important;
        background-repeat: no-repeat !important;
        background-position: top !important;
    }
    @media only screen and (max-width: 767px) {
        #bloque3 {
            background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/inicio_bloque3_mv.jpg") !important;
        }
    }

    @media only screen and (max-width: 767px) {
        #bloque1 {
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: flex-start !important;
            padding: 30% 8% 10% 8% !important;
            box-sizing: border-box !important;
        }
        #bloque1 h2,
        #bloque1 h1,
        #bloque1 h3,
        #segundoReglonTitulo,
        #tercerReglonTitulo,
        #getInTouchButton {
            position: relative !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            margin-bottom: 12px !important;
            width: 100% !important;
            max-width: 100% !important;
            word-break: break-word !important;
        }
        #bloque1 h2 { font-size: 5vw !important; text-align: left !important; }
        #segundoReglonTitulo { font-size: 10vw !important; text-align: left !important; line-height: 1.1 !important; }
        #tercerReglonTitulo { font-size: 4.5vw !important; text-align: left !important; text-decoration: underline !important; }
        #getInTouchButton {
            display: inline-block !important;
            width: auto !important;
            max-width: 100% !important;
            font-size: 3.5vw !important;
            padding: 10px 20px !important;
            margin-top: 15px !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
    }
    /* === BLOCKS 2 & 3: centrado + animacion de entrada === */
    .a1-block { padding: 70px 10%; background: #fff; text-align: center; opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
    .a1-block.a1-visible { opacity: 1; transform: translateY(0); }
    .a1-block:nth-of-type(2) { transition-delay: 0.15s; }

    /* === BLOCK 1.5: Trusted By — Flip Cards === */
    .a1-trusted-by { padding: 55px 10%; background: #f8f6f2; border-top: 1px solid #e8e4de; border-bottom: 1px solid #e8e4de; text-align: center; }
    .a1-trusted-by .a1-block-inner::before { display: none; }
    .a1-trusted-label { font-family: 'Lato', sans-serif; font-size: 0.8em; text-transform: uppercase; letter-spacing: 4px; color: #999; margin: 0 0 35px 0 !important; }

    /* Contenedor de las cards */
    .a1-logo-strip { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 20px; }

    /* Flip card */
    .a1-flip-card { width: 160px; height: 120px; perspective: 800px; cursor: pointer; }
    @keyframes autoFlip {
        0%, 35% { transform: rotateY(0deg); }
        45%, 80% { transform: rotateY(180deg); }
        90%, 100% { transform: rotateY(0deg); }
    }
    .a1-flip-inner {
        position: relative; width: 100%; height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 8px;
        animation: autoFlip 12s infinite;
    }
    /* Stagger the animations so they flip at different times */
    .a1-flip-card:nth-child(2) .a1-flip-inner { animation-delay: -3s; }
    .a1-flip-card:nth-child(3) .a1-flip-inner { animation-delay: -6s; }
    .a1-flip-card:nth-child(4) .a1-flip-inner { animation-delay: -9s; }

    /* Hover forces the flip and pauses the auto-animation */
    .a1-flip-card:hover .a1-flip-inner { animation: none; transform: rotateY(180deg); }

    /* Caras */
    .a1-flip-front, .a1-flip-back {
        position: absolute; width: 100%; height: 100%;
        backface-visibility: hidden; -webkit-backface-visibility: hidden;
        border-radius: 8px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    /* Frente: logo del cliente */
    .a1-flip-front { background: #fff; padding: 18px; }
    .a1-flip-front img { max-width: 100%; max-height: 70px; object-fit: contain; }

    /* Reverso: escudo A1 + nombre */
    .a1-flip-back {
        background: #1a2333;
        transform: rotateY(180deg);
        padding: 12px;
        gap: 8px;
    }
    .a1-flip-back img { width: 40px; height: auto; opacity: 0.9; }
    .a1-flip-back span {
        font-family: 'Lato', sans-serif;
        font-size: 0.72em;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #D4AF37;
        text-align: center;
        line-height: 1.3;
    }

    @media (max-width: 767px) {
        .a1-flip-card { width: 130px; height: 100px; }
        .a1-flip-front img { max-height: 55px; }
        .a1-flip-back img { width: 32px; }
        .a1-flip-back span { font-size: 0.65em; }
    }
    .a1-block.dark { background: #f4f4f4; }
    .a1-block-inner { max-width: 820px; margin: 0 auto; }
    .a1-block-inner::before { content: ''; display: block; width: 60px; height: 3px; background: #D4AF37; margin: 0 auto 30px; }
    .a1-block h2 { font-family: 'Roc Grotesk Wide Bold', sans-serif; text-transform: uppercase; color: #D4AF37; font-size: clamp(1.8em, 3.5vw, 2.8em); margin: 0 0 25px 0; line-height: 1.2; }
    .a1-block p { font-family: 'Lato', sans-serif; font-size: 1.15em; line-height: 1.8; color: #555; margin: 0 0 15px 0; }
    .a1-block ul { font-family: 'Lato', sans-serif; font-size: 1.15em; line-height: 1.8; color: #555; padding-left: 0; list-style: none; margin: 0; text-align: left; }
    .a1-block ul li { padding: 12px 0 12px 35px; position: relative; border-bottom: 1px solid #e0e0e0; }
    .a1-block ul li::before { content: "✓"; color: #D4AF37; position: absolute; left: 0; font-weight: bold; font-size: 1.2em; }
</style>

<script>
/* Intersection Observer: activa la animación cuando el bloque entra en pantalla */
document.addEventListener('DOMContentLoaded', function() {
    var blocks = document.querySelectorAll('.a1-block');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) { entry.target.classList.add('a1-visible'); observer.unobserve(entry.target); }
        });
    }, { threshold: 0.15 });
    blocks.forEach(function(block) { observer.observe(block); });
});
</script>

<!-- HERO -->
<h2>UNCOMPROMISING SECURITY</h2>
<h1 id='segundoReglonTitulo'>FOR CLASS A <br> PROPERTIES</h1>
<h3 id='tercerReglonTitulo'>FDNY CERTIFIED. MANHATTAN TRUSTED.</h3>
<a href="#lp-form" id="getInTouchButton" class="btn-hero">SCHEDULE A PROPERTY ASSESSMENT</a>

</div></div>

<!-- BLOCK 1.5: Trusted By — Logo Strip -->
<div class="a1-block a1-trusted-by">
    <div class="a1-block-inner">
        <p class="a1-trusted-label">Trusted by NYC's Leading Properties</p>
        <div class="a1-logo-strip">
            <!-- Leica Store -->
            <div class="a1-flip-card">
                <div class="a1-flip-inner">
                    <div class="a1-flip-front"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/logos-clientes/Leica_Camera_logo.png" alt="Leica Store"></div>
                    <div class="a1-flip-back">
                        <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Shield">
                        <span>Leica Store</span>
                    </div>
                </div>
            </div>
            <!-- Santoni -->
            <div class="a1-flip-card">
                <div class="a1-flip-inner">
                    <div class="a1-flip-front"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/logos-clientes/Santoni.png" alt="Santoni"></div>
                    <div class="a1-flip-back">
                        <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Shield">
                        <span>Santoni</span>
                    </div>
                </div>
            </div>
            <!-- Modern MD -->
            <div class="a1-flip-card">
                <div class="a1-flip-inner">
                    <div class="a1-flip-front"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/logos-clientes/Modern-MD-Logo.png" alt="Modern MD"></div>
                    <div class="a1-flip-back">
                        <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Shield">
                        <span>Modern MD</span>
                    </div>
                </div>
            </div>
            <!-- Radio Hotel -->
            <div class="a1-flip-card">
                <div class="a1-flip-inner">
                    <div class="a1-flip-front"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/logos-clientes/RadioHotel.webp" alt="Radio Hotel"></div>
                    <div class="a1-flip-back">
                        <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO_ESCUDO.png" alt="A1 Shield">
                        <span>Radio Hotel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BLOCK 2: Core Competencies -->
<div class="a1-block">
    <div class="a1-block-inner">
        <h2>Core Competencies.</h2>
        <ul>
            <li><strong>FDNY F-01 Certified Fire Guards:</strong> Full compliance and readiness for your building's safety protocols.</li>
            <li><strong>Impeccable Access Control:</strong> Advanced lobby management that is strict on security but warm and welcoming for your tenants.</li>
            <li><strong>Risk Mitigation &amp; PR Protection:</strong> De-escalation experts who handle incidents discreetly, protecting your property's pristine reputation.</li>
        </ul>
    </div>
</div>

<!-- BLOCK 3: The Corporate Standard -->
<div class="a1-block dark">
    <div class="a1-block-inner">
        <h2>Executive-Level Presence.</h2>
        <p>Your lobby is the first impression of your building. Our officers are hand-selected, rigorously vetted, and trained in corporate etiquette to perfectly match the prestige of your address.</p>
    </div>
</div></div>

<!-- BLOCK 4: Form — mismo #bloque3 con imagen de fondo igual que la homepage -->
<div id="bloque3" class="banner-full-screen" id="lp-form">
    <h3 id="titulobloque3" class="letra27pt-pc letra5-5pt-mv tipografiaPuno negrillaTres centrado">INVISIBLE HANDOFFS, VISIBLE RESULTS.</h3>
    <p id="subtitulobloque3" class="letra18pt-pc letra3pt-mv tipografiaPdos centrado">We manage the transition seamlessly. Let's get started.</p>
    <form id="theForm" class="simform" action="<?php echo get_site_url(); ?>/?page_id=33" method="post" accept-charset="UTF-8" autocomplete="off">
        <input name="tipo" type="hidden" value="registrarse">
        <input type="hidden" name="hs_google_click_id" id="gclid_field" value="">
        <div class="simform-inner">
            <ol class="questions">
                <li class="current"><span><label for="c1">Company / Building Name</label></span><input id="c1" name="company" type="text"></li>
                <li><span><label for="c2">Phone number</label></span><input id="c2" name="phone" type="text"></li>
                <li><span><label for="c3">Work Email</label></span><input id="c3" name="email" type="text"></li>
                <li><span><label for="c4">Your Name</label></span><input id="c4" name="firstname" type="text"></li>
                <li><span><label for="c6">Additional information</label></span><input id="c6" name="message" type="text"></li>
            </ol>
            <button class="submit" type="submit">Submit</button>
            <div class="controls">
                <button class="next show"></button>
                <div class="progress"></div>
                <span class="number"><span class="number-current">1</span><span class="number-total">5</span></span>
                <span class="error-message"></span>
            </div>
        </div>
        <span class="final-message"></span>
    </form>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/classie.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/stepsForm.js"></script>
<script>
    var theForm = document.getElementById('theForm');
    if(theForm) {
        // Interceptar el envío nativo en caso de que le den clic al botón "Submit" directamente
        theForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el envío temporalmente
            console.log('✅ Evento "submit" nativo interceptado (Corporate)');
            
            var email = theForm.querySelector('[name="email"]').value;
            var nombre = theForm.querySelector('[name="firstname"]').value;
            var empresa = theForm.querySelector('[name="company"]').value;
            var telefono = theForm.querySelector('[name="phone"]').value;
            var gclid = theForm.querySelector('#gclid_field').value;

            var _hsq = window._hsq = window._hsq || [];
            console.log('📡 Empujando datos a _hsq:', { email: email, hs_google_click_id: gclid });
            _hsq.push(["identify", {
                email: email, firstname: nombre, company: empresa, phone: telefono, hs_google_click_id: gclid
            }]);
            _hsq.push(["trackPageView"]);

            // Reanudar el envío después de dar tiempo a HubSpot
            setTimeout(function() {
                theForm.submit();
            }, 1000);
        });

        // Configuración original de stepsForm
        new stepsForm(theForm, {
            onSubmit: function(form) {
                console.log('✅ onSubmit de stepsForm disparado (Corporate)');
                classie.addClass(theForm.querySelector('.simform-inner'), 'hide');
                
                // Simular el submit para que nuestro event listener nativo lo capture
                theForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));

                var messageEl = theForm.querySelector('.final-message');
                if(messageEl) {
                    messageEl.innerHTML = 'Thank you! We will be in touch shortly.';
                    classie.addClass(messageEl, 'show');
                }
            }
        });
    }
</script>
<?php get_footer(); ?>
