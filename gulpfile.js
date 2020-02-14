var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var bourbon = require('bourbon').includePaths;
var connect = require("gulp-connect");
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var watch = require('gulp-watch');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var pump = require('pump');
var log = require('fancy-log');

// PATH objects
var paths = {
	js: ['_source/js/*.js'],
	scss: ['./_source/scss/**/*.scss'],
	inc: [bourbon, 'node_modules/susy/sass', 'node_modules/breakpoint-sass/stylesheets']
};

// Minify JS
gulp.task('js', function(e) {
	pump([
			gulp.src(paths.js),
			concat('prop-scripts.js'),
			uglify(),
			gulp.dest('assets/js/')
		],
		e
	)
	.on('end',function(){
		log('**************************************');
		log('************ JS COMPLETED ************');
		log('**************************************');
	});
});

// Compile SASS files
gulp.task('sass', function() {
	gulp.src(paths.scss)
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed',
			includePaths: paths.inc
		}).on('error', sass.logError))
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest("assets/css/"))
		.on('end',function(){
			log('***************************************');
			log('************ CSS COMPLETED ************');
			log('***************************************');
		});
});

// Set up localhost server
gulp.task('connect', function() {
  connect.server({
    port: 8000
  });
});

// Watch
gulp.task("watch", function() {
	watch('_source/scss/**/*.scss', function() { gulp.start('sass'); });
	watch('_source/js/**/*.js', function() { gulp.start('js'); });
});

// Compile all gulp tasks
gulp.task('default', ['connect', 'js', 'sass', 'watch']);