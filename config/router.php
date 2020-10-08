<?php

return [
	'all' => ['get', 'cli', 'post', 'put', 'delete'], /* optional */
	'default' => ['get'], /* optional */
	'routes format' => 'human', /* optional */
	'routes' => [
		/* default routes */
		'/help' => [\application\controllers\main::class, 'help'],
		'/foobar' => [\application\controllers\Foobar::class, 'index'],
		'/test(?<number>\d+)' => [\application\controllers\main::class, 'test<number>', ['product<number>', '<number>']],

		/* json rest example */
		'/rest/index' => [\application\controllers\rest::class, 'index'],
		'/rest/show/(?<hex>[0-9A-F]+)' => [\application\controllers\rest::class, 'show', ['<hex>']],

		'/rest/new' => [\application\controllers\rest::class, 'new'],
		'[post]/rest/create' => [\application\controllers\rest::class, 'create'],

		'/rest/remove/(?<hex>[0-9A-F]+)' => [\application\controllers\rest::class, 'remove', ['<hex>']],
		'/rest/delete/(?<hex>[0-9A-F]+)' => [\application\controllers\rest::class, 'delete', ['<hex>']],

		'/rest/edit/(?<hex>[0-9A-F]+)' => [\application\controllers\rest::class, 'edit', ['<hex>']],
		'[post]/rest/update/(?<hex>[0-9A-F]+)' => [\application\controllers\rest::class, 'update', ['<hex>']],
		/* end json rest example */

		'/handlebars' => [\application\controllers\handlebars::class, 'index'],
		'/warm' => [\application\controllers\handlebars::class, 'warm'],

		'[cli & delete]/collect' => [\application\controllers\main::class, 'collect'],
		'/phpinfo' => [\application\controllers\main::class, 'phpinfo'],

		'[post]/' =>	[\application\controllers\formPost::class, 'post'],

		/* all routes */
		'[@]/' => [\application\controllers\main::class, 'index'],
		'[@]/(.*)' => [\application\controllers\main::class, 'fourohfour'],
	],
];
