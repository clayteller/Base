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
   <?php
   if ( $image ) {
      echo '<figure>' . $image . '</figure>';
   } else {
      echo '<figure class="noimage"></figure>';
   }
   ?>
   <header class="entry-header">
      <h3 class="entry-title"><?php the_title(); ?></h3>
   </header><!-- .entry-header -->
   <?php the_excerpt() ?>
</article>
