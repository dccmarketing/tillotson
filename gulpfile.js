/**
 * WordPress theme-specific gulpfile
 *
 * Instructions:
 *
 * In your terminal, hit enter after pasting in each command:
 * cd /project-directory
 * npm init
 * sudo npm install --save-dev gulp gulp-util gulp-load-plugins browser-sync gulp-sourcemaps gulp-autoprefixer gulp-line-ending-corrector gulp-filter gulp-merge-media-queries gulp-cssnano gulp-sass gulp-concat gulp-uglify gulp-notify gulp-imagemin gulp-rename gulp-wp-pot gulp-sort
 *
 * Implements:
 * 		1. Live reloads browser with BrowserSync.
 * 		2. CSS: Sass to CSS conversion, error catching, Autoprixing, Sourcemaps,
 * 			 CSS minification, and Merge Media Queries.
 * 		3. JS: Concatenates & uglifies Vendor and Custom JS files.
 * 		4. Images: Minifies PNG, JPEG, GIF and SVG images.
 * 		5. Watches files for changes in CSS or JS.
 * 		6. Watches files for changes in PHP.
 * 		7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @since 1.0.0
 * @author Chris Wilcoxson (@slushman)
 */

/**
 * Project settings
 */
var project = {
	'name': 'tillotson',
	'url': 'tillotson.dev',
	'i18n': {
		'domain': 'tillotson',
		'destFile': 'tillotson.pot',
		'package': 'Tillotson',
		'bugReport': 'http://www.dccmarketing.com/contact/',
		'translator': 'Chris Wilcoxson <chrisw@dccmarketing.com>',
		'lastTranslator': 'DCC Marketing <web@dccmarketing.com>',
		'path': './languages'
	}
};

/**
 * Scripts
 */
var scripts = {
	'public': {
		'task': 'publicJS',
		'source': './js/public/*.js',
		'dest': './js/',
		'filename': 'public'
	},
	'admin': {
		'task': 'adminJS',
		'source': './js/admin/*.js',
		'dest': './js/',
		'filename': 'admin'
	},
	'customizer': {
		'task': 'customizerJS',
		'source': './js/customizer/*.js',
		'dest': './js/',
		'filename': 'customizer'
	},
	'controls': {
		'task': 'controlsJS',
		'source': './js/customizer-controls/*.js',
		'dest': './js/',
		'filename': 'customizer-controls'
	},
	'login': {
		'task': 'loginJS',
		'source': './js/login/*.js',
		'dest': './js/',
		'filename': 'login'
	},
	'libraries': {
		'task': 'librariesJS',
		'source': './js/lib/*.js',
		'dest': './js/',
		'filename': 'libraries'
	}
};

var images = {
	'source': './images/*.{png,jpg,gif,svg}',
	'dest': './images/'
}

var watch = {
	'styles': {
		'source': './sass/**/*.scss',
		'task' : 'styles'
	},
	'php': './*.php'
}

var tasks = [ 'translate', 'images', 'browser-sync', 'styles', 'publicJS', 'adminJS', 'customizerJS', 'controlsJS', 'loginJS', 'librariesJS' ];

/**
 * Browsers you care about for autoprefixing.
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 1%',
	'ie >= 9',
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4',
	'bb >= 10'
];

/**
 * Load gulp plugins and assing them semantic names.
 */
var gulp 			= require('gulp'); // Gulp of-course
var plugins 		= require('gulp-load-plugins')();
var browserSync 	= require('browser-sync').create(); // Reloads browser and injects CSS.
var reload 			= browserSync.reload; // For manual browser reload.



