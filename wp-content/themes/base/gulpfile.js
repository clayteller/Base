var
	// Gulp packages
	gulp           = require( 'gulp' ),
	autoprefixer   = require( 'autoprefixer' ),
	browsersync    = require( 'browser-sync' ),
	changed        = require( 'gulp-changed' ),
	cssnano        = require( 'gulp-cssnano' ),
	// cssnext seems to be duplicating some of the css rules, so I'm commenting it out for now
	// cssnext     = require( 'postcss-cssnext' ),
	gutil          = require( 'gulp-util' ),
	ignore         = require( 'gulp-ignore' ),
	imagemin       = require( 'gulp-imagemin' ),
	map            = require( 'gulp-sourcemaps' ),
	math           = require( 'postcss-math' ),
	plumber        = require( 'gulp-plumber' ),
	pngquant       = require( 'imagemin-pngquant' ),
	postcss        = require( 'gulp-postcss' ),
	precss         = require( 'precss' ),
	rename         = require( 'gulp-rename' ),
	responsivetype = require( 'postcss-responsive-type' ),
	uglify         = require( 'gulp-uglify' ),
	wpPot          = require( 'gulp-wp-pot' ),

	// Source and destination directories
	cssDest        = './',
	cssSource      = 'source/**/[^_]*.css',
	cssSourceWatch = 'source/**/*.css',
	iconDest       = 'icons',
	iconSource     = 'source/icons/**/*',
	imgDest        = 'images',
	imgSource      = 'source/images/**/*',
	jsDest         = 'js',
	jsSource       = 'source/js/**/*.js',
	phpSource      = [
		'./*.php',
		'inc/**/*.php',
		'template-parts/**/*.php',
		],

	onError = function ( err ) {
		gutil.beep( 2 );
		gutil.log( gutil.colors.white( err ) );
	};

// CSS
gulp.task( 'css', function() {
	var plugins = [
		autoprefixer,
		// cssnext,
		precss,
		math,
		responsivetype
	];
	gulp.src( cssSource )
		.pipe( plumber( {
			errorHandler: onError
		} ) )
		.pipe( changed( cssDest ) )
		.pipe( map.init() )
		.pipe( postcss( plugins ) )
		.pipe( map.write( '.' ) )
		.pipe( gulp.dest( cssDest ) )
		.pipe( ignore.exclude( '*.map' ) )
		.pipe( cssnano( { zindex: false } ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( cssDest ) )
		.pipe( browsersync.stream() );
} );

// Icons
// @todo figure out how to "combine" Images and Icons tasks
gulp.task( 'icons', function () {
	gulp.src( iconSource )
		.pipe(imagemin([
			imagemin.svgo({
				plugins: [
					{convertPathData:    false},
					{convertShapeToPath: false},
					{removeDimensions:   true},
					{removeViewBox:      false}
				]
			})
		]))
		.pipe( gulp.dest( iconDest ) );
} );

// Images
gulp.task( 'images', function () {
	gulp.src( imgSource )
		.pipe(imagemin([
			imagemin.gifsicle({interlaced: true}),
			imagemin.jpegtran({progressive: true}),
			imagemin.optipng({optimizationLevel: 5}),
			imagemin.svgo({
				plugins: [
					{removeDimensions: true},
					{removeViewBox:    false}
				]
			})
		]))
		.pipe( gulp.dest( imgDest ) );
} );

// JavaScript
gulp.task( 'js', function() {
	gulp.src( jsSource )
		.pipe( plumber( {
			errorHandler: onError
		} ) )
		.pipe( changed( jsDest ) )
		.pipe( gulp.dest( jsDest ) )
		.pipe( uglify() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( jsDest ) );
} );

// Translate
gulp.task( 'translate', function() {
	gulp.src( phpSource )
		.pipe( plumber( {
			errorHandler: onError
		} ) )
		.pipe( wpPot( {
			 domain: 'base',
			 package: 'Base theme'
		} ) )
		.pipe( gulp.dest( 'languages/base.pot' ) );
} );

// Watch for changes
gulp.task( 'watch', function() {
	gulp.watch( cssSourceWatch, [ 'css' ] );
	gulp.watch( iconSource, [ 'icons' ] );
	gulp.watch( imgSource, [ 'images' ] );
	gulp.watch( jsSource, [ 'js' ] );
} );

// Reload browser when files change
gulp.task( 'reload', function() {
	var files = [
		'style.css',
		'css/**/*.css',
		'js/**/*.js',
		'images/**/*',
		'icons/**/*',
		'**/*.php'
	];
	browsersync.init( files, {
		notify: false,
		proxy: 'http://base.dev/'
	} );
} );

// Default task
gulp.task( 'default', [ 'css', 'icons', 'images', 'js', 'reload', 'translate', 'watch' ] );
