<?php
/**
 * Este es un tema personalizado creado por Mainteam
 */
get_header(); ?>
		<section id="contenido">
			<h1><?php the_title();?></h1>
		<div class="pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px!important;">
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