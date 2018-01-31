<?php
/**
 * Add a shortcode to display phone number.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Add a shortcode to display email address.
 */
function base_email_shortcode() {
	return base_email( '<span class="email">', '</span>', 'option', false, false );
}
add_shortcode( 'email', 'base_email_shortcode' );

/**
 * Add a shortcode to display phone number.
 */
function base_phone_shortcode() {
	return base_phone( '<span class="phone">', '</span>', 'option', false, false );
}
add_shortcode( 'phone', 'base_phone_shortcode' );
