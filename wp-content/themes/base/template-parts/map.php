<?php
/**
 * Template part for displaying a Google map of company address
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

$address = get_field( 'address', 'option' );

// Bail if there's no address
if ( ! $address ) return;
?>

<div class="map">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3154.958433222949!2d-122.42377728468323!3d37.744119379765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f7e42e1b683a9%3A0xe06ddc60b9f33cb!2s60+<?php urlencode( strip_tags( $address ) ); ?>!5e0!3m2!1sen!2sus!4v1517381673756" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
