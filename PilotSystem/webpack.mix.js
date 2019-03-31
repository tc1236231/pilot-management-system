const mix = require('laravel-mix');

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

mix.scripts([
    'node_modules/mdi/css/materialdesignicons.min.css',
    'node_modules/selectize/dist/js/selectize.js'
],  'public/js/app.js')

    .styles([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/mdi/css/materialdesignicons.min.css',
        'resources/assets/css/app.css'
    ],  'public/css/app.css');