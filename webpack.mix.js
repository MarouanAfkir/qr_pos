const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management (Vue 2)
 |--------------------------------------------------------------------------
 */

mix.js("resources/js/app.js", "public/js")
    .vue({ version: 2 })
    //    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false, // keeps your font/img URLs untouched
        postCss: [require("autoprefixer")],
    })
    .sourceMaps(false)
    .version(); // cache-busting in production
