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
 * Display or retrieve the logo image.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $field_name Optional. Name of the custom field.
 * @param string $css_class  Optional. CSS class name.
 * @param bool   $echo       Optional. Whether to echo or return the title. Default true.
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
 * Display or retrieve the site title.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param bool $echo Optional. Whether to echo or return the title. Default true.
 * @return string Site title if $echo is false.
 */
function base_site_title( $echo = true ) {
	// If a 'Site Title' (custom field) was set in our Theme Settings page, use that instead of default WordPress 'Site Title'
	$title = get_field( 'site_title', 'option' ) ? get_field( 'site_title', 'option' ) : bloginfo( 'name' );

	// Bail if there's no title
	if ( ! $title ) return;

	if ( $echo )
		echo $title;
	else
		return $title;
}

/**
 * Display or retrieve the page title.
 *
 * @uses Advanced Custom Fields
 *
 * @param string $before Optional. Markup to prepend to the title. Default empty.
 * @param string $after  Optional. Markup to append to the title. Default empty.
 * @param bool   $echo   Whether to echo or return the title. Default true.
 * @return string Page title if $echo is false.
 */
function base_page_title( $before = '', $after = '', $echo = true ) {
	// Home page
	if ( is_front_page() ) {
		// If 'Page Title' (custom field) was set, use that instead of  WordPress site description
		$title = get_field( 'page_title' ) ? get_field( 'page_title' ) : get_bloginfo( 'description' );
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
	} elseif ( is_page() || is_home() ) {
		// If 'Page Title' (custom field) was set, use that instead of default WordPress page title
		$title = get_field( 'page_title' ) ? get_field( 'page_title' ) : get_the_title();
	}

	// Bail if there's no title
	if ( ! $title ) return;

	$title = $before . $title . $after;

	if ( $echo )
		echo $title;
	else
		return $title;
}

/**
 * Display or retrieve button html.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $field_name Name of the ACF field.
 * @param string $acf_get    Optional. ACF function name to retrieve button data. Default 'get_field'.
 * @param string $css_id     Optional. CSS id attribute. Allows Google Tag Manager to track button clicks.
 * @param string $before     Optional. Markup to prepend to the title. Default empty.
 * @param string $after      Optional. Markup to append to the title. Default empty.
 * @param bool   $echo       Optional. Whether to echo or return the title. Default true.
 * @return string Button html if $echo is false.
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
 * Display or retrieve contact info html.
 *
 * @uses Advanced Custom Fields Pro
 *
 * @param string $post_id Optional. The post we're targeting. Default false for current post.
 * @param bool   $echo    Optional. Whether to echo or return the title. Default true.
 * @return string Button html if $echo is false.
 */
function base_social_links( $post_id = false, $echo = true ) {
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


if ( ! function_exists( 'base_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
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
endif;

if ( ! function_exists( 'base_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function base_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'base' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'base' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'base' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'base' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'base' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'base' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'base_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function base_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;
