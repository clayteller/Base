<?php
/**
 * Template part for displaying a testimonial entry
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since 1.0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php the_content() ?>
   <h3 class="entry-title"><?php the_title(); ?></h3>
</article>
