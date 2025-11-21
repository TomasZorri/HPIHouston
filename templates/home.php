<?php
/*
Template Name: Página de Inicio
*/
?>

<?php get_template_part('header', 'custom'); ?>

<main id="main-content">
    <div class="container HomePage">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		        
		        <section class="HomeHeroPage slick-sliderHero">
		         	<?php  while( have_rows('banners_hero') ) : the_row(); 
		         		$linkbanner = get_sub_field("link_hero"); ?>
		         		<a href="<?php echo isset($linkbanner['url']) ? esc_url($linkbanner['url']) : "#"; ?>" target="<?php echo  esc_attr(isset($linkbanner['target']) ? $linkbanner['target'] : '_self');?>" class="CotentBannerItems">
				        	<picture>
					            <source media="(min-width: 651px)" srcset="<?php echo get_sub_field('image_desktop_hero') ?>">
					            <source media="(max-width: 650px)" srcset="<?php echo get_sub_field('image_mobile_hero') ?>">
					            <img loading="eager" class="heroimg" src="<?php echo get_sub_field('image_desktop_hero') ?>" alt="Hero Banner HPI">
					        </picture>
				        	<div class="contentHero">
				        		<div class="custom-pagination">
				        			<button class="prev-btn">
										<svg height="40px" width="40px" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.05 34.01">
										    <g>
										      <line class="cls-1" x1="34.05" y1="16.79" x2="3.05" y2="16.79"/>
										      <polyline class="cls-1" points="18.88 1.62 3.25 17.22 18.45 32.39"/>
										    </g>
										</svg>
									</button>
				        			<button class="next-btn">
										<svg height="40px" width="40px" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.75 30.59">
										    <g>
										      <line class="cls-1" y1="14.86" x2="31" y2="14.86"/>
										      <polyline class="cls-1" points="16.8 1.62 30.5 15.3 16.8 28.97"/>
										    </g>
										</svg>
				        			</button>
				        		</div>
				        		<h1><?php echo get_sub_field('title'); ?></h1>
				        	</div>
			        	</a>
                    <?php  endwhile; ?>
		        </section>


		   		<section class="learnMore">
                    <div class="mainlearnMore">
			         	<?php  while( have_rows('learn_more') ) : the_row(); ?>
                            <h4><?php echo get_sub_field("title") ?></h4>
                            <p><?php echo get_sub_field("content") ?></p>
                    	<?php  endwhile; ?>
                    </div>
		        </section>




		        <section class="gallery">
		         	<?php  while( have_rows('project_galleries') ) : the_row(); ?>
                        <div class="contenido"> 
                            <h4><?php echo get_sub_field("title") ?></h4>
                        </div>   
                        <!-- falta las iamgenes -->
                        <div class="contentGallery">
    <?php
    $count = 0;
    while (have_rows('galleries')) : the_row();
        $count++;
        $image = get_sub_field('image');
        $content = get_sub_field('description');
        $linkService = get_sub_field('link');
        $link_url = isset($linkService['url']) ? esc_url($linkService['url']) : '';
        $link_target = isset($linkService['target']) ? esc_attr($linkService['target']) : '_self';

        if ($count === 1) {
            echo '<div class="grouped-images">';
        } elseif ($count === 3) {
            echo '<div class="single-image hovergalleryitems">';
        } elseif ($count === 4) {
            echo '<div class="third-section">';
        } elseif ($count === 5) {
            echo '<div class="third-section-group">';
        }
        ?>
        <div class="gallery-item hovergalleryitems">
            <img loading="lazy" class="heroimg" src="<?php echo $image; ?>" alt="Hero Banner HPI">
            <div class="contenthovergalleryitem">
                <p><?php echo $content; ?></p>
                <?php if ($link_url) : ?>
                    <a class="linksgallery" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.8 15.03">
                            <g>
                                <line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" y1="7.52" x2="15.2" y2="7.52"></line>
                                <polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" points="8.48 .8 15.2 7.52 8.48 14.24"></polyline>
                            </g>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        if ($count === 2) {
            echo '</div>'; // Cierra .grouped-images
        } elseif ($count === 3) {
            echo '</div>'; // Cierra .single-image
        }  elseif ($count === 6) {
            echo '</div>'; // Cierra .third-section-group
            echo '</div>'; // Cierra .third-section
        }
    endwhile;
    // Asegurarse de cerrar los divs si el bucle termina antes de 6 elementos
    if ($count === 1) echo '</div>'; // Cierra .grouped-images si solo hay 1 elemento
    if ($count >= 4 && $count < 6) echo '</div></div>'; // Cierra .third-section-group y/o .third-section si faltan elementos
    ?>
