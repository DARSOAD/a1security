<?php
/**
 * The home.php template.
 *
 * The template to display the home.php content.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */
get_header(); ?>
				<h2>YOUR TRUSTED</h2>
				<h1 id='segundoReglonTitulo'>SECURITY PARTNER</h1>
				<h2 id='tercerReglonTitulo'>IN NEW YORK CITY</h2>
				
				<!-- <img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/neon_like.webp" alt="Neon Like" id="NeonLike" > -->
			</div>	

			<div id="bloque4">
				<!--<a href=""> 
					<button class="botonescarrusel" id="botoncomida" type="button"> COMIDA </button>
					<button class="botonescarrusel" id="botonmedicamentos" type="button"> MEDICAMENTOS </button>
					<button class="botonescarrusel" id="botonaccesorios" type="button"> ACCESORIOS </button>
				</a>-->
					<div class="conocenos"> <p>Services</p> <span> &#10140; </span></div>
				<!-------------------CARRUSEL---------------->
				<div class="owl-carousel">
					<?php
					query_posts('post_type=post');
					while ( have_posts() ) : the_post(); ?>
					<div class="item">	
						<figure class="producto">
							<a href="<?php the_permalink() ?>"><?php the_post_thumbnail();?></a>
							<a href="<?php the_permalink() ?>"><figcaption> <p class="letra30pt-pc letra4-5pt-mv"><?php the_title();?></strong> </figcaption></a>
							<a href="<?php the_permalink() ?>" class="pc"><h2 class="letra18pt-pc"> <?php echo get_excerpt(200);?> </h2></a>
							<a href="<?php the_permalink() ?>" class="tablet celular"><h2 class="letra3pt-mv"> <?php echo get_excerpt(40);?> </h2></a>
						</figure>	
						<figure class="iconolike">
							<img src="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/like.png" alt="like">
						</figure>
					</div>
					<?php endwhile; ?>		
				</div>
				<!-------------------CARRUSEL---------------->
			</div>		

			<div id="bloque3" class="banner-full-screen">
				<h3 id="titulobloque3" class="letra27pt-pc letra5-5pt-mv tipografiaPuno negrillaTres centrado"> READY TO BOOST YOUR SECURITY? </h3>	
				<p id="subtitulobloque3" class="letra18pt-pc letra3pt-mv tipografiaPdos centrado"> Let's Get Started! </p>
				<!-------------------FORMULARIO PASOS---------------->
				<form id="theForm" class="simform" action="<?php echo get_site_url(); ?>/?page_id=33" method="post" accept-charset="UTF-8" autocomplete="off">
					<input name="tipo" type="hidden"  value="registrarse">
					<div class="simform-inner">
						<ol class="questions">
							<li class="current">
								<span><label for="q1">Company name </label></span>
								<input id="q1" name="empresa" type="text">
							</li>
							<li>
								<span><label for="q2"> Phone number</label></span>
								<input id="q2" name="telefono" type="text">
							</li>
							<li>
								<span><label for="q3"> Email </label></span>
								<input id="q3" name="correo" type="text">
							</li>
							<li>
								<span><label for="q4"> Name </label></span>
								<input id="q4" name="nombre" type="text">
							</li>
							<li>
								<span><label for="q6"> Additional information</label></span>
								<input id="q6" name="comentarios" type="text">
							</li>
						</ol>
						<button class="submit" type="submit"> Submit </button>					
						<div class="controls">
							<button class="next"></button>
							<div class="progress"></div>
							<span class="number">
								<span class="number-current"> 1 </span>
								<span class="number-total"> 3 </span>
							</span>
							<span class="error-message"></span>
						</div>
					</div>
					<span class="final-message"></span>
				</form>
				<!-------------------FORMULARIO PASOS---------------->		
			</div>
				
	<?php get_footer(); ?>