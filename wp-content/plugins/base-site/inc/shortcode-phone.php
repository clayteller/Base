<?php
/**
 * Add a shortcode to display phone number.
 *
 * @package Base Site
 * @since 1.0.1
 */

/**
 * Add a shortcode to display phone number.
 */
function base_phone_shortcode() {
	$phone = get_field( 'phone', 'option' );

	// Bail if we can't retrieve the phone number
	if ( ! $phone ) return;

	return $phone;
}
add_shortcode( 'phone', 'base_phone_shortcode' );
