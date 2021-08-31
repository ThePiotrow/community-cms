const mix = require('laravel-mix');

mix.setPublicPath('./dist');

mix.babel(['./src/js/jQuery.js', './src/js/main.js'], './dist/js/app.js');

mix.sass('./src/scss/back.style.scss', './dist/css/back.style.css');
mix.sass('./src/scss/front.style.scss', './dist/css/front.style.css');

mix.disableSuccessNotifications();

module.exports = {
	watch: true,
	mode: 'production',
};