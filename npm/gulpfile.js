var gulp    = require("gulp"),
    run     = require('gulp-run'),
    connect = require('gulp-connect');

var watchList = [
    '../src/parse/*.htm',
    '../src/template.htm',
];

gulp.task('connect', function () {
    connect.server({
        root: '../home/',
        livereload: true
    });
});

gulp.task('list', function () {
    gulp.src(watchList)
        .pipe(connect.reload());
});

gulp.task('php-build', function () {
    run('php -q ../shell/build.php')
        .exec();
        // .pipe(gulp.dest('output'));
});

gulp.task('watch', function () {
    gulp.watch( watchList, ['list', 'php-build']);
});

// --------------------------------------------------------------------------------
/**
 *  front-end resource
 */
gulp.task('toAssets', function () {
    gulp.src('./node_modules/jquery/dist/*')        .pipe(gulp.dest("../home/assets/jquery/"));
    gulp.src('./node_modules/bootstrap/dist/**')    .pipe(gulp.dest("../home/assets/bootstrap/"));
    gulp.src('./node_modules/lodash/lodash.js')     .pipe(gulp.dest("../home/assets/lodash/"));
    gulp.src('./node_modules/babel-core/browser.*') .pipe(gulp.dest("../home/assets/babel-core/"));
});

// --------------------------------------------------------------------------------
gulp.task('default', function() {
    gulp.run('connect', 'watch', 'toAssets');
});
