let mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'app/assets/components/common/css/all.css');

mix.js([
    'resources/js/app.js',
], 'app/assets/components/common/js/all.js');

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
], 'app/assets/libs/js/libs.js');