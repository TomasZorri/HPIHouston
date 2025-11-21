<?php
/*
Template Name: Services
*/
?>

<?php get_template_part('header', 'custom'); ?>

<main id="main-content">
    <div class="ServicesPage">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        
	        <section class="HeroServicesPage HeroSubPage">
	         	<?php  while( have_rows('hero') ) : the_row(); ?>
		        	<picture>
			            <source media="(min-width: 651px)" srcset="<?php echo get_sub_field('image_desktop_hero') ?>">
			            <source media="(max-width: 650px)" srcset="<?php echo get_sub_field('image_mobile_hero') ?>">
			            <img loading="eager" class="heroimg" src="<?php echo get_sub_field('image_desktop_hero') ?>" alt="Hero Services HPI.">
			        </picture>
		        	<div class="contentHero">
		        		<h1><?php echo get_sub_field('title_hero'); ?></h1>
		        	</div>
                <?php  endwhile; ?>
	        </section>

			<section class="Services">
			    <?php
			    $args = array(
			        'post_type' => 'service',
			        'posts_per_page' => -1, // Mostrar todos los posts
			        'meta_key' => '_servicio_orden',
			        'orderby' => 'meta_value_num',
			        'order' => 'ASC'
			    );

			   	// Funciones auxiliares para mostrar items y full items
				function mostrar_items($items) {
				    if (!empty($items)) {
				        echo '<div class="services-grid">';
				        foreach ($items as $service) {
				            echo '<div class="service-item">';
				            
				            // Si existe el link, envolvemos la imagen y el título en <a>
				            $link_start = isset($service['link']['url']) ? '<a href="' . esc_url($service['link']['url']) . '" target="' . esc_attr($service['link']['target'] ?? '_self') . '">' : '';
				            $link_end = isset($service['link']['url']) ? '</a>' : '';

				            // Título con enlace
				            echo $link_start . '<h6 class="subsTitlePageGeneric">' . esc_html($service['title']) . '</h6>' . $link_end;

				            echo '<div class="ContentItemsLinkServices">';

				            // Imagen con enlace
				            echo $link_start . '<img loading="lazy" src="' . esc_url($service['image']) . '" alt="Service Image">' . $link_end;

				            if (isset($service['link']['url'], $service['link']['title'])) {
				                echo '<div class="contentLinksItemServices">';
				                echo '<a class="linksgallery" href="' . esc_url($service['link']['url']) . '" target="' . esc_attr($service['link']['target'] ?? '_self') . '">' . esc_html($service['link']['title']) . '</a>';
				                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.8 15.03"><g><line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" y1="7.52" x2="15.2" y2="7.52"/><polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" points="8.48 .8 15.2 7.52 8.48 14.24"/></g></svg>';
				                echo '</div>';
				            }
				            
				            echo '</div>';
				            echo '</div>';
				        }
				        echo '</div>';
				    }
				}

				function mostrar_full_item($item) {
				    echo '<div class="service-full" style="background: url(' . esc_attr($item['background']) . ');">';
				    echo '<div class="service-item">';

				    // Si existe el link, envolvemos la imagen y el título en <a>
				    $link_start_img = isset($item['link']['url']) ? '<a href="' . esc_url($item['link']['url']) . '" target="' . esc_attr($item['link']['target'] ?? '_self') . '" class="img-link-mobile">' : '';
				    $link_end = isset($item['link']['url']) ? '</a>' : '';

				    // Imagen con enlace y clase personalizada
				    echo $link_start_img . '<img loading="lazy" src="' . esc_url($item['image']) . '" alt="Service Image">' . $link_end;

				    echo '<div>';

				    // Título con enlace
				    $link_start_title = isset($item['link']['url']) ? '<a href="' . esc_url($item['link']['url']) . '" target="' . esc_attr($item['link']['target'] ?? '_self') . '">' : '';
				    echo $link_start_title . '<h6>' . esc_html($item['title']) . '</h6>' . $link_end;

				    if (isset($item['link']['url'], $item['link']['title'])) {
				        echo '<div class="contentLinksItemServices">';
				        echo '<a class="linksgallery" href="' . esc_url($item['link']['url']) . '" target="' . esc_attr($item['link']['target'] ?? '_self') . '">' . esc_html($item['link']['title']) . '</a>';
				        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.8 15.03"><g><line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" y1="7.52" x2="15.2" y2="7.52"/><polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" points="8.48 .8 15.2 7.52 8.48 14.24"/></g></svg>';
				        echo '</div>';
				    }

				    echo '</div>';
				    echo '</div>';
				    echo '</div>';
				}


			    $services = new WP_Query($args);
			    if ($services->have_posts()) :
			        $items = [];
			        $full_items = [];

			        while ($services->have_posts()) : $services->the_post();
			            $mostrar_en_servicios = get_post_meta(get_the_ID(), '_servicio_mostrar_en_servicios', true);
			            $banner_activado = get_post_meta(get_the_ID(), '_servicio_banner_activado', true);
			            $imagen_post = get_post_meta(get_the_ID(), '_servicio_imagen_post', true);
			            $imagen_banner = get_post_meta(get_the_ID(), '_servicio_banner', true);
			            $orden = get_post_meta(get_the_ID(), '_servicio_orden', true);

			            if ($mostrar_en_servicios) {
			                $item = array(
			                    'title' => get_the_title(),
			                    'image' => $imagen_post,
			                    'link' => array(
			                        'url' => get_permalink(),
			                        'title' => 'MORE'
			                    ),
			                    'background' => $imagen_banner,
			                    'is_featured' => $banner_activado
			                );

			                if ($banner_activado) {
			                    if ($orden == 0) {
			                        $full_items[] = $item;
			                    } else {
			                        // Mostrar elementos acumulados antes del banner
			                        mostrar_items($items);
			                        $items = [];
			                        mostrar_full_item($item);
			                    }
			                } else {
			                    $items[] = $item;
			                }
			            }
			        endwhile;

			        // Mostrar los últimos items y los full items con orden 0
			        mostrar_items($items);
			        foreach ($full_items as $full_item) {
			            mostrar_full_item($full_item);
			        }

			        wp_reset_postdata();
			    endif;
			    ?>
			</section>


	    </article>
	</div>
	<?php endwhile; endif; ?>
</main>


<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ServicesPage .Services .service-item svg").forEach(function (svgElement) {
        svgElement.addEventListener("click", function () {
            const parentServiceItem = svgElement.closest(".service-item"); // Encuentra el padre más cercano con la clase .service-item
            const linkElement = parentServiceItem ? parentServiceItem.querySelector("a") : null; // Busca el <a> dentro del padre

            if (linkElement) {
                linkElement.click(); // Simula el clic en el enlace
            }
        });
    });
});
</script>


<?php get_template_part('footer', 'custom'); ?>
