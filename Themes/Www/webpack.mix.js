const mix = require('laravel-mix');
const shell = require('shelljs');
const themeInfo = require('./theme.json');

mix.setPublicPath('./assets')
mix.options({ processCssUrls: false })

/**
 * Copy node module
 */
mix.copy('node_modules/font-awesome/fonts', 'assets/fonts');

mix.autoload({
	'jquery': ['$', 'window.jQuery', 'jQuery'],
	'vue': ['Vue','window.Vue'],
});

//Mix js and css versioning
mix.js('resources/assets/js/app.js', 'assets/js/app.js')
	.scripts([
		'node_modules/pace-progress/pace.js',
		'node_modules/jquery/dist/jquery.js',
		'node_modules/bootstrap/dist/js/bootstrap.js',
		'node_modules/select2/dist/js/select2.full.js',
	], 'assets/js/theme.js')
	.combine([
		'node_modules/pace-progress/themes/blue/pace-theme-flash.css',
		'node_modules/bootstrap/dist/css/bootstrap.min.css',
		'node_modules/font-awesome/css/font-awesome.min.css',
		'node_modules/select2/dist/css/select2.css',
	], 'assets/css/theme.css')
	.version()
	.then(() => {
		shell.exec(`cd ../../ && php artisan stylist:publish ${themeInfo.name}`);
	});