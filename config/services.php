<?php

return [
	'config' => [function ($container) {
		return new \projectorangebox\config\ConfigFile(require __ROOT__ . '/config/config.php');
	}],
	'dispatcher' => [function ($container) {
		return new \projectorangebox\dispatcher\Dispatcher(['containerService' => $container]);
	}],
	'request' => [function ($container) {
		return new \projectorangebox\request\Request($container->config->get('request', []));
	}],
	'response' => [function ($container) {
		return new \projectorangebox\response\Response($container->config->get('response', []));
	}],
	'event' => [function ($container) {
		return new \projectorangebox\events\Events($container->config->get('event', []));
	}],
	'log' => [function ($container) {
		return new \projectorangebox\log\handlers\File($container->config->get('log', []));
	}],
	'collection' => [function ($container) {
		return new \projectorangebox\collection\Collection($container->config->get('collection', []));
	}],
	'router' => [function ($container) {
		$config = $container->config->get('router', []);

		if ($config['routes format'] != 'raw') {
			/* the router expects these to be formmated correctly not in shorthand */
			$config['routes'] = \projectorangebox\router\Formatter::format($config);

			\FS::var_export_file('/var/tmp/routes.php', $config['routes'], 0666);
		}

		return new \projectorangebox\router\Router($config);
	}],
	'middleware' => [function ($container) {
		$config = $container->config->get('middleware', []);

		$config['containerService'] = $container;

		if ($config['request format'] != 'raw') {
			/* the middleware expects these to be formmated correctly not in shorthand */
			$config['request'] = \projectorangebox\router\Formatter::format($config + ['routes' => $config['request']]);

			\FS::var_export_file('/var/tmp/middleware_request.php', $config['request'], 0666);
		}

		if ($config['response format'] != 'raw') {
			/* the middleware expects these to be formmated correctly not in shorthand */
			$config['response'] = \projectorangebox\router\Formatter::format($config + ['routes' => $config['response']]);

			\FS::var_export_file('/var/tmp/middleware_response.php', $config['response'], 0666);
		}

		return new \projectorangebox\middleware\MiddlewareHandler($config);
	}],
	'cache' => [function ($container) {
		return new \projectorangebox\cache\CacheFile($container->config->get('cache', []));
	}],
	'cachep' => [function ($container) {
		$config = $container->config->get('cache', []);

		$config['path'] = '/var/cache2';

		return new \projectorangebox\cache\CachePhp($config);
	}],
	'redis'	=> [function ($container) {
		$config = [
			'redis' => [
				'server' => env('REDIS_SERVER'),
				'port' => env('REDIS_PORT'),
				'password' => env('REDIS_PASSWORD'),
			]
		];

		return new \projectorangebox\cache\CacheRedis($config);
	}],
	'session' => [function ($container) {
		$config = $container->config->get('session', []);

		$config['isAjax'] = $container->request->isAjax();

		return new \projectorangebox\session\Session($config);
	}],
	'view' => [function ($container) {
		$config = $container->config->get('views', []);

		if (!isset($config['views'])) {
			$config['views'] = \projectorangebox\views\Collector::collect($config);

			\FS::var_export_file('/var/tmp/views.php', $config, 0666);
		}

		return new \projectorangebox\views\Views($config);
	}],
	'assets' => [function ($container) {
		$config = $container->config->get('assets', []);

		return new \projectorangebox\assets\Assets($config);
	}],
	'pear' => [function ($container) {
		$config = $container->config->get('pear', []);

		if (!isset($config['plugins'])) {
			$config['plugins'] = \projectorangebox\pear\Collector::collect($config);

			\FS::file_put_contents('/var/tmp/pears.php', str_replace('\\\\', '\\', preg_replace('%(.+)\'(?<name>[a-zA-Z0-9_]+)\' => \'\\\\(?<value>.+)\',%i', '\'$2\' => \\\\$3::class,', FS::var_export_php($config))), 0666);
		}

		return new \projectorangebox\pear\PearSkin($config + ['viewService' => $container->view]);
	}],
	/* factory - new instance each time */
	'validate' => [function ($container) {
		$config = $container->config->get('validate', []);

		if (!isset($config['rules'], $config['filters'])) {
			$config = \projectorangebox\validate\Collector::collect($config);

			\FS::file_put_contents('/var/tmp/rules_filters.php', str_replace('\\\\', '\\', preg_replace('%(.+)\'(?<name>[a-zA-Z0-9_]+)\' => \'\\\\(?<value>.+)\',%i', '\'$2\' => \\\\$3::class,', FS::var_export_php($config))), 0666);
		}

		return new \projectorangebox\validate\Validate($config);
	}, false],
	'database' => [function ($container) {
		$connections = $container->config->get('connections', []);

		return new \Medoo\Medoo($connections['db']['default']);
	}],
	'viewparser' => [function ($container) {
		$config = $container->config->get('viewparser', []);

		if (!isset($config['views'])) {
			$config['views'] = \projectorangebox\views\Collector::collect($config);

			\FS::var_export_file('/var/tmp/handlebar.views.php', $config, 0666);
		}

		if (!isset($config['plugins'])) {
			$config['plugins'] = \projectorangebox\handlebars\PluginCollector::collect($config);

			\FS::var_export_file('/var/tmp/plugins.php', $config['plugins'], 0666);
		}

		return new \projectorangebox\handlebars\Handlebars($config);
	}],
	'model->Auth' => [function ($container) {
		$connections = $container->config->get('connections', []);

		$config['db'] = new \Medoo\Medoo($connections['db']['default']);
		$config['validationService'] = $container->validate;

		return new \projectorangebox\auth\AuthModel($config);
	}],
	'model->Users' => [function ($container) {
		$connections = $container->config->get('connections', []);

		$config['db'] = new \Medoo\Medoo($connections['db']['default']);
		$config['validationService'] = $container->validate;

		return new \projectorangebox\auth\AuthModel($config);
	}],
	'model->Usersmeta' => [function ($container) {
		$connections = $container->config->get('connections', []);

		$config['db'] = new \Medoo\Medoo($connections['db']['default']);
		$config['validationService'] = $container->validate;

		return new \projectorangebox\auth\AuthModel($config);
	}],
	'model->Roles' => [function ($container) {
		$connections = $container->config->get('connections', []);

		$config['db'] = new \Medoo\Medoo($connections['db']['default']);
		$config['validationService'] = $container->validate;

		return new \projectorangebox\auth\AuthModel($config);
	}],
	'model->Access' => [function ($container) {
		$connections = $container->config->get('connections', []);

		$config['db'] = new \Medoo\Medoo($connections['db']['default']);
		$config['validationService'] = $container->validate;

		return new \projectorangebox\auth\AuthModel($config);
	}],

];
