<?php
/*
Template Name: Contacts
*/
?>

<?php get_template_part('header', 'custom'); ?>

<main id="main-content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        
	        <section class="HeroSubPage">
	         	<?php  while( have_rows('hero') ) : the_row(); ?>
		        	<picture>
			            <source media="(min-width: 651px)" srcset="<?php echo get_sub_field('image_desktop_hero') ?>">
			            <source media="(max-width: 650px)" srcset="<?php echo get_sub_field('image_mobile_hero') ?>">
			            <img loading="eager" class="heroimg" src="<?php echo get_sub_field('image_desktop_hero') ?>" alt="Hero Contacts HPI.">
			        </picture>
		        	<div class="contentHero">
		        		<h1><?php echo get_sub_field('title_hero'); ?></h1>
		        	</div>
                <?php  endwhile; ?>
	        </section>


	          <section class="ContactContentSubPage contentSubPageGeneric">
	         	<?php  while( have_rows('content_main') ) : the_row(); ?>
	        		<h3 class="subtitlepageGeneric"><?php echo get_sub_field('sub_title'); ?></h3>

	        		<div class="mainContentContactPage">
	        			<div class="firstpartcontentcontactPage">
	        				<?php echo get_sub_field('content'); ?>
	        			</div>
		        	
			        	<div class="contactsform">
			        		<?php echo do_shortcode('[contact-form-7 id="f606dcb" title="Main Contact"]'); ?>
			        	</div>
		        	</div>
                <?php  endwhile; ?>
	        </section>


	   		
	        
	   
	    </article>
	<?php endwhile; endif; ?>
</main>


<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".ContactContentSubPage .contactsform .custom-arrow").addEventListener("click", function () {
        document.querySelector(".wpcf7-submit").click();
    });
});

</script>

<?php get_template_part('footer', 'custom'); ?>
