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
    .js('resources/assets/js/operations.js', 'public/js')
    .js('resources/assets/js/fees.js', 'public/js')
    .js('resources/assets/js/miners.js', 'public/js')
    .js('resources/assets/js/blocktime.js', 'public/js')
    .js('resources/assets/js/hashrate.js', 'public/js')
    .js('resources/assets/js/volume.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
