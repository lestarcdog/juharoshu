<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>


			<?php while ( have_posts() ) : the_post(); ?>

				<nav class="nav-single">
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title',true  ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>',true  ); ?></span>
				</nav><!-- .nav-single -->
				
				<h2><?php the_title(); ?></h2>
				
				<?php the_content(); ?>


			<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>