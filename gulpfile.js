var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass('app.scss', 'public/dist/css/app.css')
        .scripts([
            'vendor/bower_components/jquery/dist/jquery.js',
            'vendor/bower_components/vue/dist/vue.js',
            'vendor/bower_components/lodash/lodash.js',
            'vendor/bower_components/jquery-timeago/jquery.timeago.js',
            'vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
            'vendor/bower_components/xregexp/xregexp-all.js',
            'vendor/bower_components/SyntaxHighlighter/src/js/shCore.js',
            'vendor/bower_components/pusher/dist/pusher.js',
            'resources/assets/js/**/*.js',
            'resources/assets/js/app.js',
        ], 'public/dist/js/app.js', './')
        .version(['public/dist/css/app.css', 'public/dist/js/app.js'])
        .copy("vendor/bower_components/font-awesome/fonts/", "public/fonts/");
});
