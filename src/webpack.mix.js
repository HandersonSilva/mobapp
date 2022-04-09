// @ts-ignore
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

// @ts-ignore
// 'public/js/backoffice/constantes.js',
mix.sass('public/sass/style.scss', 'public/css');
// @ts-ignore
mix.js('public/js/backoffice/_start.js', 'public/js/dist/app.js');
mix.sourceMaps();
