<?php
/**
 * Este es un tema personalizado creado por Diego
 */
get_header('page'); ?>
		<section id="contenido" class="pc-centrad-supergrande tb-centrado-grande mv-centrado-super-grande">
			<h1><?php the_title();?></h1>
		<div class="blog-content pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px!important;">
			<style>
				.blog-content h2 { font-size: 2em; font-weight: bold; margin-top: 40px; margin-bottom: 20px; color: #333; }
				.blog-content h3 { font-size: 1.5em; font-weight: bold; margin-top: 30px; margin-bottom: 15px; color: #444; }
				.blog-content p { font-size: 1.1em; line-height: 1.8; margin-bottom: 25px; color: #555; }
				.blog-content ul, .blog-content ol { margin-bottom: 25px; padding-left: 40px; }
				.blog-content li { font-size: 1.1em; line-height: 1.8; margin-bottom: 10px; color: #555; list-style-type: disc; }
				.blog-content img { max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 25px; }
				.blog-content strong, .blog-content b { font-weight: bold; color: #222; }
			</style>
			<?php 
				while (have_posts()) :
						the_post();	
         				the_content();
   				endwhile;
				?>
		</div>	
		</section>	
		
</div>	
<?php get_footer(); ?>