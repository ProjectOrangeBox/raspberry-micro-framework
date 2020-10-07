<?php

namespace application\controllers;

use projectorangebox\dispatcher\Controller;

class formPost extends Controller
{
	public function post(): string
	{
		return $this->view->render('welcome', ['name' => 'Johnny Appleseed']);
	}
} /* end class */
