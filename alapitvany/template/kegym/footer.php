<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	
	</div> <!-- end of content -->
	<aside id="rightSide">
		<?php get_sidebar( "right" ); ?>
	</aside>
	
	</div><!-- main-content-area -->
	
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			KUTYÁVAL EGY <strong>MOSOLYÉRT</strong> ALAPÍTVÁNY<br>
			  6000 Kecskemét Petúr bán u. 2/a<br>
			  Telefon: 0630/27868-01 , 0670/25170-22
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->


<!-- one percent -->
<?php if (is_front_page() && get_bloginfo('language') == "hu-HU") { ?>
  <div id="popup_onepercent_background"></div> 
  <div id="popup_content"> 
  <!--
  <div>
	  <a href="index.php?page_id=17"><img src="<?php echo get_template_directory_uri(); ?>/_images/html/onpercent_ad.jpg" alt="egyszazalek">
	  </a>
  </div>
 -->
  <div style="margin: 25px 0">
	<a href="index.php?page_id=2025"><img src="<?php echo get_template_directory_uri(); ?>/_images/html/pedakkred.jpg" alt="pedaker">
	</a>
  </div>
 </div>
 
  <script language="javascript" type="text/javascript">
jQuery("#popup_onepercent_background").click(function() {
	jQuery(this).fadeOut();
	jQuery("#popup_content").fadeOut();
 });
 </script>

 
 <?php } ?>




<?php wp_footer(); ?>
</body>
</html>