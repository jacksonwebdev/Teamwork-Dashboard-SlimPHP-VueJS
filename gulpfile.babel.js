
/**
 * minify CSS
 * concat and uglify JS
 * watch
 * build manually
 */

/*jslint node: true, nomen:true*/
/*env:node*/

"use strict";
require("dotenv").config({"silent": true});

// Initialize modules
var gulp = require('gulp');
var $ = require('gulp-load-plugins')({lazy: true});
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var include = require('gulp-include');
var sourcemaps = require('gulp-sourcemaps');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var browserify = require('browserify');
var babel = require('babelify');
var envify = require("gulp-envify");
var vueify = require("vueify");
var del = require('del');
var notify = require("gulp-notify");

// Sass task: compiles the style.scss file into style.css
function doSass(){
    return gulp.src('assets/scss/application.scss')
        // include semantic SASS from node_modules
        .pipe($.sass({
            includePaths: [
              './node_modules/semantic-ui-sass'
            ]
        }))
        .pipe(sass()) // compile SCSS to CSS
        .pipe(cssnano()) // minify CSS
        .pipe(rename('application.min.css'))
        .pipe(gulp.dest('public/assets/css'))// put final CSS in dist folder
        .pipe(notify("SASS Finished"));
};

function doIcons() {
  return gulp.src('node_modules/@fortawesome/fontawesome-free/webfonts/*')
      .pipe(gulp.dest('public/assets/webfonts/'))
      .pipe(notify("Icons Finished"));
};

// JS task: concatenates and uglifies JS files to script.js
function browserifyJS(){
  var b =  browserify({
      entries: 'assets/js/bootstrap.js',
      //debug: true
    })
    .transform(babel)
    .transform(vueify);

  return b
    .bundle()
    .pipe(source('bundle.js'))
    // .pipe(buffer())
    // .pipe(uglify())
    // .pipe(sourcemaps.init({loadMaps: true}))
    // .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./assets/js/bundled'));

};

function customJS(){
    return gulp
        .src([
            './assets/js/vendor/semantic.min.js',
            './assets/js/bundled/bundle.js'
        ])
        .pipe(concat('./assets/js/bundled/bundled-everything.js'))
        .pipe(rename('application.min.js'))
        //.pipe(uglify())
        // .pipe(sourcemaps.init({loadMaps: true}))
        // .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('public/assets/js'))
        .pipe(notify("JS Finished"));

};

// Watch files
function watchFiles() {
  return new Promise(function(resolve, reject) {
    gulp.watch('assets/scss/**/*.scss', gulp.series(doSass, doIcons));
    gulp.watch([
      'assets/js/**/*.js',
      'assets/js/**/*.vue',
      '!/assets/js/bundled/bundle.js',
      '!/assets/js/bundled/bundled-everything.js'
    ], gulp.series(browserifyJS, customJS));
    resolve();
  });
}
exports.watch = gulp.parallel(watchFiles);
exports.default = gulp.series(sass, browserifyJS, customJS);
exports.browserifyJS = gulp.series(browserifyJS);
exports.js = gulp.series(browserifyJS, customJS);
exports.sass = gulp.series(doSass, doIcons);
exports.icons = gulp.series(doIcons);