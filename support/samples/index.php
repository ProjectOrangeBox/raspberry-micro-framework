<?php

define('__ROOT__', dirname(__DIR__));

require __ROOT__ . '/vendor/autoload.php';

$develop = true;

if (!$develop) {
	if (!file_exists(__ROOT__ . '/var/cache/config.php')) {
		\projectorangebox\box\ConfigCollector::generateFile('config', '/var/cache/config.php');
	}

	if (!file_exists(__ROOT__ . '/var/cache/env.php')) {
		\projectorangebox\box\EnvCollector::generateFile('.env', '/var/cache/env.php');
	}

	$envArray = require __ROOT__ . '/var/cache/env.php';
	$config = require __ROOT__ . '/var/cache/config.php';

	mergeWithEnv($envArray);
} else {
	$config = require __ROOT__ . '/config/config.php';
}

(new projectorangebox\app\App($config))->dispatch();
