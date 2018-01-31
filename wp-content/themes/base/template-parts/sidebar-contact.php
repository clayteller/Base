<?php
/**
 * The 'Contact' page sidebar
 *
 * @package Base
 * @since 1.0.1
 */


// Email
$email = get_field( 'email', 'option' );
// Address
$address = get_field( 'address', 'option' );
?>

<aside id="site-aside" class="site-aside">
	<div class="wrap">
   	<?php
      base_phone( '<p class="phone">', '</p>', 'option' );
		base_email( '<p class="email">', '</p>', 'option' );
		base_address();
   	?>
   </div><!-- .wrap -->
</aside><!-- #site-aside -->
