let mix = require('laravel-mix')
const path = require('path')

mix.options({ legacyNodePolyfills: false })
    .js('resources/js/laraberg.js', 'js')
    //.sass('resources/scss/laraberg.scss', 'css')
    .webpackConfig({
        output: {
            library: 'Laraberg'
        }
    })
    .setPublicPath('public')
console.log(mix.dumpWebpackConfig())
