<?php
/**
 * Register shortcodes for this theme.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Add a shortcode to display email address.
 *
 * @uses base_email()
 */
function base_email_shortcode() {
	return base_email( '<span class="email">', '</span>', 'option', false, false );
}
add_shortcode( 'email', 'base_email_shortcode' );

/**
 * Add a shortcode to display phone number.
 *
 * @uses base_phone()
 */
function base_phone_shortcode() {
	return base_phone( '<span class="phone">', '</span>', 'option', false, false );
}
add_shortcode( 'phone', 'base_phone_shortcode' );
