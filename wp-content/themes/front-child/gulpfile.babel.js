// npm run start
// npm run build
import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from "browser-sync";
import info from "./package.json";
  const PRODUCTION = yargs.argv.prod;
  const server = browserSync.create();
  export const serve = done => {
    server.init({
      proxy: "http://localhost:8888/cosmos-job-board"
    });
    done();
  };
  export const reload = done => {
    server.reload();
    done();
  };
  export const clean = () => del(['dist']);
    
  export const styles = () => {
  return src(['assets/scss/main.scss'])
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write('/')))
    .pipe(dest('dist/css'))
    .pipe(server.stream());
  }
  export const fonts = () => {
  return src('assets/fonts/**/*')
    .pipe(dest('dist/fonts'));
  }
  export const images = () => {
    return src('assets/img/**/*.{jpg,jpeg,png,svg,gif}')
    return gulp.src(globs.fonts)
      .pipe(flatten())
      .pipe(gulp.dest(path.dist + 'fonts'))
      .pipe(browserSync.stream());
  }
  export const copy = () => {
    return src(['assets/**/*','!assets/{images,js,scss,fonts}','!assets/{images,js,scss,fonts}/**/*'])
    .pipe(dest('dist'));
  }
  export const scripts = () => {
    return src(['assets/js/main.js'])
    .pipe(named())
    .pipe(webpack({
      module: {
      rules: [
        {
          test: /\.js$/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: []
              }
            }
          }
        ]
      },
      mode: PRODUCTION ? 'production' : 'development',
      devtool: !PRODUCTION ? 'source-map' : false,
      output: {
        filename: '[name].js'
      },
      externals: {
        jquery: 'jQuery'
      },
    }))
    .pipe(dest('dist/js'));
  }
  export const watchForChanges = () => {
    watch('assets/scss/**/*.scss', styles);
    watch('assets/img/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(['assets/**/*','!assets/{images,js,scss,fonts}','!assets/{images,js,scss,fonts}/**/*'], series(copy, reload));
    watch('assets/js/**/*.js', series(scripts, reload));
    watch("**/*.php", reload);
  } 
  export const dev = series(clean, parallel(styles, images, copy, scripts, fonts), serve, watchForChanges);
  export const build = series(clean, parallel(styles, images, copy, scripts,fonts));
  export default dev;