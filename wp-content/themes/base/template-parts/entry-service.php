<?php
/**
 * Template part for displaying a service entry
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
   </header><!-- .entry-header -->
   <?php the_excerpt() ?>
</article>
