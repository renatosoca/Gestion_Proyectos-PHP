const { src, dest, watch, parallel } = require("gulp");

// CSS
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const postcss = require("gulp-postcss");
const sourcemaps = require("gulp-sourcemaps");

// Images
const cache = require("gulp-cache");
const imagemin = require("gulp-imagemin");
const webp = require("gulp-webp");
const avif = require("gulp-avif");

// JS
const terser = require("gulp-terser-js");
const concat = require("gulp-concat");
const rename = require("gulp-rename");

//Webpack
const webpack = require("webpack-stream");

const paths = {
  scss: "src/scss/**/*.scss",
  js: "src/js/**/*.js",
  images: "src/img/**/*",
};

function css() {
  return (
    src(paths.scss)
      .pipe(sourcemaps.init())
      .pipe(sass())
      //.pipe( sass({outputStyle: 'expanded'}))
      .pipe(postcss([autoprefixer(), cssnano()]))
      .pipe(sourcemaps.write("."))
      .pipe(dest("public/build/css"))
  );
}

function javascript() {
  return src(paths.js)
    .pipe(
      webpack({
        module: {
          rules: [
            {
              test: /\.css$/i,
              use: ["style-loader", "css-loader"],
            },
          ],
        },
        mode: "production",
        entry: "./src/js/app.js",
        watch: true,
      })
    )
    .pipe(sourcemaps.init())
    .pipe(concat("bundle.js"))
    .pipe(terser())
    .pipe(sourcemaps.write("."))
    .pipe(rename({ suffix: ".min" }))
    .pipe(dest("./public/build/js"));
}

function images() {
  return src(paths.images)
    .pipe(
      cache(
        imagemin({
          optimizationLevel: 3,
        })
      )
    )
    .pipe(dest("public/build/img"));
}

function imagesWebp() {
  return src(paths.images)
    .pipe(
      webp({
        quality: 50,
      })
    )
    .pipe(dest("public/build/img"));
}

function imagesAvif() {
  return src(paths.images)
    .pipe(
      avif({
        quality: 50,
      })
    )
    .pipe(dest("public/build/img"));
}

function dev(done) {
  watch(paths.scss, css);
  watch(paths.js, javascript);
  watch(paths.images, images);
  watch(paths.images, imagesWebp);
  watch(paths.images, imagesAvif);
  done();
}

exports.default = parallel(
  css,
  images,
  imagesWebp,
  imagesAvif,
  javascript,
  dev
);
