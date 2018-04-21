/**
 * Sitewide javascript
 *
 * @requires jquery.js
 * @requires TweenMax.js
 */

/* Tell eslint about global variables */
/* global TimelineMax, Power4 */

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
			.removeClass( 'menu-toggle' )
			.addClass( 'menu-toggle-clone' ),
		// Menu icon bars (to be animated)
		$menuIconBar1 = $siteNav.find( 'rect:nth-child(1)' ),
		$menuIconBar2 = $siteNav.find( 'rect:nth-child(2)' ),
		$menuIconBar3 = $siteNav.find( 'rect:nth-child(3)' ),
		$menuIconBar4 = $siteNav.find( 'rect:nth-child(4)' ),

		// Scrolling
		scrollPosition,
		scrollDirection,
		previous,

		// Menu icon animation timeline
		tlMenuIcon = new TimelineMax( {
			// delay: 0.3, why isn't this working?
			paused:   true,
			reversed: true
		} ),

		menuActive = function() {
			return $body.hasClass( 'menu-on' );
		},

		closeMenu = function() {
			$body.removeClass( 'menu-on' );
			$siteMenuButton.attr( 'aria-expanded', 'false' );
			$siteMenu.attr( 'aria-expanded', 'false' );
			// Animate menu icon to original state
			tlMenuIcon.reverse();
		},

		openMenu = function() {
			$body.addClass( 'menu-on' );
			$siteMenuButton.attr( 'aria-expanded', 'true' );
			$siteMenu.attr( 'aria-expanded', 'true' );
			// Animate menu icon into 'x'
			tlMenuIcon.play();
		},

		toggleMenu = function() {
			// Hide menu
			if ( menuActive() ) {
				closeMenu();
			// Show menu
			} else {
				openMenu();
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

	// Toggle menu on and off
	$siteMenuButton.on( 'click', toggleMenu );

	// ESC key closes menu
	$( document ).keydown( function( e ) {
		if ( 27 == e.which && menuActive() ) {
			closeMenu();
		}
	} );

	// Make the clone button click trigger the original button
	$siteMenuButtonClone.on( 'click', function() {
		$siteMenuButton.click();
	} );

	// Set menu items with submenus to aria-haspopup='true'.
	$siteSubmenu.parent( 'li' ).attr( 'aria-haspopup', 'true' );

	// Hide menu toggle initially
	$siteMenuButtonClone.addClass( 'hide' );

	/**
	 * Add 'scrolled', 'scrolldown', and 'scrollup' classes to body on scroll event. Used by stylesheet to style/position masthead and site menu toggle button.
	 *
	 * @todo Move to a recallable function
	 */
	$( window ).scroll( function() {
		// After page is scrolled below original header position…
		if ( $( this ).scrollTop() > 0 ) {
			$body.addClass( 'scrolled' );
		} else {
			$body.removeClass( 'scrolled' );
			$body.removeClass( 'scrollup' );
		}

		// After page is scrolled below original header position…
		if ( $( this ).scrollTop() > $masthead.height() ) {
			// Downward scroll
			if ( $( this ).scrollTop() >= scrollPosition ) {
				scrollDirection = 'down';
				if ( scrollDirection !== previous ) {
					$body.addClass( 'scrolldown' );
					$body.removeClass( 'scrollup' );
					previous = scrollDirection;
				}
			// Upward scroll
			} else {
				scrollDirection = 'up';
				if ( scrollDirection !== previous ) {
					$body.addClass( 'scrollup' );
					$body.removeClass( 'scrolldown' );
					previous = scrollDirection;
				}
			}
		}
		scrollPosition = $( this ).scrollTop();
	} );

	$body.removeClass( 'scrolldown scrollup' );

} )( jQuery );
