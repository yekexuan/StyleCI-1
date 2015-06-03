var elixir = require('laravel-elixir');

// Enabling babel makes elixir scripts really slow.
elixir.config.babel.enabled = false;
elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass('app.scss')
        .scripts([
            'vendor/bower_components/jquery/dist/jquery.js',
            'vendor/bower_components/lodash/lodash.js',
            'vendor/bower_components/jquery-timeago/jquery.timeago.js',
            'vendor/bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js',
            'vendor/bower_components/xregexp/xregexp-all.js',
            'vendor/bower_components/SyntaxHighlighter/src/js/shCore.js',
            'vendor/bower_components/pusher/dist/pusher.js',
            'vendor/bower_components/fuse.js/src/fuse.js',
            'resources/assets/js/**/*.js',
            'resources/assets/js/app.js',
        ], 'public/dist/js/app.js', './')
        .version(['dist/css/app.css', 'dist/js/app.js'])
        .copy("vendor/bower_components/font-awesome/fonts/", "public/fonts/");
});
