const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

// Compile SCSS
function compileSCSS() {
    return gulp.src('assets/css/zoo-styles.scss')
        .pipe(sass({
            includePaths: ['node_modules']
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(gulp.dest('assets/css/'))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('assets/css/'));
}

// Watch for changes
function watchSCSS() {
    gulp.watch('assets/css/**/*.scss', compileSCSS);
}

// Default task
gulp.task('build', compileSCSS);
gulp.task('watch', gulp.series('build', watchSCSS));
gulp.task('default', gulp.series('build'));