let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/misc.js', 'public/js')
    .js('resources/assets/js/stats/operations.js', 'public/js')
    .js('resources/assets/js/stats/fees.js', 'public/js')
    .js('resources/assets/js/stats/miners.js', 'public/js')
    .js('resources/assets/js/stats/blocktime.js', 'public/js')
    .js('resources/assets/js/stats/hashrate.js', 'public/js')
    .js('resources/assets/js/stats/volume.js', 'public/js')
    .js('resources/assets/js/stats/richest.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
