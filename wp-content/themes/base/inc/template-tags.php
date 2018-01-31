<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @package Base
 * @since 1.0.1
 */

/**
 * Output or return the logo image.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $field_name Optional. Name of the custom field.
 * @param string $css_class  Optional. CSS class name.
 * @param bool   $echo       Optional. Whether to echo or return string. Default true.
 * @return string Logo image object if $echo is false.
 */
function base_logo( $field_name = 'logo', $css_class = 'logo', $echo = true ) {
	// If requested logo can't be retrieved, use header logo ('logo') as fallback
	$logo = get_field( $field_name, 'option' ) ? get_field( $field_name, 'option' ) : get_field( 'logo', 'option' );

	// Bail if there's no logo
	if ( ! $logo ) return;

	if ( $echo )
		echo '<img class="' . $css_class . '" src="' . $logo[ 'url' ] . '" />';
	else
		return $logo;
}

/**
 * Output or return the site title.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param bool $echo Optional. Whether to echo or return string. Default true.
 * @return string Site title if $echo is false.
 */
function base_site_title( $echo = true ) {
	// If a 'Site Title' (custom field) was set in our Theme Settings page, use that instead of default WordPress 'Site Title'
	$title = get_field( 'site_title', 'option' ) ? get_field( 'site_title', 'option' ) : get_bloginfo( 'name' );

	// Bail if there's no title
	if ( ! $title ) return;

	if ( $echo )
		echo $title;
	else
		return $title;
}

/**
 * Output or return the page title.
 *
 * @uses Advanced Custom Fields
 *
 * @param string $before Optional. Markup to prepend to the title. Default empty.
 * @param string $after  Optional. Markup to append to the title. Default empty.
 * @param bool   $echo   Whether to echo or return string. Default true.
 * @return string Page title if $echo is false.
 */
function base_page_title( $before = '', $after = '', $echo = true ) {
	// Home page
	if ( is_front_page() ) {
		// If 'Page Title' (custom field) was set, use that instead of  WordPress site description
		$title = get_field( 'page_title' ) ? get_field( 'page_title' ) : get_bloginfo( 'description' );
	// Blog
	} elseif ( is_home() ) {
		$title = __( 'Blog', 'base' );
	// Archive
	} elseif ( is_archive() ) {
		$title = get_the_archive_title();
	// Single
	} elseif ( is_singular() ) {
		$title = get_the_title();
	// Search
	} elseif ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results for "%s"', 'base' ), '<span>' . get_search_query() . '</span>' );
	// 404
	} elseif ( is_404() ) {
		$title = __( 'Oops!', 'base' );
	// All other pages
	} elseif ( is_page() ) {
		// If 'Page Title' (custom field) was set, use that instead of default WordPress page title
		$title = get_field( 'page_title' ) ? get_field( 'page_title' ) : get_the_title();
	} else {
		$title = base_site_title( false );
	}

	// Bail if there's no title
	if ( ! $title ) return;

	/**
	 * Filters the page title.
	 *
	 * @param string $title
	 */
	$title = apply_filters( 'base_page_title', $title );

	$title = $before . $title . $after;


	if ( $echo )
		echo $title;
	else
		return $title;
}

/**
 * Output or return button HTML.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $field_name Name of the ACF field.
 * @param string $acf_get    Optional. ACF function name to retrieve button data. Default 'get_field'.
 * @param string $css_id     Optional. CSS id attribute. Allows Google Tag Manager to track button clicks.
 * @param string $before     Optional. Markup to prepend to the title. Default empty.
 * @param string $after      Optional. Markup to append to the title. Default empty.
 * @param bool   $echo       Optional. Whether to echo or return string. Default true.
 * @return string HTML if $echo is false.
 */
function base_button( $field_name, $acf_get = 'get_field', $css_id = null, $before = '', $after = '', $echo = true ) {
	$button = $acf_get( $field_name );
	$button_label = $button[ 'button_label' ];
	$button_link = null;
	$css_id ? $css_id = ' id="' . $css_id . '"' : $css_id = '';

	if ( 'internal' == $button[ 'link_type' ] ) {
		$button_link = $button[ 'link_internal' ];
	}
	if ( 'external' == $button[ 'link_type' ] ) {
		$button_link = $button[ 'link_external' ];
	}

	// Bail if there's no button label and button link
	if ( ! $button_label && ! $button_link ) return;

	$html = sprintf( '%1$s<a class="button"%2$s href="%3$s">%4$s</a>%5$s', $before, $css_id, $button_link, $button_label, $after );

	if ( $echo )
		echo $html;
	else
		return $html;
}

/**
 * Output or return social links HTML.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $post_id Optional. The post we're targeting. Default null for current post.
 * @param bool   $echo    Optional. Whether to echo or return string. Default true.
 * @return string HTML if $echo is false.
 */
