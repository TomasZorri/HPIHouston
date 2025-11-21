<?php
/*
Template Name: FAQ
*/
?>

<?php get_template_part('header', 'custom'); ?>


<main id="main-content">
    <div class="container FAQContentSubPage">
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



	        <section class="Questions">
	         	<?php  while( have_rows('faq') ) : the_row(); ?>
		        	<div class="itemsQuestions">
		        		<h4><?php echo get_sub_field('title'); ?></h1>

		        		<div class="contentQuestions">
		         			<?php  while( have_rows('question_sections') ) : the_row(); ?>
		         				<?php
								$question = get_sub_field('question');
								$id = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $question));
								?>
								<h6 id="<?php echo rtrim($id, '-'); ?>"><?php echo $question; ?></h6>
		                        <div class="contentQuestionsItems"><?php echo get_sub_field('answer'); ?></div>
	                		<?php  endwhile; ?>
		        		</div>
		        	</div>
                <?php  endwhile; ?>
	        </section>


		    </article>
		<?php endwhile; endif; ?>
    </div>
</main>


<?php get_template_part('footer', 'custom'); ?>
