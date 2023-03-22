/**
 * @see https://github.com/gbiorczyk/mati-mix/
 */
const mix = require( 'mati-mix' );

mix.js(
	[
		'assets/src/js/classes/Admin.js',
	],
	'assets/dist/Admin/Assets.js'
);
mix.js(
	[
		'assets/src/js/classes/Bar.js',
	],
	'assets/dist/Admin/Bar.js'
);
mix.js(
	[
		'assets/src/js/vendors/polyfills/*.js',
		'assets/src/js/classes/Forms.js',
	],
	'assets/dist/Forms/Scripts.js'
);

mix.sass(
	'assets/src/scss/Admin.scss',
	'assets/dist/Admin/Assets.css'
);
mix.sass(
	'assets/src/scss/Bar.scss',
	'assets/dist/Admin/Bar.css'
);
