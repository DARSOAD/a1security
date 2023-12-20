<?php
/**
 * Este es un tema personalizado creado por Diego
 */
get_header('page'); ?>
		<section id="contenido" class="pc-centrad-supergrande tb-centrado-grande mv-centrado-super-grande">
			<h1><?php the_title();?></h1>
		<div class="pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px!important;">
        <?php
$args = array(
    'post_type' => 'Clients', // Reemplaza 'Clients' con el nombre de tu tipo de entrada personalizado
    'posts_per_page' => -1,   // Muestra todos los posts, -1 para mostrar todos
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        // Contenido del loop
        the_title('<h2>', '</h2>');
        if (has_post_thumbnail()) {
            the_post_thumbnail(); // Mostrar la imagen destacada
        }
        the_content();
    endwhile;
    wp_reset_postdata(); // Restaura los datos del post original
else :
    // No se encontraron posts
    echo 'No se encontraron entradas.';
endif;
?>

		</div>	
		</section>	
		
</div>	
<?php get_footer(); ?>