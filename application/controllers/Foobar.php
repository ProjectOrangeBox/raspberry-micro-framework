<?php

namespace application\controllers;

use projectorangebox\assets\Assets;
use projectorangebox\dispatcher\Controller;

class Foobar extends Controller
{
	public function index(): void
	{
		echo 'start' . EOL . '<pre>';

		$this->assets->jsvariable('food', 'pizza');

		$this->assets->script('newfile.js');
		$this->assets->script(['aaa.js', 'bbb.js', 'ccc.js']);

		$this->assets->link('newfile.css');
		$this->assets->link(['aaa.css', 'bbb.css', 'ccc.css']);

		$this->assets->jsvariable('name', 'Johnny Appleseed');
		$this->assets->jsvariable('age', 23);
		$this->assets->jsvariable('foo', 'bar');
		$this->assets->jsvariable([['namef', 'varfff'], ['israw', '{}', true]]);

		$this->assets->metaTag('name', 'value');
		$this->assets->metaTag('foo', 'bar', 'FIRST');
		$this->assets->metaTag([['name', 'true'], ['age', 18, 'content']]);

		$this->assets->foo('ZZZ ');
		$this->assets->foo('AAA ');
		$this->assets->foo('BBB ');
		$this->assets->foo('CCC1 ');
		$this->assets->foo('CCC2 ');
		$this->assets->foo('DDD ');
		$this->assets->foo('CCC3 ');

		$this->assets->bar('Please');
		$this->assets->priority(ASSETS::PRIORITY_LAST)->bar('LAST');
		$this->assets->bar('Keep');
		$this->assets->bar('This');
		$this->assets->priority(ASSETS::PRIORITY_FIRST)->bar('FIRST');
		$this->assets->bar('In');
		$this->assets->bar('Order');

		$this->assets->changeFormatter('bar', function ($asArray) {
			return '[' . trim(strtoupper(implode(' ', $asArray))) . ']';
		});

		$this->assets->charset('utf-8');
		$this->assets->charset('utf-9');
		$this->assets->charset('utf-10');

		$this->assets->changeFormatter('charset', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : 'utf-8';

			return '<meta charset="' . $value . '">';
		});

		$this->assets->description('');

		$this->assets->changeFormatter('description', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : '';

			return '<meta name="description" content="' . $value . '">';
		});

		$this->assets->add('og', ['title' => 'a', 'type' => 'b', 'url' => 'c', 'image' => 'd']);

		$this->assets->changeFormatter('og', function ($asArray) {
			$values = (count($asArray)) ? end($asArray) : [];

			$html = '';

			foreach ($values as $name => $content) {
				$html .= '<meta property="og:' . $name . '" content="' . $content . '">';
			}

			return $html;
		});


		$this->assets->changeFormatter('manifest', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : 'site.webmanifest';

			return '<link rel="manifest" href="' . $value . '">';
		});


		$this->assets->manifest('site.webmanifest');

		$this->assets->changeFormatter('manifest', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : 'site.webmanifest';

			return '<link rel="manifest" href="' . $value . '">';
		});

		$this->assets->touch('icon.png');

		$this->assets->changeFormatter('touch', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : 'touch.png';

			return '<link rel="apple-touch-icon" href="' . $value . '">';
		});

		$this->assets->themecolor('#fafafa');

		$this->assets->changeFormatter('themecolor', function ($asArray) {
			$value = (count($asArray)) ? end($asArray) : '#fffffff';

			return '<meta name="theme-color" content="' . $value . '">';
		});

		$this->assets->Bodyclass('another public old');

		$this->assets->Bodyclass('public old admin');

		//var_dump('DEBUG', $this->assets->debug());

		$vars = $this->assets->variables();

		var_dump($vars);

		foreach ($vars as $var) {
			var_dump('VAR IS: ' . $var, \htmlentities($this->assets->get($var)));
		}

		echo 'end' . EOL;
	}
} /* end class */
