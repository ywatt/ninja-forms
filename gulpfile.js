/**
 * Gulpfile
 *
 * Rename and Minify JavaScript... and more (later).
 *
 * Install Command:
 * npm install gulp gulp-rename gulp-uglify
 */

var gulp   = require('gulp');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

gulp.task('js', function () {
    return gulp.src('assets/js/dev/nf-upgrade-handler.js')
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('assets/js/min/')); //the destination folder
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('assets/js/dev/nf-upgrade-handler.js', ['js']);
});

// Default Task
gulp.task('default', ['js', 'watch']);

function swallowError (error) {
    //If you want details of the error in the console
    console.log(error.toString());
    this.emit('end');
}