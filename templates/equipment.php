<?php
/*
Template Name: Equipment
*/
?>

<?php get_template_part('header', 'custom'); ?>


<main id="main-content">
    <div class="container EquipmentContentSubPage">
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



		    <section class="Equipment">
			    <?php  
			        $rows = get_field('equipment');
			        if ($rows):
			            $total = count($rows);
			            $i = 0;

			            foreach ($rows as $row):
			                $i++;
			    ?>
			        <div class="itemsEquipment">
			            <h4><?php echo $row['tile']; ?></h4>

			            <div class="contentEquipment">
			                <img loading="lazy" src="<?php echo $row['image']; ?>" alt="Products Equipment HPI.">
			                <div class="contentEquipmentItems"><?php echo $row['description']; ?></div>
			            </div>
			        </div>

			        <?php if ($i < $total): ?>
			            <hr style="border: 1px solid #444444;">
			        <?php endif; ?>

			    <?php  
			            endforeach;
			        endif;
			    ?>
			</section>
		    </article>
		<?php endwhile; endif; ?>
    </div>
</main>


<?php get_template_part('footer', 'custom'); ?>
