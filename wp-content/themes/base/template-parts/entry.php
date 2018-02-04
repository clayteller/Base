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
   // Featured image (for all entries except testimonials)
   if ( ! base_is_post_type( 'testimonial' ) ) :
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
      <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

      <?php
      $subtitle = null;

      // Get subtitle for employee
      if ( base_is_post_type( 'employee' ) ) :
         $subtitle = get_field( 'job_title' );
      // Get subtitle for testimonial
      elseif ( base_is_post_type( 'testimonial' ) ) :
         $subtitle = get_field( 'testimonial_subtitle' );
      endif;

      // Subtitle (for employees and testimonials)
      if ( $subtitle ):
      ?>
         <p class="entry-meta"><?php echo $subtitle; ?></p>
      <?php
      endif;

      // Entry meta (for posts)
      if ( base_is_post_type( 'post' ) ) :
      ?>
         <p class="entry-meta"><?php base_entry_meta(); ?></p>
         <?php
   		base_entry_categories();
      endif;
      ?>
   </header><!-- .entry-header -->

   <?php
   // Entry content (for all entries except employees)
   if ( ! base_is_post_type( 'employee' ) ) :
   ?>
      <div class="entry-content">
         <?php
         if ( base_is_post_type( 'testimonial' ) ) :
            the_content();
         else :
            the_excerpt();
         endif;
         ?>
      </div><!-- .entry-content -->
   <?php
   endif;

   // Entry footer (for employees)
   if ( base_is_post_type( 'employee' ) ) :
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
