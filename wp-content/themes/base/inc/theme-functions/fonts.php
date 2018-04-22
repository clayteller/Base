<?php
/**
 * Load fonts.
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Load Typekit fonts
 */
function base_typekit() {
   ?>
   <link rel="stylesheet" href="https://use.typekit.net/ghn1efv.css">
   <?php
}
add_action('wp_head', 'base_typekit');
