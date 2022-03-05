<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<h4 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h4>

			<?php /* Start the Loop */ ?>
			<ul id="search-result-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title()?> </a></li>
			<?php endwhile; ?>
			</ul>

		<?php else : ?>
			<h4 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h4>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
			
			<?php get_search_form(); ?>

		<?php endif; ?>

<?php get_footer(); ?>