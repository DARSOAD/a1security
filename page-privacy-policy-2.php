<?php
if (!defined('ABSPATH')) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?>><head>
<meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<style>
body.a1-policy {margin:0;background:#faf8f4;color:#202126;font:normal 18px/1.65 Arial,sans-serif}
.a1-policy main {display:block;position:static;background:#faf8f4;color:#202126;max-width:72ch;margin:auto;padding:2rem clamp(1rem,5vw,3rem) 4rem;overflow-wrap:anywhere}
.a1-policy main :is(p,li,strong,h1,h2,h3) {position:static;height:auto;color:#202126;font-family:inherit;text-transform:none;text-align:left}
.a1-policy main :is(p,li) {font-size:1rem;line-height:1.65}
.a1-policy main h1 {font-size:clamp(2rem,5vw,3rem);line-height:1.15}
.a1-policy main h2 {margin:2rem 0 .5rem;font-size:1.45rem;line-height:1.3}
.a1-policy main a {color:#174e75;text-decoration:underline}
</style></head><body class="a1-policy"><?php wp_body_open(); ?>
<main><a href="<?php echo esc_url(home_url('/')); ?>">A1 Security Professionals</a>
<?php while (have_posts()) : the_post(); ?><h1><?php the_title(); ?></h1><?php the_content(); endwhile; ?>
</main><?php wp_footer(); ?></body></html>
