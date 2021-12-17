var gulp        = require( 'gulp' ),
	sass         = require( 'gulp-sass' ),
	autoprefixer = require( 'gulp-autoprefixer' ),
	sourcemaps   = require( 'gulp-sourcemaps' ),
	uglify       = require( 'gulp-uglify' ),
	concat       = require( 'gulp-concat' ),
	rename       = require( 'gulp-rename' ),
	jshint       = require( 'gulp-jshint' ),
	imagemin     = require( 'gulp-imagemin' ),
	browserSync  = require( 'browser-sync' );

// BrowserSync
gulp.task( 'browser-sync', function() {
	var files = [
		'style.css',
		'ui/**/*.png',
		'js/**/*.js',
		'**/*.php'
	];

	browserSync.init( files, {
		proxy: 'https://timfetter.dev-local'
	});
});

// SASS
var input = 'scss/*.scss';
var output = '.';
var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'compressed'
};

gulp.task( 'sass', function() {
	return gulp
		.src( input )
		.pipe( sourcemaps.init() )
		.pipe( sass( sassOptions ).on( 'error', sass.logError ) )
		.pipe( autoprefixer({ browsers: [ 'ie >= 10', 'android >= 4.1' ] }) )
		.pipe( sourcemaps.write( './css/maps' ) )
		.pipe( gulp.dest( output ) );
});

gulp.task( 'jshint', function() {
	return gulp.src([
		'js/main.js'
	])
		.pipe( jshint() )
		.pipe( jshint.reporter( 'jshint-stylish' ) );
});


gulp.task( 'imagemin', function() {
	return gulp.src([
		'imagemin/*'
	])
		.pipe( imagemin() )
		.pipe( gulp.dest( 'ui' ) );
});

// Watch
gulp.task( 'watch', function() {
	gulp.watch( 'scss/*.scss', [ 'sass' ]);
	gulp.watch( 'js/*.js', [ 'jshint' ]);

	// gulp.watch('img/src/*.{png,jpg,gif}', ['img']);
});

// Concat js, Minify - this task is used for production only. You'll need to comment functions.php accordingly.
gulp.task( 'minify', function() {

	// add to the array in the order you want them concatenated
	gulp.src([
		// 'js/plugins/modernizr-2.6.2.min.js',
		'js/plugins/bootstrap.min.js',
		'js/plugins/skip-link-focus-fix.js',
		// 'js/plugins/wurfl.js',
		// 'js/plugins/jquery.form.min.js',
		// 'js/plugins/contact-form-7.js'
	])
		.pipe( concat( 'plugins.js' ) )

	// .pipe(stripDebug())
		.pipe( uglify() )
		.pipe( rename({suffix: '.min' }) )
		.pipe( gulp.dest( 'js/build' ) );
});


// run the tasks

// for production
// gulp.task('default', ['sass', 'browser-sync', 'minify', 'watch']);
// gulp.task('default', ['minify']);

// for development
gulp.task( 'default', [ 'sass', 'jshint', 'watch', 'browser-sync' ]);

// for Scout
// may need to use an online auto-prefixer
// gulp.task('default', ['jshint', 'watch', 'browser-sync']);


