<?php

/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Friendster_Blog
 * @since Friendster Blog 2.0
 */



get_header(); ?>



  <div class="blog-container"> 
    <div class="main">

       <?php while ( have_posts() ) : the_post(); ?>
       <div class="blog-post">
          <div class="blog-user-info">
            <div class="blog-user-avatar">
              <?php echo get_avatar( get_the_author_meta('ID'), 108 ); ?>
            </div>
            <p class="blog-user-name">By <?php echo ucfirst(get_the_author()); ?></p>
            <p class="blog-post-date"><?php the_date('M d Y'); ?></p>
            <p class="post-read-time"><?php post_read_time(); ?></p>
          </div>
          <div class="blog-post-content">
            <h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
            <div class="blog-user-post">
              <?php the_excerpt(); ?>
            </div>
          </div>
       </div> 
       <?php endwhile; // end of the loop. ?>
       
<div class="navigation"><span class="btn-left"><?php previous_posts_link('&laquo; Previous Page') ?></span><span class="btn-right"><?php next_posts_link('Next Page &raquo;','') ?></div>

     </div>
  </div>


<?php get_footer(); ?>

