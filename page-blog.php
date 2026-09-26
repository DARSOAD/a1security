<?php
/**
 * Template Name: Blog Page
 * Blog index template (used for the Posts page)
 */
get_header('page'); ?>

<section id="contenido" class="pc-centrad-supergrande tb-centrado-grande mv-centrado-super-grande">
    <h1 style="margin-bottom: 30px; color: #7f7e7e; font-family: 'Lato',sans-serif; text-align: center;">Our Blog</h1>
    
    <div class="pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px!important;">
        
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 40px; margin-top: 20px;">
            <?php 
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'paged' => $paged
            );
            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) :
                    $blog_query->the_post();	
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
                            <div class="imagen-blog-fallback" style="width: 100%; height: 10px; background-color: rgb(255, 219, 88);"></div>
                        <?php endif; ?>
                        
                        <div style="padding: 25px; display: flex; flex-direction: column; flex-grow: 1;">
                            <h2 style="margin: 0 0 10px 0; font-size: 1.4em; font-weight: bold; line-height: 1.3;">
                                <a href="<?php the_permalink(); ?>" style="color: #062132; text-decoration: none;"><?php the_title(); ?></a>
                            </h2>
                            <div class="meta" style="color: #888; font-size: 0.9em; margin-bottom: 15px;">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="extracto" style="color: #666; line-height: 1.6; margin-bottom: 20px; flex-grow: 1;">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                            </div>
                            <div>
                                <a href="<?php the_permalink(); ?>" style="display: inline-block; color: #062132; background-color: rgb(255, 219, 88); padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 0.9em; transition: 0.3s opacity;">Read More</a>
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
                    $total_pages = $blog_query->max_num_pages;
                    if ($total_pages > 1){
                        $current_page = max(1, get_query_var('paged'));
                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $current_page,
                            'total' => $total_pages,
                            'prev_text'    => __('« Prev'),
                            'next_text'    => __('Next »'),
                        ));
                    }
                    ?>
                    <style>
                        .paginacion .nav-links { display: flex; justify-content: center; gap: 10px; }
                        .paginacion .page-numbers { padding: 8px 15px; border: 1px solid #ddd; color: #333; border-radius: 4px; text-decoration: none; }
                        .paginacion .page-numbers.current { background: rgb(255, 219, 88); color: #062132; border-color: rgb(255, 219, 88); }
                    </style>
                </div>
            <?php
                wp_reset_postdata();
            else :
                echo '<p style="text-align:center;">No posts found.</p>';
                echo '</div>';
            endif;
            ?>

    </div>	
</section>	
		
<?php get_footer(); ?>
