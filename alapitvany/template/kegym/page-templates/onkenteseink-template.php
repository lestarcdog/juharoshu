<?php
/*
Template Name: Onkenteseink Page
*/

get_header(); ?>

<?php
if(have_posts()) { 
	the_post(); 
	?>
	<h2><?php the_title(); ?></h2>
	<?php
	$args = array(
		'child_of' => get_the_ID(),
		'sort_column' => 'menu_order'
	); 
	$pages = get_pages($args); 

	foreach($pages as $o) {
		?>
		<div class='onkentes-wrap'>
			<div class="onkentes-content clear">
				<div class='onkentes-image clear'><?php echo get_the_post_thumbnail($o->ID, 'thumbnail'); ?></div>
				<div class='onkentes-datas clear'>
					<div class='onkentes-name'><?php echo $o->post_title ?></div>
					<div class='onkentes-excerpt'><?php echo get_page_excerpt($o->post_content) ?>...</div>
				</div>
			</div>
			<div class='onkentes-link'><a href='<?php echo get_page_link($o->ID); ?>'>
				<?php _e("More...",'twentytwelve'); ?></a>
			</div>
		</div>
	    <?php
	}
}
?>



<?php get_footer(); ?>