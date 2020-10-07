<?php

namespace application\middleware;

use projectorangebox\middleware\Middleware;
use projectorangebox\middleware\MiddlewareRequest;
use projectorangebox\middleware\MiddlewareResponse;

class main extends Middleware
{
	public function request(MiddlewareRequest &$payload)
	{
		$this->request->set('ipAddress', '127.0.0.1');
	}

	public function response(MiddlewareResponse &$payload)
	{
		$output = $payload->response->get();

		$output = str_replace('<head>', '<head><meta name="foo" content="bar" />', $output);

		$payload->response->set($output);
	}
} /* end class */
