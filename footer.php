<?php if (!is_page('Carrito') || !is_page('Catalogo')) { ?>
	<div class="cd-cart-container empty">
		<a href="#0" class="cd-cart-trigger">
			<ul class="count tipografiaHuno"> <!-- cart items count -->
				<li>0</li>
				<li>0</li>
			</ul> <!-- .count -->
		</a>

		<div class="cd-cart">
			<div class="wrapper">
				<header>
					<h2 class="letra30pt-pc letra5pt-mv tipografiaHtres negrillaTres">Carrito</h2>
				</header>

				<div class="body">
					<ul>
						<!-- products added to the cart will be inserted here using JavaScript -->
					</ul>
				</div>

				<div id="foot">
					<a href="<?php echo get_site_url(); ?>/carrito" class="checkout btn letra30pt-pc letra5pt-mv tipografiaHtres negrillaTres"><em>Checkout - $<span>0</span></em></a>
				</div>
			</div>
		</div> <!-- .cd-cart -->
	</div> <!-- cd-cart-container -->

<?php } ?>
<div id="bloque5">
	<footer>
		<div id="footerproductos">
			<h3 class="footerh3"> SERVICES </h3>
			<ul class="footerul">

				<?php
				query_posts('post_type=post');
				while (have_posts()) : the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
					</li>

				<?php endwhile; ?>

			</ul>
		</div>
		<div id="googlemaps">
			<a href="<?php echo get_site_url(); ?>/" class=" ">
				<figure class="logo_footer">
					<img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/LOGO.png" alt="Logo A1 security">
				</figure>
			</a>
			<!-- <div id="map"> </div>
							<h3 class="footerh3tienda"> ENCUENTRA EL ALMACEN <span> &#10140; </span> </h3> -->
		</div>
		<div id="footercontacto">
			<h3 class="footerh3"> CONTACT US </h3>
			<ul class="footerul footerul2">
				<li><a href=""> a1securenyc@gmail.com </a></li>
				<li class="pc tablet"><a onclick="return gtag_report_conversion('tel:917-828-3434');" href="tel:+19178283434" target="_blank"> (917) 828-3434 </a></li>
			</ul>
		</div>
		<div id="footerdatoscontacto">
			<ul class="footerul footerul2">
				<!-- <li class="pc"> a1securenyc@gmail.com </li>		 -->

				<!-- <li class="tablet"> a1securenyc@gmail.com  </li> -->

				<li class="celular"><a href="tel:+19178283434" target="_blank"> (917) 828-3434 </a></li>
			</ul>
		</div>
		<div id="movilredes">
			<!-- <figure class="celular redesmovil">
							<a href="https://www.facebook.com/.co/"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/facebook.png" alt="facebook"></a>							
						</figure>
						<figure class="celular redesmovil">
							<a href="https://www.instagram.com/.co/"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/instagram.png" alt="instagram"></a>				
						</figure> -->
			<figure class="celular" id='bbbMovile'>
				<a href="https://www.bbb.org/us/ny/new-york/profile/security/a1-security-professionals-inc-0121-87182708/#sealclick" target="_blank" rel="nofollow">
					<img src="https://seal-newyork.bbb.org/seals/black-seal-293-61-bbb-87182708.png" style="border: 0;" alt="A1 Security Professionals Inc. BBB Business Review" />
				</a>
			</figure>
		</div>
		<div id="redessociales">
			<!-- <figure class="pc">
							<a href="https://www.facebook.com/.co/"><img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/facebook.png" alt="facebook"></a>							
						</figure>	 -->
			<figure class="pc">
				<a href="https://www.bbb.org/us/ny/new-york/profile/security/a1-security-professionals-inc-0121-87182708/#sealclick" target="_blank" rel="nofollow">
					<img id="bbb" src="https://seal-newyork.bbb.org/seals/black-seal-293-61-bbb-87182708.png" style="border: 0;" alt="A1 Security Professionals Inc. BBB Business Review" />
				</a>
			</figure>
		</div>
		<div id="sombra"></div>
		<div id="terminosycondiciones">
			<h4> Copyright &#169; A1 Security Professionals</h4>
			<a href="https://a1securitynyc.com/?page_id=73">
				<h5> Honoring Carlos Stio: Continuing a Legacy of Security Excellence </h5>
			</a>
		</div>


	</footer>
