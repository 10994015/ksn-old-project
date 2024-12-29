const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/airplane.js', 'public/js/airplane.js')
    .js('resources/js/horizontal.js', 'public/js/horizontal.js')
    .js('resources/js/money.js', 'public/js/money.js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]).sass('resources/sass/style.scss', 'public/css/style4.css')
    .sass('resources/sass/error.sass', 'public/css/error.css');
    
