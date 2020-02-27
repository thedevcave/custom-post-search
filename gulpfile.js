var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var pump	= require('pump');

// PATH objects
var paths = {
	js: ['_src/js/*.js'],
	scss: ['./_src/scss/**/*.scss'],
	inc: ['node_modules/breakpoint-sass/stylesheets']
};

// Minify JS
gulp.task('js', function(e) {
	pump([
			gulp.src(paths.js),
			uglify(),
			gulp.dest('assets/js/')
		],e)
		.pipe(notify({ message: 'JS complete!' }));
});

// Compile SASS files
gulp.task('sass', function() {
	gulp.src(paths.scss)
		.pipe(sass({
			outputStyle: 'compressed',
			includePaths: paths.inc
		}).on('error', sass.logError))
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest("assets/css/"))
		.pipe(notify({ message: 'CSS complete!' }));
});

// Watch
gulp.task("watch", function() {
	watch('_src/scss/**/*.scss', function() { gulp.start('sass'); });
	watch('_src/js/**/*.js', function() { gulp.start('js'); });
});

// Compile all gulp tasks
gulp.task('default', ['js', 'sass', 'watch']);