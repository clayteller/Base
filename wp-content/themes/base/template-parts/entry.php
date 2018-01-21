<?php
/**
 * Template part for displaying a blog entry
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

   <?php
   // Featured image (for all entries except testimonials)
   if ( 'testimonial' != $entry_type ) :
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
   if ( 'testimonial' != $entry_type ) :
   ?>
      <header class="entry-header">
         <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
         <?php
         // Display job title for employees
         if ( 'employee' == $entry_type ) :
            $subtitle = get_field( 'job_title' );
            if ( $subtitle ):
            ?>
               <p class="entry-meta"><?php echo $subtitle ?></p>
            <?php
            endif;
         endif;
         // Entry meta (for posts)
         if ( 'post' == $entry_type ) :
         ?>
            <p class="entry-meta"><span class="author"><?php base_svg_icon( 'person' ); the_author(); ?></span><span class="date"><?php base_svg_icon( 'clock' ); echo get_the_date( 'M j, Y' ); ?></span></p>
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
   if ( 'employee' != $entry_type ) :
   ?>
      <div class="entry-content">
         <?php
         if ( 'testimonial' == $entry_type ) :
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
   if ( 'employee' == $entry_type ) :
   ?>
   	<footer class="entry-footer">
   		<?php base_contact_info(); ?>
   	</footer><!-- .entry-footer -->
   <?php
   endif;
   ?>

</article><!-- #post-<?php the_ID(); ?> -->
