<?php

namespace application\controllers;

use projectorangebox\dispatcher\Controller;

class handlebars extends Controller
{
	public function index(): string
	{
		return $this->viewparser->render('handlebars/template', $this->getData());
	}

	public function warm(): void
	{
		$compiled = $this->viewparser->preCache();

		echo '<pre>' . print_r($compiled, true);
	}

	protected function getData()
	{
		return array(
			'page_title' => 'Current Projects',
			'uppercase' => 'lowercase words',
			'projects' => array(
				array(
					'name' => 'Acme Site',
					'assignees' => array(
						array('name' => 'Dan', 'age' => 21),
						array('name' => 'Phil', 'age' => 12),
						array('name' => 'Don', 'age' => 34),
						array('name' => 'Pete', 'age' => 18),
					),
				),
				array(
					'name' => 'Lex',
					'contributors' => array(
						array('name' => 'Dan', 'age' => 18),
						array('name' => 'Ziggy', 'age' => 16),
						array('name' => 'Jerel', 'age' => 7)
					),
				),
			),
		);
	}
} /* end class */
