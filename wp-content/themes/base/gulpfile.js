// Gulp packages
var gulp        = require( 'gulp' ),
	autoprefixer = require( 'autoprefixer' ),
	browsersync  = require( 'browser-sync' ),
	changed      = require( 'gulp-changed' ),
	cssnano      = require( 'gulp-cssnano' ),
	// cssnext seems to be duplicating some of the css rules, so I'm commenting it out for now
	// cssnext      = require( 'postcss-cssnext' ),
	gutil        = require( 'gulp-util' ),
	ignore       = require( 'gulp-ignore' ),
	imagemin     = require( 'gulp-imagemin' ),
	map          = require( 'gulp-sourcemaps' ),
	math         = require( 'postcss-math' ),
	plumber      = require( 'gulp-plumber' ),
	pngquant     = require( 'imagemin-pngquant' ),
	postcss      = require( 'gulp-postcss' ),
	precss       = require( 'precss' ),
	rename       = require( 'gulp-rename' ),
	responsivetype = require( 'postcss-responsive-type' ),
	uglify       = require( 'gulp-uglify' );

// Source and destination directories
var jsSource  = 'source/js/**/*.js',
	jsDest     = 'js',
	cssSource  = 'source/**/[^_]*.css',
	cssSourceWatch  = 'source/**/*.css',
	cssDest    = './',
	imgSource  = 'source/images/**/*',
	imgDest    = 'images',
	iconSource = 'source/icons/**/*',
	iconDest   = 'icons';

var onError = function ( err ) {
		gutil.beep( 2 );
		gutil.log( gutil.colors.white( err ) );
	};

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

// Images
gulp.task( 'images', function () {
	// SVG is not working correctly so just optimize JPG and PNG
	gulp.src( imgSource + '.{jpg,jpeg,png}' )
		.pipe( imagemin( {
			progressive: true,
			// svgoPlugins: [{removeViewBox: false}],
			use: [ pngquant() ]
		}))
		.pipe( gulp.dest( imgDest ) );
	// Just copy SVGs without optimizing for now
	gulp.src( imgSource + '.svg' )
		.pipe( gulp.dest( imgDest ) );
} );

// Icons
gulp.task( 'icons', function () {
	gulp.src( iconSource )
		.pipe( gulp.dest( iconDest ) );
} );

// Watch for changes
gulp.task( 'watch', function() {
	gulp.watch( jsSource, [ 'js' ] );
	gulp.watch( cssSourceWatch, [ 'css' ] );
	gulp.watch( imgSource, [ 'images' ] );
	gulp.watch( iconSource, [ 'icons' ] );
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
		proxy: 'http://base.dev/'
	} );
} );

// Default task
gulp.task( 'default', [ 'js', 'css', 'images', 'icons', 'watch', 'reload' ] );