</div>
                        <!-- fin de las imagenes-->
                        <div class="contenido"> 
                            <p class="contentgallery"><?php echo get_sub_field("description"); ?></p>

                            <div class="contentButtons">
								<?php 
								$linkService = get_sub_field('link_services');
								if(isset($linkService['url'], $linkService['title'])): ?>
								    <a class="linksgallery" href="<?php echo esc_url($linkService['url']);?>" target="<?php echo esc_attr(isset($linkService['target']) ? $linkService['target'] : '_self');?>"><?php echo esc_html($linkService['title']);?></a>
								<?php endif; ?>
								<?php 
								$linkMaterias = get_sub_field('link_materials');
								if(isset($linkMaterias['url'], $linkMaterias['title'])): ?>
								    <a class="linksgallery" href="<?php echo esc_url($linkMaterias['url']);?>" target="<?php echo esc_attr(isset($linkMaterias['target']) ? $linkMaterias['target'] : '_self');?>"><?php echo esc_html($linkMaterias['title']);?></a>
								<?php endif; ?>
                            </div>
                        </div> 
                    <?php  endwhile; ?>
		        </section>

				<section class="infopanels slick-infopanels">
				    <?php if( have_rows('information_panels') ): while( have_rows('information_panels') ): the_row(); ?>
				        <?php if( have_rows('panel_main_info') ): while( have_rows('panel_main_info') ): the_row(); ?>
				            <div class="backgroundImagePanel" style="background: url('<?php echo esc_url(get_sub_field('background_panel')); ?>');">
				                <img class="LogoPanelImage" src="<?php echo esc_url(get_sub_field('title_image')); ?>" alt="Panel Image">
				        <?php endwhile; endif; ?>

				        		<div class="contentMobilePaginations custom-pagination">
			                        <button class="prev-btn">
										<svg height="40px" width="40px" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.95 32.78">
										    <g>
										      <line class="cls-1" x1="34.95" y1="16.73" x2="3.95" y2="16.73"/>
										      <polyline class="cls-1" points="18.12 1.73 3.47 16.39 18.12 31.04"/>
										    </g>
										</svg>
			                        </button>
			                        <button class="next-btn">
			                            <svg height="40px" width="40px"  data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.22 32.78">
										    <g>
										      <line class="cls-1" y1="16.73" x2="31" y2="16.73"/>
										      <polyline class="cls-1" points="16.09 1.73 30.75 16.39 16.09 31.04"/>
										    </g>
										</svg>
			                        </button>
		                    	</div>

						        <div class="contentitemspanels">
					                <?php if( have_rows('panels') ): while( have_rows('panels') ): the_row(); ?>
					                    <a class="itemscontentitemspanels" href="<?php echo esc_url(get_sub_field('panels_links')); ?>">
					                        <img src="<?php echo esc_url(get_sub_field('image_panel')); ?>" alt="Panel Image">
					                        <h6 class="titlespanels"><?php echo esc_html(get_sub_field('title_panel')); ?></h6>
					                        <p class="contentpanels"><?php echo esc_html(get_sub_field('panel_description')); ?></p>
					                    </a>
					                <?php endwhile; endif; ?>
						        </div>

				        <?php if( have_rows('panel_main_info') ): while( have_rows('panel_main_info') ): the_row(); 
				        	$colorsLinks = (trim(get_sub_field("color_button")) != "" ? get_sub_field("color_button") : "transparent");
				        	?>
				                <div class="ButtonsPrincipalPanel">
				                	<div class="mainButtonsPrincipalPanel">
				        				<?php if( have_rows('link_panel') ): while( have_rows('link_panel') ): the_row(); ?>
					                        <?php 
					                            $linkMainPanel = get_sub_field('link');
					                            if( isset($linkMainPanel['url'], $linkMainPanel['title']) ): ?>
					                                <a class="linkpanelmain" href="<?php echo esc_url($linkMainPanel['url']); ?>" 
					                                   target="<?php echo esc_attr(isset($linkMainPanel['target']) ? $linkMainPanel['target'] : '_self'); ?>" style="background: <?php echo $colorsLinks ?>">
					                                   	<img src="<?php echo esc_url(get_sub_field('image_link')); ?>"> 
					                                    <?php echo esc_html($linkMainPanel['title']); ?>
					                                </a>
					                        <?php endif; ?>
				    					<?php endwhile; endif; ?>

					                    <div class="custom-pagination">
					                        <button class="prev-btn">
												<svg height="40px" width="40px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 34.95 32.78">
												  <defs>
												    <filter id="drop-shadow-1" filterUnits="userSpaceOnUse">
												      <feOffset dx="1" dy="1"/>
												      <feGaussianBlur result="blur" stdDeviation="2"/>
												      <feFlood flood-color="#000" flood-opacity=".4"/>
												      <feComposite in2="blur" operator="in"/>
												      <feComposite in="SourceGraphic"/>
												    </filter>
												  </defs>
												  <g style="filter: url(#drop-shadow-1);">
												    <line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 4.91px;" x1="34.95" y1="16.73" x2="3.95" y2="16.73"/>
												    <polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 4.91px;" points="18.12 1.73 3.47 16.39 18.12 31.04"/>
												  </g>
												</svg>
					                        </button>
					                        <button class="next-btn">
												<svg height="40px" width="40px"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 34.22 32.78">
												  <defs>
												    <filter id="drop-shadow-1" filterUnits="userSpaceOnUse">
												      <feOffset dx="1" dy="1"/>
												      <feGaussianBlur result="blur" stdDeviation="2"/>
												      <feFlood flood-color="#000" flood-opacity=".4"/>
												      <feComposite in2="blur" operator="in"/>
												      <feComposite in="SourceGraphic"/>
												    </filter>
												  </defs>
												  <g style="filter: url(#drop-shadow-1);">
												    <line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 4.91px;" y1="16.73" x2="31" y2="16.73"/>
												    <polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 4.91px;" points="16.09 1.73 30.75 16.39 16.09 31.04"/>
												  </g>
												</svg>
					                        </button>
				                    	</div>
				                    </div> 
				                </div>
				            </div>
				        <?php endwhile; endif; ?>
				    <?php endwhile; endif; ?>
				</section>
		    </article>
		<?php endwhile; endif; ?>
    </div>
