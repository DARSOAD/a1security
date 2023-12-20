<?php
function get_excerpt($limit, $source = null){

    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'... <a href="'.get_permalink($post->ID).'"></a>';
    return $excerpt;
}
add_post_type_support('page', 'excerpt'); 

function add_thumbnail_support_for_clients() {
    add_theme_support('post-thumbnails', array('Clients'));
}
add_action('after_setup_theme', 'add_thumbnail_support_for_clients');

add_action( 'init', 'create_post_type' );
function create_post_type() {
	$args = array(
	    'labels' => array(
            'name' => __( 'Clients' ),
            'singular_name' => __( 'Client' )
        ),
        'public' => true,
        'has_archive' => true,
		'menu_icon'           => 'dashicons-testimonial', // string
        'supports' => array('title', 'editor', 'thumbnail') // Añadir soporte para miniaturas
	);

	/* Register the post type. */
	register_post_type('Clients', $args);
}

?>
