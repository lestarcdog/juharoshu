<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		<?php while ( have_posts() ) { 
			the_post();
			if($post->post_parent != 0 && $post->post_parent != $post->ID ) {
		?>
			<a href='<?php echo get_page_link($post->post_parent) ?>'>&larr; vissza</a>
		<?php 
		}
		?>
			<h2><?php the_title() ?></h2>
				<?php the_content(); ?>
		<?php } ?>


<?php get_footer(); ?>