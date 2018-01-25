<?php
/**
 * The 'Contact' page sidebar
 *
 * @package Base
 * @since 1.0.1
 */

// Phone
$phone = get_field( 'phone', 'option' );
// Email
$email = get_field( 'email', 'option' );
// Address
$address = get_field( 'address', 'option' );
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
   	<?php
      if ( $phone ) {
         echo '<div class="phone">' . $phone . '</div>';
      }

      if ( $email ) {
   		printf( '<div class="email"><a href="mailto:%1$s">%1$s</a></div>', $email );
      }

      if ( $address ) {
   		echo '<div class="address">' . $address . '</div>';
      }
   	?>
   </div><!-- .wrap -->
</aside><!-- #site-aside -->
