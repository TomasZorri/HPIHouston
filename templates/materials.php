<?php
/*
Template Name: Materials
*/
?>

<?php get_template_part('header', 'custom'); ?>

<main id="main-content">
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


	          <section class="MaterialsContentSubPage contentSubPageGeneric">
	         	<?php  while( have_rows('list_materials') ) : the_row(); ?>
	        		<h3 class="subtitlepageGeneric"><?php echo get_sub_field('sub_title'); ?></h3>

	        		<div class="ListMaterials">
	         			<?php  while( have_rows('bill_of_materials') ) : the_row(); ?>

	        			<div class="itemListMaterials">
	        				<p><?php echo get_sub_field('title'); ?></p>
	        				<span><?php echo get_sub_field('description'); ?></span>
	        			</div>
			        	
               	 		<?php  endwhile; ?>
		        	</div>
                <?php  endwhile; ?>
	        </section>


	           <section class="MaterialsContentSubPage contentSubPageGeneric">
	         	<?php  while( have_rows('more_information') ) : the_row(); ?>
	        		<h3 class="subsTitlePageGeneric"><?php echo get_sub_field('sub_title'); ?></h3>
	        		<div class="contentMoreInfo"><?php echo get_sub_field('content'); ?></div>
                <?php  endwhile; ?>
	        </section>


	   		
	        
	   
	    </article>
	<?php endwhile; endif; ?>
</main>



<?php get_template_part('footer', 'custom'); ?>
