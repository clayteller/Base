<?php
/**
 * Functions which enhance the comments by hooking into WordPress
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Add placeholder text to comment 'message' texarea.
 *
 * @uses base_add_string()
 */
function base_comment_textarea( $field_html ) {
	$placeholder = ' placeholder="' . __( 'Your comment…', 'base' ) . '" ';
	return base_add_string( $field_html, $placeholder, 'textarea', true );
}
add_filter( 'comment_form_field_comment', 'base_comment_textarea' );

/**
 * Add placeholder text to comment 'email' field.
 *
 * @uses base_add_string()
 */
function base_comment_field_email( $field_html ) {
   $placeholder = ' placeholder="' . __( 'Email', 'base' ) . '" ';
	return base_add_string( $field_html, $placeholder, 'input', true );
}
add_filter( 'comment_form_field_email', 'base_comment_field_email' );

/**
 * Add placeholder text to comment 'author' field.
 *
 * @uses base_add_string()
 */
function base_comment_field_author( $field_html ) {
   $placeholder = ' placeholder="' . __( 'Name', 'base' ) . '" ';
	return base_add_string( $field_html, $placeholder, 'input', true );
}
add_filter( 'comment_form_field_author', 'base_comment_field_author' );

/**
 * Add placeholder text to comment 'url' field.
 *
 * @uses base_add_string()
 */
function base_comment_field_url( $field_html ) {
   $placeholder = ' placeholder="' . __( 'Website', 'base' ) . '" ';
	return base_add_string( $field_html, $placeholder, 'input', true );
}
add_filter( 'comment_form_field_url', 'base_comment_field_url' );