function base_social_links( $post_id = null, $echo = true ) {
	// Bail if there's no contact info
	if ( ! have_rows( 'social_links', $post_id ) ) return;

   $html = '<ul class="social-links">';
      while ( have_rows( 'social_links', $post_id ) ): the_row();
			$social_site = get_row_layout();
			$html .= sprintf( '<li class="%1$s"><a class="icon" href="%2$s">%1$s</a></li>', $social_site, get_sub_field( $social_site . '_url' ) );
      endwhile;
   $html .= '</ul>';

	if ( $echo )
		echo $html;
	else
		return $html;
}

/**
 * Output HTML with meta information for the current post date/time and author.
 */
function base_entry_meta() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = base_svg_icon( 'clock' ) . $time_string;

	$byline = sprintf(
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . base_svg_icon( 'person' ) . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}

/**
 * Output HTML with the categories.
 */
function base_entry_categories() {

	echo get_the_category_list();
}

/**
 * Output HTML with the tags.
 */
function base_entry_tags() {
	// If single, add tag icon.
	$icon = ( is_single() ) ? base_svg_icon( 'tag' ) : '';

	echo get_the_tag_list('<ul class="post-tags">' . $icon . '<li>','</li><li>','</li></ul>');
}

/**
 * Outputs an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function base_post_thumbnail() {
	// Bail if this is the attachment page or there's no thumbnail
	if ( is_attachment() || ! has_post_thumbnail() ) return;

	if ( is_singular() ) :
	?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->
	<?php
	else :
	?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
			?>
		</a>
	<?php
	endif;
}

/**
 * Output or return email address link.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $before  Optional. Markup to prepend to the email link. Default empty.
 * @param string $after   Optional. Markup to append to the email link. Default empty.
 * @param string $post_id Optional. The post we're targeting. Default null for current post.
 * @param bool   $icon    Optional. Whether to show icon. Default true.
 * @param bool   $echo    Optional. Whether to echo or return string. Default true.
 * @return string Email link if $echo is false.
 */
function base_email( $before = '', $after = '', $post_id = null, $icon = true, $echo = true ) {
 	$email = get_field( 'email', $post_id );
	$icon = ( $icon ) ? base_svg_icon( 'mail' ) : null;

 	// Bail if there's no email
 	if ( ! $email ) return;

    $email_link = sprintf( '<a href="mailto:%1$s" itemprop="email">%2$s%1$s</a>',
 		$email,
 		$icon
 	);

	/**
	 * Filters the email link.
	 *
	 * @param string $email_link
	 */
	$email_link = apply_filters( 'base_email', $email_link );

	$email_link = $before . $email_link . $after;

 	if ( $echo )
 		echo $email_link;
 	else
 		return $email_link;
}

/**
 * Output or return phone link.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $before  Optional. Markup to prepend to the phone link. Default empty.
 * @param string $after   Optional. Markup to append to the phone link. Default empty.
 * @param string $post_id Optional. The post we're targeting. Default null for current post.
 * @param bool   $icon    Optional. Whether to show icon. Default true.
 * @param bool   $echo    Optional. Whether to echo or return string. Default true.
 * @return string Phone link if $echo is false.
 */
function base_phone( $before = '', $after = '', $post_id = null, $icon = true, $echo = true ) {
 	$phone = get_field( 'phone', $post_id );
	$icon = ( $icon ) ? base_svg_icon( 'phone' ) : null;

 	// Bail if there's no phone
 	if ( ! $phone ) return;

    $phone_link = sprintf( '<a href="tel:%1$s" itemprop="telephone">%2$s%1$s</a>',
 		$phone,
 		$icon
 	);

	/**
	 * Filters the phone link.
	 *
	 * @param string $phone_link
	 */
	$phone_link = apply_filters( 'base_phone', $phone_link );

	$phone_link = $before . $phone_link . $after;

 	if ( $echo )
 		echo $phone_link;
 	else
 		return $phone_link;
}

/**
 * Output or return physical address link (Google map link).
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param bool $icon Optional. Whether to show icon. Default true.
 * @param bool $echo Optional. Whether to echo or return string. Default true.
 * @return string HTML if $echo is false.
 */
function base_address( $icon = true, $echo = true ) {
 	$address = get_field( 'address', 'option' );
	$icon = ( $icon ) ? base_svg_icon( 'pin' ) : null;

 	// Bail if there's no address
 	if ( ! $address ) return;

    $html = sprintf( '<p class="address"><a href="https://www.google.com/maps/place/%1$s" target="_blank" itemprop="address">%2$s%3$s</a></p>',
		 urlencode( strip_tags( $address ) ),
		 $icon,
		 $address
	 );

 	if ( $echo )
 		echo $html;
 	else
 		return $html;
}
