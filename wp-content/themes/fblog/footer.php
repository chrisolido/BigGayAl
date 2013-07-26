<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Friendster_Blog
 * @since Friendster Blog 2.0
 */

?>


  <footer>
     <div class="featured-post">
        <h3>FEATURED POST</h3>
        <?php wp_reset_query(); ?>
      	<?php query_posts($query_string."&post_per_page=3&featured=yes"); ?>
     	<?php while ( have_posts() ) : the_post(); ?>
        <p><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></p>
        <p>&#8226;&#8226;&#8226;</p>
        <?php endwhile; // end of the loop. ?>
     </div> 
 	
     <div class="copyright">2013 Friendster, Inc. - All rights reserved.</div>
  </footer>



<!--
	<footer id="colophon" role="contentinfo">



			<?php

				/* A sidebar in the footer? Yep. You can can customize

				 * your footer with three columns of widgets.

				 */

				if ( ! is_404() )

					get_sidebar( 'footer' );

			?>



			<div id="site-generator">

				<?php do_action( 'twentyeleven_credits' ); ?>

				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyeleven' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyeleven' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'twentyeleven' ), 'WordPress' ); ?></a>

			</div>

	</footer><!-- #colophon -->

</div><!-- #page -->



<?php wp_footer(); ?>



</body>

</html>