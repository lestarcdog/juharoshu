<?php
/*
Template Name: Donation Page
*/

get_header();
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..' , 'barionlib' , 'BarionClient.php'));
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR .'poskey.php';

// Test environment
$environment = BarionEnvironment::Test;
// $environment = BarionEnvironment::Prod;

print $barionPosKey;

$apiVersion = 2;
$BC = new BarionClient($barionPosKey, $apiVersion, $environment);



?>

<?php
if(have_posts()) { 
	the_post(); 
	?>
	<h2><?php the_title(); ?></h2>
    <div><?php the_content(); ?></div>
    <?php
}
?>


<?php get_footer(); ?>