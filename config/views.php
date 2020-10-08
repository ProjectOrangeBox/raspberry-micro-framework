<?php

return [
	'view folder' => '/views/',
	'view extension' => 'php',
	'data' => [
		'name' => 'Don Meyers',
		'address' => '12 South Main Street<br>Phoenixville, Pa 19460',
		'year' => date('Y'),
	],
	'views' =>
	array(
		'shipping/index' => '/views/shipping/index.php',
		'shipping/details' => '/views/shipping/details.php',
		'welcome' => '/views/welcome.php',
		'parts/footer' => '/views/parts/footer.php',
		'parts/nav' => '/views/parts/nav.php',
		'parts/block/cabin' => '/views/parts/block/cabin.php',
		'parts/block/cake' => '/views/parts/block/cake.php',
		'parts/block/safe' => '/views/parts/block/safe.php',
		'parts/block/circus' => '/views/parts/block/circus.php',
		'parts/block/game' => '/views/parts/block/game.php',
		'parts/block/submarine' => '/views/parts/block/submarine.php',
		'parts/block/form' => '/views/parts/block/form.php',
		'parts/scripts' => '/views/parts/scripts.php',
		'parts/header' => '/views/parts/header.php',
		'parts/head' => '/views/parts/head.php',
		'backorder/index' => '/views/backorder/index.php',
		'backorder/details' => '/views/backorder/details.php',
		'default' => '/views/default.php',
		'errors/html/404' => '/views/errors/html/404.php',
		'errors/html/500' => '/views/errors/html/500.php',
		'errors/ajax/500' => '/views/errors/ajax/500.php',
		'errors/cli/500' => '/views/errors/cli/500.php',
		'errors/html/error' => '/views/errors/html/error.php',
		'errors/ajax/send' => '/views/errors/ajax/send.php',
		'errors/html/exception' => '/views/errors/html/exception.php',
	),
];
