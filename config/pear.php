<?php

return [
	'plugin folder' => '/pears/',
	'plugin extension' => 'php',
	'plugins' => [
		'PearAsset' => \projectorangebox\assets\pears\PearAsset::class,
		'PearBlock' => \projectorangebox\pear\pears\PearBlock::class,
		'PearE' => \projectorangebox\pear\pears\PearE::class,
		'PearEnd' => \projectorangebox\pear\pears\PearEnd::class,
		'PearExtend' => \projectorangebox\pear\pears\PearExtend::class,
		'PearExtending' => \projectorangebox\pear\pears\PearExtending::class,
		'PearGet' => \projectorangebox\pear\pears\PearGet::class,
		'PearHtml' => \projectorangebox\pear\pears\PearHtml::class,
		'PearInclude' => \projectorangebox\pear\pears\PearInclude::class,
		'PearPlugins' => \projectorangebox\pear\pears\PearPlugins::class,
		'PearSet' => \projectorangebox\pear\pears\PearSet::class,
	],
];
