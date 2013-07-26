<?php

/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Friendster_Blog
 * @since Friendster Blog 2.0
 */



get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
    <div class="blog-container">     
     <div class="main">

        <div id="sidebar">
          <div class="user">
            <div class="user-avatar">
              <?php echo get_avatar( get_the_author_meta('ID'), 108 ); ?>
            </div>
            <p class="user-name">By <?php echo ucfirst(get_the_author()); ?></p>
            <p class="date-post"><?php the_date('M d Y'); ?></p>
          </div>

          <div class="category">
            <h3>Categories</h3>
<?php echo get_the_category_list(); ?>
        </div>

          <div class="tags">
          <h3>Tags</h3>
<?php echo get_the_tag_list('<ul><li>','</li><li>','</li></ul>'); ?>
          </div>
        </div>

        <div id="content">
          <div class="single-post-title"><h2><?php echo get_the_title(); ?></h2></div>
          <div class="single-post-content">
         
			<?php echo get_the_content(); ?> 

<?php
$args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
  );

  $attachments = get_posts( $args );
     if ( $attachments ) {
        foreach ( $attachments as $attachment ) {

          echo "<span class='span-" . $attachment->ID . "'>";
          $attachment = get_post( $attachment->ID );
          echo $attachment->post_content;
          echo "</span>";
     } 
   }
     else {} ?>


   <script>
$( document ).ready(function() {

$(".single-post-content p a img").closest('p').addClass('post-image');
var img_count = $(".single-post-content p a img").length;
for (var i = 0; i < img_count; i++)
{
var img_class_raw = $(".single-post-content p a img").eq(i).attr('class'); 
var img_class = img_class_raw.split(' ');
var img_id = img_class[2].substr(9);

var h2 = $('.span-'+img_id, '.single-post-content');
$('.post-image').append(h2);

}

$('.single-post-content span').filter(function() {
   return $.trim($(this).text()) === '' && $(this).children().length == 0
 })
    .remove()
});
</script>  


          </div> 
        </div>

     </div>
  <?php endwhile; // end of the loop. ?>
 <div class="navigation"><span class="btn-left"><?php previous_post_link('%link','&laquo; Previous') ?></span><span class="btn-right"><?php next_post_link('%link', 'Next &raquo;') ?></div>
    <!--END: Page Nav-->
  </div>

<?php get_footer(); ?>