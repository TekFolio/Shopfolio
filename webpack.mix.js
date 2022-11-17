const mix = require('laravel-mix');

mix.disableSuccessNotifications();
mix.options({
  terser: {
    extractComments: false,
  },
});
mix.setPublicPath('public')
  .setResourceRoot('../');

mix.js('./resources/js/shopfolio.js', 'js').react()
  .postCss('resources/css/shopfolio.css', 'css',[
    require('tailwindcss'),
    require('autoprefixer'),
  ])
  .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
  mix.version();
}
