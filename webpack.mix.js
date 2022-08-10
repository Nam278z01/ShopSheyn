const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/customer/app.js", "public/js/customer.js")
    .js("resources/js/admin/app.js", "public/js/admin.js")
    .postCss("resources/css/admin/app.css", "public/css/admin.css")
    .postCss("resources/css/customer/app.css", "public/css/customer.css")
    .postCss("resources/css/customer/tailwind.css", "public/css/customer.css", [
        //
        require("tailwindcss"),
    ]);
