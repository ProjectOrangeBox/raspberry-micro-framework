<?php

return [
	'path' => '/var/cache',
	'ttl' => 60,
	'memcache servers' => [
		[
			'host'		=> '127.0.0.1',
			'port'		=> 11211,
			'weight'	=> 1
		],
	],
];
