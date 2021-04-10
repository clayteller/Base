const
	// Import Gulp
	{ src, dest, watch, parallel, series, lastRun } = require( 'gulp' ),

	// Import modules
	autoprefixer = require( 'autoprefixer' ),
	browsersync  = require( 'browser-sync' ),
	cssnano      = require( 'gulp-cssnano' ),
	gutil        = require( 'gulp-util' ),
	ignore       = require( 'gulp-ignore' ),
	imagemin     = require( 'gulp-imagemin' ),
	localization = require( 'gulp-wp-pot' ),
	map          = require( 'gulp-sourcemaps' ),
	plumber      = require( 'gulp-plumber' ),
	postcss      = require( 'gulp-postcss' ),
	pcssadv      = require( 'postcss-advanced-variables' ),
	pcsscalc     = require( 'postcss-calc' ),
	pcsscolor    = require( 'postcss-color-function' ),
	pcssnested   = require( 'postcss-nested' ),
	pcsstype     = require( 'postcss-responsive-type' ),
	rename       = require( 'gulp-rename' ),
	terser       = require( 'gulp-terser' ),

	// Source and destination paths
	paths = {
		js: {
			src:  'source/js/**/*.js',
			dest: 'assets/js',
		},
		css: {
			src:  'source/css/**/*.css',
			dest: 'assets/css',
		},
		images: {
			src:  'source/icons/**/*',
			dest: 'assets/images',
		},
		icons: {
			src:  'source/icons/**/*',
			dest: 'assets/icons',
		},
		php: {
			src:  [
				'./*.php',
				'inc/**/*.php',
				'template-parts/**/*.php',
			],
		},
	};

const onError = function ( err ) {
	gutil.beep( 2 );
	gutil.log( gutil.colors.white( err ) );
	this.emit( 'end' );
};

// JavaScript task
function jsTask() {
	return src( paths.js.src, { since: lastRun( jsTask ) } )
		.pipe( plumber( {
			errorHandler: onError,
		} ) )
		.pipe( dest( paths.js.dest ) )
		.pipe( terser() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( dest( paths.js.dest ) );
}

// CSS task
function cssTask() {
	// PostCSS plugins
	const plugins = [
		pcssadv,
		pcssnested,
		pcsscalc,
		pcsscolor,
		pcsstype,
		autoprefixer,
	];
	return src( paths.css.src )
		.pipe( plumber( {
			errorHandler: onError,
		} ) )
		.pipe( map.init() )
		.pipe( postcss( plugins ) )
		// After postcss processing we can ignore 'include' files
		.pipe( ignore.exclude( 'inc/*' ) )
		.pipe( map.write( '.' ) )
		.pipe( dest( paths.css.dest ) )
		.pipe( ignore.exclude( '*.map' ) )
		.pipe( cssnano( { zindex: false } ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( dest( paths.css.dest ) );
}

// Images task
function imagesTask() {
	return src( paths.images.src, { since: lastRun( imagesTask ) } )
		.pipe( imagemin( [
			imagemin.gifsicle( { interlaced: true } ),
			imagemin.mozjpeg( { progressive: true } ),
			imagemin.optipng( { optimizationLevel: 5 } ),
			imagemin.svgo( {
				plugins: [
					{ removeDimensions: true },
					{ removeViewBox:    false },
				],
			} ),
		] ) )
		.pipe( dest( paths.images.dest ) );
}

// Icons task
// @todo figure out how to "combine" Images and Icons tasks
function iconsTask() {
	return src( paths.icons.src, { since: lastRun( iconsTask ) } )
		.pipe( imagemin( [
			imagemin.svgo( {
				plugins: [
					{ cleanupIDs:         false },
					{ convertPathData:    false },
					{ convertShapeToPath: false },
					{ removeDimensions:   true },
					{ removeUselessDefs:  false },
					{ removeViewBox:      false },
				],
			} ),
		] ) )
		.pipe( dest( paths.icons.dest ) );
}

// WP Localization task
function localizationTask() {
	return src( paths.php.src )
		.pipe( plumber( {
			errorHandler: onError,
		} ) )
		.pipe( localization( {
			domain: 'base',
			package: 'Base theme',
		} ) )
		.pipe( dest( 'languages/base.pot' ) );
}

// Run tasks when files change
function watchTask() {
	// CSS changes
	watch( paths.css.src, series( cssTask ) );
	// JavaScript changes
	watch( paths.js.src, series( jsTask ) );
	// Images changes
	watch( paths.images.src, series( imagesTask ) );
	// Icons changes
	watch( paths.icons.src, series( iconsTask ) );
}

// Reload browser
function syncBrowser() {
	const files = [
		'./assets/css/**/*.css',
		'./assets/js/**/*.js',
		'./assets/images/**/*',
		'./assets/icons/**/*',
		'./**/*.php',
	];
	browsersync.init( files, {
		notify: false,
		proxy: 'http://base.dev/',
	} );
}

// Default gulp task
exports.default = series( parallel( jsTask, cssTask, imagesTask, iconsTask ), parallel( watchTask, syncBrowser ) ); // $ gulp

// Individual tasks
exports.js           = jsTask; // $ gulp js
exports.css          = cssTask; // $ gulp css
exports.images       = imagesTask; // $ gulp images
exports.icons        = iconsTask; // $ gulp icons
exports.localization = localizationTask; // $ gulp localization
