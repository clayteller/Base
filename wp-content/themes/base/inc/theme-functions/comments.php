<?php
/**
 * Functions which enhance the comments by hooking into WordPress
 *
 * @package Base
 * @since 1.0.1
 */

 /**
  * Add placeholder text to comment form field.
  *
  * @param string $field_html  Default form field HTML.
  * @param string $placeholder Placeholder text to insert.
  * @param string $find        Where to insert placeholder attribute.
  * @return string HTML of form field with placeholder.
  */
 function base_comment_field_placeholder( $field_html, $placeholder, $find = 'input' ) {
 	$placeholder_html = ' placeholder="' . $placeholder . '" ';
 	$find_in_field_html = '<' . $find;
 	$insertion_point = strpos( $field_html, $find_in_field_html ) + strlen( $find_in_field_html );
 	return substr_replace( $field_html, $placeholder_html, $insertion_point, 0 );
 }

 /**
  * Add placeholder text to comment 'message' texarea.
  *
  * @uses base_comment_field_placeholder()
  */
 function base_comment_textarea( $field_html ) {
 	$placeholder = __( 'Your comment…', 'base' );
 	return base_comment_field_placeholder( $field_html, $placeholder, 'textarea' );
 }
 add_filter( 'comment_form_field_comment', 'base_comment_textarea' );

 /**
  * Add placeholder text to comment 'email' field.
  *
  * @uses base_comment_field_placeholder()
  */
 function base_comment_field_email( $field_html ) {
 	$placeholder = __( 'Email', 'base' );
 	return base_comment_field_placeholder( $field_html, $placeholder );
 }
 add_filter( 'comment_form_field_email', 'base_comment_field_email' );

 /**
  * Add placeholder text to comment 'author' field.
  *
  * @uses base_comment_field_placeholder()
  */
 function base_comment_field_author( $field_html ) {
 	$placeholder = __( 'Name', 'base' );
 	return base_comment_field_placeholder( $field_html, $placeholder );
 }
 add_filter( 'comment_form_field_author', 'base_comment_field_author' );

 /**
  * Add placeholder text to comment 'url' field.
  *
  * @uses base_comment_field_placeholder()
  */
 function base_comment_field_url( $field_html ) {
 	$placeholder = __( 'Website', 'base' );
 	return base_comment_field_placeholder( $field_html, $placeholder );
 }
 add_filter( 'comment_form_field_url', 'base_comment_field_url' );
