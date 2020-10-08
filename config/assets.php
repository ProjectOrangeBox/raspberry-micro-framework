<?php

return [
	'script' => '<script src="%%" type="text/javascript" charset="utf-8"></script>',
	'link' => '<link href="%%" type="text/css" rel="stylesheet"/>',
	'domReady' => '<script>document.addEventListener("DOMContentLoaded",function(e){%%});</script>',
	'formatter' => [],
	'add' => [
		'pet' => 'dog',
		'domready' => '/* hello */',
		'bodyclass' => ['public', 'home'],
		'title' => ['Application', 'Sample'],
		'link' => [
			'/assets/dogs.css',
			'<link href="/css/styles.css" rel="stylesheet" />',
			'<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />',
			'<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />',
		],
		'script' => [
			'/assets/more.js',
			'<script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>',
		],
	]
];
