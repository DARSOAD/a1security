<?php
/**
 * Este es un tema personalizado creado por Diego
 */
get_header('page'); ?>
		<section id="contenido">
			<h1><?php the_title();?></h1>
		<div class="contenedorTarjetas">
            
        
           
            <?php
                $args = array(
                    'post_type' => 'Clients', // Reemplaza 'Clients' con el nombre de tu tipo de entrada personalizado
                    'posts_per_page' => -1,   // Muestra todos los posts, -1 para mostrar todos
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        // Contenido del loop
                        ?> 
                        <div class="tarjetaClientes">
                            <div class="imagenCliente">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="contenidoCliente">
                                <h1> <?php echo  get_the_title(); ?> </h1>
                                <p><?php echo  get_the_content(); ?></p>
                            </div>
                            
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata(); // Restaura los datos del post original
                else :
                    // No se encontraron posts
                    echo 'No se encontraron entradas.';
                endif;
            ?>
        


		</div>	
		</section>	
		

<?php get_footer(); ?>