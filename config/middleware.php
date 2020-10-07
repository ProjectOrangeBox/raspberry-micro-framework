<?php

return [
	'all' => ['get', 'cli', 'post', 'put', 'delete'], /* optional */
	'default' => ['get'], /* optional */
	'request format' => 'human', /* optional */
	'response format' => 'human', /* optional */
	/* Collects ALL matching - value can be an array or string */
	'request' => [
		'(.*)' => \application\middleware\main::class,
	],
	'response' => [
		'(.*)' => \application\middleware\main::class,
	],
];
