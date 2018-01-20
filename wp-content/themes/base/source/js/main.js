/**
 * Sitewide javascript
 *
 * @requires jquery.js
 * @requires TweenMax.js
 */

/* Tell eslint about global variables */
/* global themeDir, TimelineMax, Power4 */

;( function( $ ) {
	'use strict';

	var
		// Body
		$body = $( 'body' ),
		// Site masthead
		$masthead = $( '#masthead' ),
		// Site nav container
		$siteNav = $( '#site-nav' ),
		// Site nav menu
		$siteMenu = $siteNav.find( '#site-menu' ),
		// Site nav menu
		$siteSubmenu = $siteMenu.find( 'ul' ),
		// Menu toggle button
		$siteMenuButton = $siteNav.find( '.menu-toggle' ),
		// Menu toggle button clone
		$siteMenuButtonClone = $siteMenuButton
			.clone()
			.insertAfter( $siteMenuButton )
			.removeClass( "menu-toggle" )
			.addClass( "menu-toggle-clone" ),

		$menuIconBar1 = $siteMenuButtonClone.find( 'rect:nth-child(1)' ),
		$menuIconBar2 = $siteMenuButtonClone.find( 'rect:nth-child(2)' ),
		$menuIconBar3 = $siteMenuButtonClone.find( 'rect:nth-child(3)' ),
		$menuIconBar4 = $siteMenuButtonClone.find( 'rect:nth-child(4)' ),

		scrollPosition,
		scrollDirection,
		previous,

		tlMenuIcon = new TimelineMax( {
			// delay: 0.3, why isn't this working?
			paused:   true,
			reversed: true
		} ),

		toggleMenu = function() {
			// Hide menu
			if ( $siteNav.hasClass( 'toggled' ) ) {
				$siteNav.removeClass( 'toggled' );
				$siteMenuButton.attr( 'aria-expanded', 'false' );
				$siteMenu.attr( 'aria-expanded', 'false' );
			// Show menu
			} else {
				$siteNav.addClass( 'toggled' );
				$siteMenuButton.attr( 'aria-expanded', 'true' );
				$siteMenu.attr( 'aria-expanded', 'true' );
			}
		},

		animateMenuIcon = function() {
			if ( tlMenuIcon.reversed() ) {
				tlMenuIcon.play();
			} else {
				tlMenuIcon.reverse();
			}
		};

	// Menu icon animation rules
	tlMenuIcon
		.to( $menuIconBar1, 0.3, {
			ease:   Power4.easeInOut,
			x:      14,
			y:      -9,
			scaleX: 0
		} )
		.to( $menuIconBar4, 0.3, {
			ease:   Power4.easeInOut,
			x:      14,
			y:      9,
			scaleX: 0
		}, 0 )
		.to( $menuIconBar2, 0.3, {
			ease:             Power4.easeInOut,
			rotation:         45,
			transformOrigin: '50% 50%'
		}, 0 )
		.to( $menuIconBar3, 0.3, {
			ease:             Power4.easeInOut,
			rotation:         -45,
			transformOrigin: '50% 50%'
		}, 0 )
		// Slow animation down a bit
		.totalDuration( 0.4 );

	$siteMenuButton.on( 'click', toggleMenu );
	$siteMenuButton.on( 'click', animateMenuIcon );
	// Make the clone button click trigger the original button
	$siteMenuButtonClone.on( 'click', function() {
			$siteMenuButton.click();
		} );

	// Set menu items with submenus to aria-haspopup="true".
	$siteSubmenu.parent( 'li' ).attr( 'aria-haspopup', 'true' );

	// Hide menu toggle initially
	$siteMenuButtonClone.addClass( "hide" );

	/**
	 * Add 'scrolled', 'scrolldown', and 'scrollup' classes to body on scroll event. Used by stylesheet to style/position masthead and site menu toggle button.
	 *
	 * @todo Move to a recallable function
	 */
	$( window ).scroll( function() {
		// After page is scrolled below original position…
		if ( $( this ).scrollTop() > 0 ) {
			$body.addClass( "scrolled" );
		} else {
			$body.removeClass( "scrolled" );
			$body.removeClass( "scrollup" );
		}

		// After page is scrolled down past original header position…
		if ( $( this ).scrollTop() > $masthead.height() ) {
			// Downward scroll
			if ( $( this ).scrollTop() >= scrollPosition ) {
				scrollDirection = 'down';
				if ( scrollDirection !== previous ) {
					$body.addClass( "scrolldown" );
					$body.removeClass( "scrollup" );
					previous = scrollDirection;
				}
			// Upward scroll
			} else {
				scrollDirection = 'up';
				if ( scrollDirection !== previous ) {
					$body.addClass( "scrollup" );
					$body.removeClass( "scrolldown" );
					previous = scrollDirection;
				}
			}
		}
		scrollPosition = $( this ).scrollTop();
	} );

	$body.removeClass( "scrolldown scrollup" );

} )( jQuery );
