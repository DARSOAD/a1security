<?php
/**
 * Blog index template (used for the Posts page)
 */
get_header('page'); ?>

<section id="contenido" class="pc-centrad-supergrande tb-centrado-grande mv-centrado-super-grande">
    <h1 style="margin-bottom: 30px; color: #7f7e7e; font-family: 'Lato',sans-serif; text-align: center;">Our Blog</h1>
    
    <div class="pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px!important;">
        
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 40px; margin-top: 20px;">
            <?php 
            if (have_posts()) :
                while (have_posts()) :
                    the_post();	
                    ?>
                    <article class="tarjeta-blog" style="background: #fff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="imagen-blog" style="width: 100%; height: 200px; overflow: hidden;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:100%; object-fit:cover; display:block;')); ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Fallback for posts without image -->
                            <div class="imagen-blog-fallback" style="width: 100%; height: 10px; background-color: #ba007c;"></div>
                        <?php endif; ?>
                        
                        <div style="padding: 25px; display: flex; flex-direction: column; flex-grow: 1;">
                            <h2 style="margin: 0 0 10px 0; font-size: 1.4em; font-weight: bold; line-height: 1.3;">
                                <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;"><?php the_title(); ?></a>
                            </h2>
                            <div class="meta" style="color: #888; font-size: 0.9em; margin-bottom: 15px;">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="extracto" style="color: #666; line-height: 1.6; margin-bottom: 20px; flex-grow: 1;">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                            </div>
                            <div>
                                <a href="<?php the_permalink(); ?>" style="display: inline-block; color: #fff; background-color: #ba007c; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 0.9em; transition: 0.3s opacity;">Read More</a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
                </div>
                
                <div class="paginacion" style="margin-top: 50px; text-align: center;">
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '&laquo; Prev',
                        'next_text' => 'Next &raquo;',
                        'screen_reader_text' => ' '
                    ));
                    ?>
                    <style>
                        .paginacion .nav-links { display: flex; justify-content: center; gap: 10px; }
                        .paginacion .page-numbers { padding: 8px 15px; border: 1px solid #ddd; color: #333; border-radius: 4px; text-decoration: none; }
                        .paginacion .page-numbers.current { background: #ba007c; color: white; border-color: #ba007c; }
                    </style>
                </div>
            <?php
            else :
                echo '<p style="text-align:center;">No posts found.</p>';
                echo '</div>';
            endif;
            ?>

    </div>	
</section>	
		
<?php get_footer(); ?>
