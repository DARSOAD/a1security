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
<h1 id='segundoReglonTitulo'>SECURITY <br> GUARD</h1>
<h3 id='tercerReglonTitulo'>PROVIDER</h3>
<a onclick="return gtag_report_conversion('tel:917-828-3434');"
	href="tel:+19178283434"
	id="getInTouchButton"
	class="btn-hero">
	GET IN TOUCH
</a>

<div id="bloquereviews">
	<div class="swiper mis-testimonios tablet pc">

		<div class="swiper-wrapper ">
			<?php
			$args = array('post_type' => 'Reviews', 'posts_per_page' => -1);
			$query = new WP_Query($args);

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post(); ?>

					<div class="swiper-slide">
						<div class="inner-review">

							<div class="userdetails">
								<div class="imagebox">
									<?php
									if (has_post_thumbnail()) {
										// WordPress traerá la imagen limpia y la estilizaremos en CSS
										the_post_thumbnail('thumbnail');
									}
									?>
								</div>
							</div>

							<div class="content-testimonial">
								<div class="testimonial-det-box">
									<p class="name"><?php the_title(); ?></p>
									<div class="stars">★★★★★</div>
								</div>
								<h4>"<?php echo wp_trim_words(get_the_excerpt(), 40); ?>"</h4>
							</div>

						</div>
					</div>

			<?php endwhile;
				wp_reset_postdata();
			endif; ?>
		</div>

		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>

	<div class="swiper mis-testimonios celular">
		<div class="swiper-wrapper">
			<?php
			$args = array('post_type' => 'Reviews', 'posts_per_page' => -1);
			$query = new WP_Query($args);

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post(); ?>


					<div class="swiper-slide celular">
						<div class="inner-review-celular">

							<div class="content-testimonial">
								<div class="testimonial-det-box">
									<div class="stars">★★★★★</div>
									<p class="name"><?php the_title(); ?></p>
								</div>
								<h4>"<?php echo wp_trim_words(get_the_excerpt(), 40); ?>"</h4>
							</div>

							<div class="userdetails">
								<div class="imagebox">
									<?php
									if (has_post_thumbnail()) {
										// WordPress traerá la imagen limpia y la estilizaremos en CSS
										the_post_thumbnail('thumbnail');
									}
									?>
								</div>
							</div>

						</div>
					</div>

			<?php endwhile;
				wp_reset_postdata();
			endif; ?>
		</div>


		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</div>

</div>
<div id="bloque4">

	<h1 class="tituloServicio letra43pt-pc letra5pt-mv">Our security services</h1>

	<?php
	query_posts('post_type=post');
	while (have_posts()) : the_post(); ?>
		<div class="service">
			<div class="service-header">
				<h3 class="title letra36pt-pc letra5pt-mv"><?php the_title(); ?></h3>
				<button class="toggle-btn">+</button>
			</div>
			<div class="service-details">
				<div class="thumbnaill pc tablet">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="info">
					<h3 class="title letra36pt-pc letra5pt-mv"><?php the_title(); ?></h3>
					<p class="description letra25pt-pc letra4pt-mv"><?php echo get_excerpt(400); ?></p>
					<a href="<?php the_permalink() ?>"> <button class='botones_tres'>More Info</button> </a>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>

<div id="bloque3" class="banner-full-screen">
	<h3 id="titulobloque3" class="letra27pt-pc letra5-5pt-mv tipografiaPuno negrillaTres centrado"> READY TO BOOST YOUR SECURITY? </h3>
	<p id="subtitulobloque3" class="letra18pt-pc letra3pt-mv tipografiaPdos centrado"> Let's Get Started! </p>
	<!-------------------FORMULARIO PASOS---------------->
	<form id="theForm" class="simform" action="<?php echo get_site_url(); ?>/?page_id=33" method="post" accept-charset="UTF-8" autocomplete="off">
		<input name="tipo" type="hidden" value="registrarse">
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
</div>

</div>

<?php get_footer(); ?>