<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php get_header(); ?>
	<?php /* Start the Loop */ ?>
			<h2><?php single_cat_title(); ?></h2>
			<div style="margin:10px 0 10px 10px;">
				<?php posts_nav_link(); ?>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class='onkentes-wrap'>
				<div class="onkentes-content clear">
					<div class='onkentes-image clear'><?php the_post_thumbnail( ); ?></div>
					<div class='onkentes-datas clear'>
						<div class='onkentes-name'><?php the_title(); ?></div>
						<div class='onkentes-excerpt'><?php echo the_title(); ?>...</div>
					</div>
				</div>
				<div class='onkentes-link'>
					<a href='<?php the_permalink();?>'>
					<?php _e("More...",'twentytwelve'); ?>
					</a>
				</div>
				</div>
			<?php endwhile; ?>
			<div style="margin:10px 0 10px 10px;">
				<?php posts_nav_link(); ?>
			</div>
	
<?php get_footer(); ?>