</div>
<!-------------------FORMULARIO PASOS JS---------------->


<script src="<?php echo get_template_directory_uri(); ?>/js/classie.js" async></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/stepsForm.js" async></script>
<!-------------------FORMULARIO PASOS JS---------------->
<!-------------------FORMULARIO JS---------------->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/propellertextfield.js" async></script>
<!-------------------FORMULARIO JS---------------->
<!-------------------CARRO FOOTER JS---------------->
<script src="<?php echo get_template_directory_uri(); ?>/jscarro/main.js" async></script>
<!-------------------CARRO FOOTER JS---------------->
<!-------------------CARRUSEL JS---------------->
<!-------------------También necesita del Jquery---------------->
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.mousewheel.js"></script>
<!-------------------CARRUSEL JS---------------->
<!-------------------MENU PC js---------------->
<script src="<?php echo get_template_directory_uri(); ?>/js/menu_pc.js"></script>
<!-------------------MENU PC js---------------->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" async></script>

<script>
	$(document).ready(function() {
		//reviews

		//servicios
		$(".toggle-btn").click(function() {
			var service = $(this).closest(".service");
			var serviceHeader = service.find(".service-header");
			var serviceDetails = service.find(".service-details");
			var openService = $(".service-details.active");
			var openServiceheader = $(".service-header.activer");

			if (serviceDetails.hasClass("active")) {
				serviceDetails.animate({
					height: '0px'
				}, 500, function() {
					serviceHeader.removeClass("activer");
					serviceDetails.removeClass("active").css('display', 'none');
				});
				$(this).removeClass("cerrar");
			} else {
				if (openService.length > 0) {
					openService.animate({
						height: '0px'
					}, 500, function() {
						openService.removeClass("active").css('display', 'none');
						openService.prev().find(".toggle-btn").removeClass("cerrar");
						openServiceheader.removeClass("activer");
					});
				}
				serviceHeader.addClass("activer");
				serviceDetails.css('display', 'block').addClass("active")
					.animate({
						height: serviceDetails.get(0).scrollHeight
					}, 500);
				$(this).addClass("cerrar");
			}
		});

		$(".close-btn").click(function() {
			var serviceDetails = $(this).closest(".service-details");
			serviceDetails.animate({
				height: '0px'
			}, 500, function() {
				serviceHeader.removeClass("activer");
				serviceDetails.removeClass("active").css('display', 'none');
				serviceDetails.prev().find(".toggle-btn").removeClass("cerrar");
			});
		});

		//custom function to add and remove active class
		$(function() {
			$(".collapse.in").parents(".panel").addClass("active");
			$('a[data-toggle="collapse"]').on('click', function() {
				var objectID = $(this).attr('href');
				var expandale = $(this).attr('data-expandable');
				if (expandale == 'true') {
					if ($(objectID).hasClass('in')) {
						$(objectID).collapse('hide');
					} else {
						$(objectID).collapse('show');
					}
				}
				$accoID = $(this).parents(".panel-group").attr("id");
				$availiblity = $(this).parents(".panel").children(".in").length;
				$expandable = $(this).attr("data-expandable");
				$expanded = $(this).attr("aria-expanded");
				$current = $(this).parent().parent().parent().parent().attr("id");
				if ($expandable == "false") {
					if ($expanded == "true") {
						$("#" + $current + " .active").removeClass("active");
					} else {
						$("#" + $current + " .active").removeClass("active");
						$(this).parents('.panel').addClass("active");
					}
				}
				if ($expandable == "true") {
					if ($expanded == "true") {
						$(this).parents('.panel').addClass("active");
					} else {
						$(this).parents('.panel').removeClass("active");
					}
				}
			});

		});
	});