/**
 * Tasks
 */

 /**
  * Creates style files and put them in the root folder.
  */
 gulp.task( 'styles', function() {
 	gulp.src( watch.styles.source )
 		.pipe( plugins.sourcemaps.init() )
 		.pipe( plugins.sass( {
 			errLogToConsole: true,
 			includePaths: ['./sass'],
 			outputStyle: 'compact',
 			precision: 10
 		} ) )
 		.on('error', console.error.bind(console))
 		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
 		.pipe( plugins.sourcemaps.write ( './', { includeContent: false } ) )
 		.pipe( gulp.dest( './' ) )
 		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
 		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries
 		.pipe( plugins.cssnano())
 		.pipe( gulp.dest( './') )

 		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
 		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
 		.pipe( plugins.notify( { message: 'TASK: "styles" Completed! 💯', onLast: true } ) );
 });

 gulp.task( 'scripts', function() {
	 gulp.src( scripts.public.source )
 });

/**
 * Concatenate and uglify public JS scripts.
 */
gulp.task( 'publicJS', function() {
	gulp.src( scripts.public.source )
		.pipe( plugins.concat( scripts.public.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.public.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.public.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "publicJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify admin JS scripts.
 */
gulp.task( 'adminJS', function() {
	gulp.src( scripts.admin.source )
		.pipe( plugins.concat( scripts.admin.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.admin.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.admin.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "adminJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify customizer JS scripts.
 */
gulp.task( 'customizerJS', function() {
	gulp.src( scripts.customizer.source )
		.pipe( plugins.concat( scripts.customizer.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.customizer.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.customizer.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "customizerJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify customizer controls JS scripts.
 */
gulp.task( 'controlsJS', function() {
	gulp.src( scripts.controls.source )
		.pipe( plugins.concat( scripts.controls.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.controls.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.controls.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "controlsJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify login JS scripts.
 */
gulp.task( 'loginJS', function() {
	gulp.src( scripts.login.source )
		.pipe( plugins.concat( scripts.login.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.login.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.login.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "loginJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify vendor JS scripts.
 */
gulp.task( 'librariesJS', function() {
	gulp.src( scripts.libraries.source )
		.pipe( plugins.concat( scripts.libraries.filename + '.js' ) )
		.pipe( plugins.uglify() )
		.pipe( plugins.rename( {
			basename: scripts.libraries.filename,
			suffix: '.min'
		}))
		.pipe( gulp.dest( scripts.libraries.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "librariesJs" Completed! 💯', onLast: true } ) );
});

/**
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * @link http://www.browsersync.io/docs/options/
 */
gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: project.url,
		host: project.url,
		open: 'external',
		injectChanges: true,
		browser: "google chrome"
	});
});

/**
 * Minifies PNG, JPEG, GIF and SVG images.
 */
gulp.task( 'images', function() {
	gulp.src( images.source )
		.pipe( plugins.imagemin({
			progressive: true,
			optimizationLevel: 3, // 0-7 low-high
			interlaced: true,
			svgoPlugins: [{removeViewBox: false}]
		}))
		.pipe( gulp.dest( images.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
});

/**
 * WP POT Translation File Generator.
 */
gulp.task( 'translate', function () {
	return gulp.src( watch.php )
		.pipe( plugins.sort() )
		.pipe( plugins.wpPot( project.i18n ))
		.pipe( gulp.dest( project.i18n.path ) )
		.pipe( plugins.notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );
});

/**
* Watches for file changes and runs specific tasks.
*/
gulp.task( 'default', tasks, function () {
	gulp.watch( watch.php, reload ); // Reload on PHP file changes.
	gulp.watch( watch.styles.source, ['styles'] ); // Reload on SCSS file changes.
	gulp.watch( scripts.public.source, [ 'publicJS', reload ] ); // Reload on publicJS file changes.
	gulp.watch( scripts.admin.source, [ 'adminJS', reload ] ); // Reload on adminJS file changes.
	gulp.watch( scripts.login.source, [ 'loginJS', reload ] ); // Reload on publicJS file changes.
	gulp.watch( scripts.customizer.source, [ 'customizerJS', reload ] ); // Reload on adminJS file changes.
	gulp.watch( scripts.controls.source, [ 'controlsJS', reload ] ); // Reload on publicJS file changes.
	gulp.watch( scripts.libraries.source, [ 'librariesJS', reload ] ); // Reload on adminJS file changes.
});
