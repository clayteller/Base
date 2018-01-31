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
	$email = get_field( 'email', 'option' );

	// Bail if there's no email address
	if ( ! $email ) return;

	return $email;
}
add_shortcode( 'email', 'base_email_shortcode' );

/**
 * Add a shortcode to display phone number.
 */
function base_phone_shortcode() {
	$phone = get_field( 'phone', 'option' );

	// Bail if there's no phone number
	if ( ! $phone ) return;

	return $phone;
}
add_shortcode( 'phone', 'base_phone_shortcode' );

/**
 * Add a shortcode to display address.
 */
function base_address_shortcode() {
	$address = get_field( 'address', 'option' );

	// Bail if there's no address number
	if ( ! $address ) return;

	return $address;
}
add_shortcode( 'address', 'base_address_shortcode' );
