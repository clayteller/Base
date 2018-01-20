<?php
/**
 * Template part for displaying a blog entry
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */

$image = get_the_post_thumbnail( null, 'entry' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php if ( $image ): ?>
      <figure><a href="<?php the_permalink(); ?>"><?php echo $image; ?></a></figure>
   <?php else: ?>
      <figure class="noimage"></figure>
   <?php endif; ?>
   <header class="entry-header">
      <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <p class="entry-meta"><span class="author"><?php base_svg_icon( 'person' ); the_author(); ?></span><span class="date"><?php base_svg_icon( 'clock' ); echo get_the_date( 'M j, Y' ); ?></span></p>
      <?php $categories = get_the_category(); ?>
      <?php if ( $categories ): ?>
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
      <?php endif; ?>

   </header><!-- .entry-header -->
   <?php the_excerpt() ?>
</article>
