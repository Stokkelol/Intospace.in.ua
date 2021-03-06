process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix.sass(['style.scss'], 'public/css/styles.css');

    mix.sass(['backend.scss'], 'public/css/backend.css');

    mix.styles([
        'font-awesome.min.css',
        'bootstrap.min.css',
        'normalize.css',
        'select2.min.css'
    ], 'public/css/all.css');

    mix.styles([
        'font-awesome.min.css',
        'bootstrap.min.css',
        'normalize.css',
        'component.css',
        'lazyYT.css',
        'lightslider.css',
        'jquery.fancybox.css',
        'jquery.fancybox-buttons.css',
        'jquery.fancybox-thumbs.css'
    ], 'public/css/libs.css');

    mix.scripts([
        'jquery-2.2.3.min.js',
        'bootstrap.min.js',
        'select2.min.js',
        'modernizr.custom.js',
        'jquery.sticky-kit.min.js',
        'lazyYT.js',
        'scripts.js',
        'vue.min.js',
        'lightslider.js',
        'vuemain.js',
        'jquery.mousewheel-3.0.6.pack.js',
        'jquery.fancybox.js',
        'jquery.fancybox.pack.js',
        'jquery.fancybox-buttons.js',
        'jquery.fancybox-media.js',
        'jquery.fancybox-thumbs.js'
        ], 'public/js/all.js');

    mix.version([
        'public/css/all.css',
        'public/js/all.js',
        'public/css/app.css',
        'public/css/styles.css',
        'public/css/libs.css',
        'public/css/backend.css',
    ]);
});
