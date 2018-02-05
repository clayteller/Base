<?php
/**
 * Template part for displaying an entry (post) in an archive or entries section.
 *
 * Displays relevant content for each post type. Post types include 'post', 'employee', 'service' and 'testimonial'.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

   <?php
   // Featured image (for all types except testimonial)
   if ( 'testimonial' !== get_post_type() ) :
      $image = get_the_post_thumbnail( null, 'entry' );
      if ( $image ) :
      ?>
         <figure><a href="<?php the_permalink(); ?>"><?php echo $image; ?></a></figure>
      <?php
      else:
      ?>
         <figure class="noimage"></figure>
      <?php
      endif;
   endif;
   ?>

   <header class="entry-header">
      <?php
      // Entry title (permalink for all types except testimonial)
      if ( 'testimonial' === get_post_type() ) :
         base_entry_title( false );
      else :
         base_entry_title();
      endif;

      // Get subtitle for employee
      if ( 'employee' === get_post_type() ) :
         $subtitle = get_field( 'job_title' );
      // Get subtitle for testimonial
      elseif ( 'testimonial' === get_post_type() ) :
         $subtitle = get_field( 'testimonial_subtitle' );
      endif;

      // Subtitle (for employee and testimonial)
      if ( isset( $subtitle ) ):
      ?>
         <p class="entry-meta"><?php echo $subtitle; ?></p>
      <?php
      endif;

      // Entry meta (for post)
      if ( 'post' === get_post_type() ) :
      ?>
         <p class="entry-meta"><?php base_entry_meta(); ?></p>
         <?php
   		base_entry_categories();
      endif;
      ?>
   </header><!-- .entry-header -->

   <?php
   // Entry content (for all types except employee)
   if ( 'employee' !== get_post_type() ) :
   ?>
      <div class="entry-content">
         <?php
         if ( 'testimonial' === get_post_type() ) :
            the_content();
         else :
            the_excerpt();
         endif;
         ?>
      </div><!-- .entry-content -->
   <?php
   endif;

   // Entry footer (for employee)
   if ( 'employee' === get_post_type() ) :
   ?>
   	<footer class="entry-footer">
   		<?php
         base_phone( '<p class="phone">', '</p>', null, false );
   		base_email( '<p class="email">', '</p>', null, false );
         base_social_links();
         ?>
   	</footer><!-- .entry-footer -->
   <?php
   endif;
   ?>

</article><!-- #post-<?php the_ID(); ?> -->
