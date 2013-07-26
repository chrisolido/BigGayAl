	</div>
	<!--/body --> 

	<div id="footer" class="pagewidth clearfix">

		<?php 
			$footer_widget_option = (themify_get('setting-footer_widgets') == "") ? "footerwidget-3col" : themify_get('setting-footer_widgets');
			if($footer_widget_option != ""){ ?>
				  <?php
				  $columns = array('footerwidget-4col' 	=> array('col col4-1','col col4-1','col col4-1','col col4-1'),
										 'footerwidget-3col'	=> array('col col3-1','col col3-1','col col3-1'),
										 'footerwidget-2col' 	=> array('col col4-2','col col4-2'),
										 'footerwidget-1col' 	=> array('') );
				  $x=0;
				  ?>
				<?php foreach($columns[$footer_widget_option] as $col): ?>
						<?php 
							 $x++;
							 if($x == 1){ 
								  $class = "first"; 
							 } else {
								  $class = "";	
							 }
						?>
						<div class="<?php echo $col;?> <?php echo $class; ?>">
							 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer_Widget_'.$x) ) ?>
						</div>
				  <?php endforeach; ?>
		<?php } ?>
		
		<?php if (function_exists('wp_nav_menu')) {
			wp_nav_menu(array('theme_location' => 'footer-nav' , 'fallback_cb' => '' , 'container'  => '' , 'menu_id' => 'footer-nav' , 'menu_class' => 'footer-nav')); 
		} ?>
	
		<div class="footer-text">
			<?php if(themify_get('setting-footer_text_left') != ""){ echo themify_get('setting-footer_text_left'); } else { echo '&copy; <a href="'.get_option('home').'">'.get_bloginfo('name').'</a> '.date('Y') . '<br />'; } ?>
			<?php if(themify_get('setting-footer_text_right') != ""){ echo themify_get('setting-footer_text_right'); } else { echo 'Powered by <a href="http://wordpress.org">WordPress</a> &bull; <a href="http://themify.me">Themify WordPress Themes</a>'; } ?></div>
		</div>
		<!--/footer-text --> 
	
	</div>
	<!--/footer --> 
</div>
<!--/pagewrap -->

<!-- jquery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type='text/javascript'>
	!window.jQuery && document.write('<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"><\/script>')
</script>

<!-- prettyphoto -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.prettyPhoto.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/prettyPhoto.css" type="text/css" media="screen" />
<script type="text/javascript">
	if (screen.width>=480) {
		jQuery(function($) {
			$("a[rel^='prettyPhoto']").prettyPhoto({ deeplinking: false });
		});
	}	
</script>

<!-- slider plugin -->
<script type="text/javascript">

$('#header-slider .slides').css('height','auto');

function carousel_callback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
	 
	 jQuery('.next-slide').bind('click', function() {
		carousel.next();
		return false;
 	});

	jQuery('.prev-slide').bind('click', function() {
		carousel.prev();
		return false;
 	});
	
};

</script>

<!-- theme function script -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script> 

<!-- wp_footer -->
<?php wp_footer(); ?>

<!-- jcarousel -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jcarousel.js"></script>

</body>
</html>