</main>

<script type="text/javascript">
$(document).ready(function(){
    var $slider = $('.slick-sliderHero');

    $slider.slick({
        slidesToShow: 1,  // Muestra solo 1 slide en todas las resoluciones
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 3000,
        infinite: true,
        arrows: false,
        centerMode: false,
        responsive: [
            {
                breakpoint: 768, // En móvil también muestra 1 solo slide
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // Evitar que los botones activen el enlace de fondo
    $('.HomeHeroPage .prev-btn, .HomeHeroPage .next-btn').on('click', function(event){
        event.preventDefault();  // Evita la acción predeterminada
        event.stopPropagation(); // Detiene la propagación al <a>
    });

    // Evento de navegación del slider
    $('.HomeHeroPage .prev-btn').on('click', function(){
        $slider.slick('slickPrev');
    });

    $('.HomeHeroPage .next-btn').on('click', function(){
        $slider.slick('slickNext');
    });
	
	// Navegación con flechas del teclado
    $(document).on('keydown', function(e) {
        if (e.key === "ArrowLeft") {
            $slider.slick('slickPrev');
        } else if (e.key === "ArrowRight") {
            $slider.slick('slickNext');
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    var $slider = $('.slick-infopanels');

    $slider.slick({
        slidesToShow: 1, 
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 3000,
        infinite: true,
        arrows: false,
        centerMode: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });


    // Evento de navegación del slider
    $('.slick-infopanels .prev-btn').on('click', function(){
        $slider.slick('slickPrev');
    });

    $('.slick-infopanels .next-btn').on('click', function(){
        $slider.slick('slickNext');
    });
});
</script>




<?php get_template_part('footer', 'custom'); ?>