</script>
<!-------------------MENU movil js---------------->
<!---------------------------------------MENU DESLEGABLE DERECHA------------------->
<script src="<?php echo get_template_directory_uri(); ?>/js/menu_derecha.js"></script>
<!---------------------------------------MENU DESLEGABLE DERECHA------------------->
<?php if (is_home()) { ?>
	<!-------------------CARRUSEL---------------->
	<script>
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			loop: true,
			responsive: {
				0: {
					items: 1
				},
				300: {
					items: 1
				},
				400: {
					items: 1
				},
				500: {
					items: 2
				},
				600: {
					items: 2
				},
				700: {
					items: 2
				},
				992: {
					items: 3
				},
			}
		})
		owl.on('mousewheel', '.owl-stage', function(e) {
			if (e.deltaY > 0) {
				owl.trigger('next.owl');
			} else {
				owl.trigger('prev.owl');
			}
			e.preventDefault();
		});
	</script>
	<!-------------------CARRUSEL---------------->
<?php } ?>
<?php if (is_home() || is_page('Catalogo')) { ?>
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script> <!-- Modernizr -->
<?php } ?>
<?php if (is_home() || is_page('Cotización')) { ?>
	<!-------------------FORMULARIO PASOS JS---------------->
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/classie.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/stepsForm.js"></script>
	<!-------------------FORMULARIO PASOS JS---------------->
	<script src="<?php echo get_template_directory_uri(); ?>/js/propellertextfield.js"></script>
	<!-------------------FORMULARIO JS---------------->
	<!-------------------CARRUSEL JS---------------->
	<!-------------------FORMULARIO PASOS---------------->
	<script>
		var theForm = document.getElementById('theForm');
		new stepsForm(theForm, {
			onSubmit: function(form) {
				// hide form
				classie.addClass(theForm.querySelector('.simform-inner'), 'hide');
				form.submit()
				/*or
				AJAX request (maybe show loading indicator while we don't have an answer..)
				*/

				// let's just simulate something...
				var messageEl = theForm.querySelector('.final-message');
				messageEl.innerHTML = '¡Gracias! Estaremos en contacto.';
				classie.addClass(messageEl, 'show');
			}
		});
	</script>
	<!-------------------FORMULARIO PASOS---------------->

<?php } ?>
<?php if (is_page()) { ?>
	<!-------------------CARRUSEL---------------->
	<script>
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			loop: true,
			autoplay: true,
			autoplayTimeout: 30000,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1
				},
				300: {
					items: 1
				},
				600: {
					items: 1
				},
				992: {
					items: 1
				},
			}
		})
		owl.on('mousewheel', '.owl-stage', function(e) {
			if (e.deltaY > 0) {
				owl.trigger('next.owl');
			} else {
				owl.trigger('prev.owl');
			}
			e.preventDefault();
		});
	</script>
	<!-------------------CARRUSEL---------------->
<?php } ?>
<!-------------------MENU movil js---------------->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" async></script>
<script>
	$(function() {
		$("img.lazy").lazyload();
	});
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
// Usamos JavaScript puro (sin jQuery) para evitar conflictos en tu tema
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.mis-testimonios')) {
        const swiper = new Swiper('.mis-testimonios', {
            loop: true, // Carrusel infinito
            slidesPerView: 1, // 1 en móvil
            spaceBetween: 30, // Espacio entre tarjetas
            autoplay: {
                delay: 4000, // Se mueve solo cada 4 segundos
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },
            breakpoints: {
                768: { slidesPerView: 1 }, // 2 en tablet
                1200: { slidesPerView: 1 } // 3 en PC
            }
        });
    }
});
</script>
</body>

</html>