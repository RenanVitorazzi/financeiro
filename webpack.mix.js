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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();
// mix.js('resources/views/js/cep.js', 'public/js/cep.js');
const webpack = require('webpack');

mix.webpackConfig({
  plugins: [
    new webpack.ProvidePlugin({
        '$': 'jquery',
        'jQuery': 'jquery',
        'window.jQuery': 'jquery',
    }),
  ]
});

mix.autoload({
    jquery: ['$', 'window.$', 'window.jQuery', 'jQuery']
});

mix
  .sass('resources/views/scss/styles.scss', 'public/style.css')
  
  .copy('node_modules/jquery/dist/jquery.js', 'public/js/jquery.js')
  .js('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/js/bootstrap.js')

  .styles('resources/views/navbar.css', 'public/navbar.css');
