<?php
/*
Template Name: About
*/
?>

<?php get_template_part('header', 'custom'); ?>


<main id="main-content">
    <div class="container AboutContentSubPage">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		   
  			<section class="HeroMaterialsPage HeroSubPage">
	         	<?php  while( have_rows('hero') ) : the_row(); ?>
		        	<picture>
			            <source media="(min-width: 651px)" srcset="<?php echo get_sub_field('image_desktop_hero') ?>">
			            <source media="(max-width: 650px)" srcset="<?php echo get_sub_field('image_mobile_hero') ?>">
			            <img loading="eager" class="heroimg" src="<?php echo get_sub_field('image_desktop_hero') ?>" alt="Hero Materials HPI.">
			        </picture>
		        	<div class="contentHero">
		        		<h1><?php echo get_sub_field('title_hero'); ?></h1>
		        	</div>
                <?php  endwhile; ?>
	        </section>



	        <section class="About">
	         	<?php  while( have_rows('about') ) : the_row(); ?>
	        		<h4 class="TitleAbout"><?php echo get_sub_field('title'); ?></h1>

    				<p class="subContentAbout"><?php echo esc_html(get_sub_field('description')); ?></p>
                    <div class="contentAbout"><?php echo get_sub_field('content'); ?></div>
                <?php  endwhile; ?>
	        </section>


		    </article>
		<?php endwhile; endif; ?>
    </div>
</main>


<?php get_template_part('footer', 'custom'); ?>
