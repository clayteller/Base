<?php
/**
 * Template part for displaying an entry (post) in an archive or entries section
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

   // Entry header (for all entries except testimonials)
   if ( ! base_is_post_type( 'testimonial' ) ) :
   ?>
      <header class="entry-header">
         <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
         <?php
         // Display job title for employees
         if ( base_is_post_type( 'employee' ) ) :
            $subtitle = get_field( 'job_title' );
            if ( $subtitle ):
            ?>
               <p class="entry-meta"><?php echo $subtitle ?></p>
            <?php
            endif;
         endif;
         // Entry meta (for posts)
         if ( base_is_post_type( 'post' ) ) :
         ?>
            <p class="entry-meta"><?php base_entry_meta(); ?></p>
            <?php
            // Post categories
            $categories = get_the_category();
            if ( $categories ):
            ?>
               <ul class="post-categories">
                  <?php
                  foreach ( $categories as $category ) {
                     printf(
                        '<li class="category-%1$s"><a href="%2$s">%1$s</a></li>',
                        esc_html( $category->name ),
                        esc_url( get_category_link( $category->term_id ) )
                     );
                  }
                  ?>
               </ul>
            <?php
            endif;
         endif;
         ?>
      </header><!-- .entry-header -->
   <?php
   endif;

   // Entry content (for all entries except employees)
   if ( ! base_is_post_type( 'employee' ) ) :
   ?>
      <div class="entry-content">
         <?php
         if ( base_is_post_type( 'testimonial' ) ) :
            the_content();
            ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php
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
         // Phone
         $phone = get_field( 'phone' );
         if ( $phone ) {
            echo '<div class="phone">' . $phone . '</div>';
         }
         // Email
      	$email = get_field( 'email' );
         if ( $email ) {
   			printf( '<div class="email"><a href="mailto:%1$s">%1$s</a></div>', $email );
         }
         // Social links
         base_social_links();
         ?>
   	</footer><!-- .entry-footer -->
   <?php
   endif;
   ?>

</article><!-- #post-<?php the_ID(); ?> -->
