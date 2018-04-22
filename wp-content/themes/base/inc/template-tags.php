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
 * Output or return post content outside the loop.
 *
 * @uses the_content()
 *
 * @param int    $id             Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool   $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 * @param bool   $echo           Whether to echo or return string. Default true.
 * @return string Content if $echo is false.
 */
function base_the_content_by_id( $post_id = 0, $more_link_text = null, $stripteaser = false, $echo = true ) {
    global $post;
    $post = get_post( $post_id );

    setup_postdata( $post, $more_link_text, $stripteaser );

    ob_start();
    the_content();
    $content = ob_get_clean();

    wp_reset_postdata( $post );

 	if ( $echo )
 		echo $content;
 	else
 		return $content;
}

/**
 * Output or return the logo image.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $field_name Optional. Name of the logo image custom field. Default 'logo'.
 * @param string $css_class  Optional. CSS class name.
 * @param bool   $echo       Optional. Whether to echo or return string. Default true.
 * @return string Logo if $echo is false.
 */
function base_logo( $field_name = 'logo', $css_class = 'logo', $echo = true ) {

   /**
    * Logo image array retrieved from ACF option page.
    * @var array
    */
   $logo = get_field( $field_name, 'option' ) ?: get_field( 'logo', 'option' );

	// Bail if there's no logo
	if ( ! $logo ) return;

   $logo = '<img class="' . $css_class . '" src="' . $logo[ 'url' ] . '" />';

	if ( $echo )
		echo $logo;
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

	/**
    * Site title retrieved from ACF option page, otherwise the WordPress 'Site Title'.
    * @var string
    */
	$title = get_field( 'site_title', 'option' ) ?: get_bloginfo( 'name' );

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

      /**
       * Page title retrieved from custom field, otherwise the WordPress 'Tagline'.
       * @var string
       */
		$title = get_field( 'page_title' ) ?: get_bloginfo( 'description' );

	// Posts page
	} elseif ( is_home() ) {

      /**
       * ID of the posts page.
       * @var integer
       */
      $posts_page_id = get_option( 'page_for_posts' );

      $title = get_field( 'page_title', $posts_page_id ) ?: get_the_title( $posts_page_id );

	// Archive
	} elseif ( is_archive() ) {

      /**
      * Page title retrieved from user-added archive page custom field, otherwise the WordPress archive title.
      * @var string
      */
      $title = base_archive_title( false ) ?: get_the_archive_title();

   // Page
   } elseif ( is_page() ) {

      /**
      * Page title retrieved from custom field, otherwise the WordPress page title.
      * @var string
      */
      $title = get_field( 'page_title' ) ?: get_the_title();

	// Single
	} elseif ( is_singular() ) {
		$title = get_the_title();

	// Search
	} elseif ( is_search() ) {
		$title = sprintf(
			esc_html__( 'Search Results for "%s"', 'base' ),
			'<span>' . get_search_query() . '</span>'
		);

	// 404
	} elseif ( is_404() ) {
		$title = __( 'Oops!', 'base' );

   // Everything else
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
 * Output or return the page title from user-added archive page.
 *
 * @param bool $echo Whether to echo or return string. Default true.
 * @return string Page title if $echo is false.
 */
function base_archive_title( $echo = true ) {

   /**
   * Page id of the relevant user-added archive page.
   * @var integer
   */
   $archive_page_id = get_page_by_path( get_post_type() . 's' );

   $title = get_field( 'page_title', $archive_page_id ) ?: get_the_title( $archive_page_id );;

	// Bail if there's no title
	if ( ! $title  ) return;

	if ( $echo )
		echo $title;
	else
		return $title;
}

/**
 * Output or return archive content.
 *
 * Get the content from user-added archive page; otherwise get the category, tag, term, or author description.
 *
 * @uses base_the_content_by_id()
 *
 * @param bool $echo Whether to echo or return string. Default true.
 * @return string Content if $echo is false.
 */
function base_archive_content( $before = '<div class="archive-content">', $after = '</div>', $echo = true ) {

   /**
   * Page id of the relevant user-added archive page. The slug of the user-added archive page must match the post type.
   * @var integer
   */
   $archive_page_id = get_page_by_path( get_post_type() . 's' );

   // Posts page is using the archive template and needs to be handled differently
   if ( is_home() ) {
      $archive_page_id = get_option( 'page_for_posts' );
   }

   $content = base_the_content_by_id( $archive_page_id, null, false, false ) ?: the_archive_description();

	// Bail if there's no content
	if ( ! $content  ) return;

   $content = $before . $content . $after;

	if ( $echo )
		echo $content;
	else
		return $content;
}

/**
 * Output or return the entry title.
 *
 * @param string $permalink Optional. Whether to add permalink. Default true.
 * @param string $before    Optional. Markup to prepend to the title. Default empty.
 * @param string $after     Optional. Markup to append to the title. Default empty.
 * @param bool   $echo      Whether to echo or return string. Default true.
 * @return string Entry title if $echo is false.
 */
function base_entry_title( $permalink = true, $before = '<h3 class="entry-title">', $after = '</h3>', $echo = true ) {
	$title = get_the_title();

	// Bail if there's no title
	if ( ! $title  ) return;

	// Link the title
	if ( $permalink ) {
		$title = sprintf(
			'<a href="%1$s">%2$s</a>',
			get_permalink(),
			$title
		);
	}

	/**
	 * Filters the entry title.
	 *
	 * @param string $title
	 */
	$title = apply_filters( 'base_entry_title', $title );

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
 * @param string $css_id     Optional. Typically used for Google Tag Manager to track button clicks.
 * @param string $before     Optional. Markup to prepend to the title. Default empty.
 * @param string $after      Optional. Markup to append to the title. Default empty.
 * @param bool   $echo       Optional. Whether to echo or return string. Default true.
 * @return string HTML if $echo is false.
 */
function base_button( $field_name, $acf_get = 'get_field', $css_id = null, $before = '', $after = '', $echo = true ) {
	$button = $acf_get( $field_name );
	$label = $button[ 'button_label' ];
	$link = null;
	$css_id = $css_id ? ' id="' . $css_id . '"' : '';

	if ( 'internal' == $button[ 'link_type' ] ) {
		$link = $button[ 'link_internal' ];
	}

	if ( 'external' == $button[ 'link_type' ] ) {
		$link = $button[ 'link_external' ];
	}

	// Bail if there's no button label or button link
	if ( ! $label || ! $link ) return;

	$html = sprintf(
		'%1$s<a class="button"%2$s href="%3$s">%4$s</a>%5$s',
		$before,
		$css_id,
		$link,
		$label,
		$after
	);

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
	// Bail if there's no social links
	if ( ! have_rows( 'social_links', $post_id ) ) return;

   $html = '<ul class="social-links">';
      while ( have_rows( 'social_links', $post_id ) ): the_row();
			$social_site = get_row_layout();
			$html .= sprintf(
				'<li class="%1$s"><a class="icon" href="%2$s">%1$s</a></li>', $social_site,
				get_sub_field( $social_site . '_url' )
			);
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

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = base_inline_svg( '/icons/clock.svg' ) . $time_string;

	$byline = sprintf(
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . base_inline_svg( '/icons/person.svg' ) . esc_html( get_the_author() ) . '</a></span>'
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
	$icon = is_single() ? base_inline_svg( '/icons/tag.svg' ) : '';

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
	$icon = $icon ? base_inline_svg( '/icons/mail.svg' ) : null;

 	// Bail if there's no email
 	if ( ! $email ) return;

   $email_link = sprintf(
		'<a href="mailto:%1$s" itemprop="email">%2$s%1$s</a>',
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
	$icon = $icon ? base_inline_svg( '/icons/phone.svg' ) : null;

 	// Bail if there's no phone
 	if ( ! $phone ) return;

   $phone_link = sprintf(
		'<a href="tel:%1$s" itemprop="telephone">%2$s%1$s</a>',
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
	$icon = $icon ? base_inline_svg( '/icons/pin.svg' ) : null;

 	// Bail if there's no address
 	if ( ! $address ) return;

	$html = sprintf(
		'<p class="address"><a href="https://www.google.com/maps/place/%1$s" target="_blank" itemprop="address">%2$s%3$s</a></p>',
		urlencode( strip_tags( $address ) ),
		$icon,
		$address
	);

 	if ( $echo )
 		echo $html;
 	else
 		return $html;
}
