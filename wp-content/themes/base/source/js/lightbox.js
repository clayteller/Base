/**
 * Lightbox javascript
 *
 * @requires 'baseTheme' variable from functions.php
 * @requires featherlight.js
 * @requires featherlight-gallery.js
 * @requires jquery.detect_swipe.js
 */

;( function( $ ) {
	'use strict';

	/**
	 * Featherlight gallery
	 */
	var
		$gallery = $( ".gallery" ),
		chevronIcon = baseTheme.iconChevron,
		loadingGraphic = baseTheme.loadingGraphic;

	// Initialize featherlight gallery
	$gallery.find( "a" ).featherlightGallery( {
		galleryFadeIn: 300,
		loading:       loadingGraphic,
		nextIcon:      chevronIcon,
		openSpeed:     300,
		otherClose:    '.featherlight-image',
		previousIcon:  chevronIcon,
	} );


} )( jQuery );
