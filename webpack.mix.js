const mix = require('laravel-mix').setPublicPath('public_html');

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

mix.js('resources/js/app.js', 'public_html/js')
    .js('resources/js/turbolinks.js', 'public_html/js')
    .postCss('resources/css/app.css', 'public_html/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/views/panel/layouts/ZedAdmin/src/css/app.css', 'public_html/themes/ZedAdmin/css', [
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]);
