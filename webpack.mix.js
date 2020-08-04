const mix = require("laravel-mix");

mix
  .copy("src/resources/img/**/*", "public/img")
  .js("src/resources/js/laraberg.js", "public/js")
  .sass("src/resources/scss/laraberg.scss", "public/css")
  .minify("public/js/laraberg.js")
  .minify("public/css/laraberg.css")
  .options({
    autoprefixer: {
      options: {
        browsers: ["> 0.25%, not dead"],
      },
    },
  })
;
