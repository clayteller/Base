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

/**
 * Featured image size
 */
if ( 'employee' === get_post_type() || 'testimonial' === get_post_type() ) {
   $img_size = 'square';
} else {
   $img_size = 'featured';
}

/**
 * Featured image link
 */
if ( 'testimonial' === get_post_type() ) {
   $img_link = '';
   $img_link_end = '';
} else {
   $img_link = '<a href="' . get_the_permalink() . '">';
   $img_link_end = '</a>';
}

/**
 * Add css class to control layout of entry elements
 */
add_filter( 'post_class', function ( $classes) {
   if ( 'benefit' === get_post_type() || 'testimonial' === get_post_type() ) {
      $classes[] = 'horizontal';
   } else {
      $classes[] = 'vertical';
   }

   return $classes;
} );
?>

<article <?php post_class(); ?>>

   <?php if ( has_post_thumbnail() ) : ?>
      <figure>
         <?php echo $img_link . get_the_post_thumbnail( null, $img_size ) . $img_link_end; ?>
      </figure>
   <?php else : ?>
      <figure class="noimage"></figure>
   <?php endif; ?>

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
         $entry_subtitle = get_field( 'job_title' );
      // Get subtitle for testimonial
      elseif ( 'testimonial' === get_post_type() ) :
         $entry_subtitle = get_field( 'testimonial_subtitle' );
      endif;

      // Subtitle (for employee and testimonial)
      if ( isset( $entry_subtitle ) ):
      ?>
         <p class="entry-meta"><?php echo $entry_subtitle; ?></p>
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
            echo '<q>' . get_the_content() . '</q>';
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

</article>
