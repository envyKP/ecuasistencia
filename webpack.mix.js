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

 /*   mix.js('resources/js/app.js', 'public/js')
        .sass('resources/sass/app.scss', 'public/css')
        .sourceMaps();
*/
    mix.js('resources/js/app.js', 'public/js')
    .sass('public/admin/scss/style.scss', 'public/css', [
        //
    ]);

    mix.js('public/admin/js/charts.js', 'public/js');
    mix.js('public/admin/js/colors.js', 'public/js');
    mix.js('public/admin/js/main.js', 'public/js');
    mix.js('public/admin/js/popovers.js', 'public/js');
    mix.js('public/admin/js/tooltips.js', 'public/js');
    mix.js('public/admin/js/widgets.js', 'public/js');
