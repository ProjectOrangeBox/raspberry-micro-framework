<?php

namespace application\controllers;

use FS;
use Exception;
use projectorangebox\assets\Assets;
use projectorangebox\events\Events;
use projectorangebox\log\LoggerTrait;
use projectorangebox\events\EventsTrait;
use projectorangebox\collection\Collection;
use projectorangebox\dispatcher\Controller;
use projectorangebox\dispatcher\DispatcherException;

class main extends Controller
{
	use LoggerTrait;
	use EventsTrait;

	protected $logEnabled = true;
	protected $logCaptureLevel = 255;

	public function index(): string
	{
		$json = FS::file_get_contents('/support/data/data.json');
		$json = str_replace(chr(10), '', $json);
		$data = json_decode($json, JSON_OBJECT_AS_ARRAY);

		return $this->view->data($data)->render('default');
	}

	public function fourohfour(): string
	{
		$this->response->responseCode(404);

		return '404 error';
	}

	public function test1(): string
	{
		$input = 'abkjsdfkljskldfjklsdjf';

		$v = $this->validate->filter($input, 'filter_str[8]');

		var_dump($v);
		echo 'this->validate->filter variable 8 characters' . EOL;

		$input = [
			'a' => 'abkjsdfkljskldfjklsdjf',
			'b' => 'sdfabkjsdfkljskldfjklsdjf',
		];

		$rules = [
			'a' => ['field' => 'a', 'label' => 'A', 'rules' => 'filter_str[8]'],
			'b' => ['field' => 'b', 'label' => 'A', 'rules' => 'filter_str[8]'],
		];

		$v = $this->validate->filter($input, $rules);

		var_dump($v);
		echo 'this->validate->filter array 8 each' . EOL;

		$input = [
			'a' => 'abkjsdfkljskldfjklsdjf',
			'b' => 'sdfabkjsdfkljskldfjklsdjf',
		];

		$rules = [
			'a' => ['field' => 'a', 'label' => 'A', 'rules' => 'max_length[10]'],
			'b' => ['field' => 'b', 'label' => 'A', 'rules' => 'max_length[10]'],
		];

		$v = $this->validate->isValid($input, $rules);

		var_dump($v);
		echo 'this->validate->isValid array false' . EOL;

		$input = 'a';

		$v = $this->validate->isValid($input, 'integer');

		var_dump($v);
		echo 'this->validate->isValid variable false' . EOL;

		$input = 123;

		$v = $this->validate->isValid($input, 'integer');

		var_dump($v);
		echo 'this->validate->isValid variable true' . EOL;

		$rules = [
			'id'   => ['field' => 'id', 'label' => 'Id', 'rules' => 'required|integer|max_length[10]|less_than[4294967295]'],
			'url'  => ['field' => 'url', 'label' => 'URL', 'rules' => 'filter_str[8]|rtrim[/]|strtolower|max_length[8]'],
			'text' => ['field' => 'text', 'label' => 'Text', 'rules' => 'required|max_length[255]|filter_input[255]'],
		];

		$data = [
			'id' => 'abc',
			'url' => 'dklsdjflkdsfjlABC/123/XYZ/catdog',
			'text' => '',
		];

		$v = $this->validate;

		$bool = $v->isValid($data, $rules);

		var_dump($bool);
		echo 'this->validate->isValid false' . EOL;

		var_dump($data);
		echo 'this->validate->isValid cleaned data' . EOL;

		var_dump($v->errors());
		echo 'this->validate->isValid errors' . EOL;

		return 'done';
	}

	public function test2(): string
	{
		echo '<pre>';

		$this->collection->addDefault('Oh Darn!');
		$this->collection->addModel('Not Going to Work!');
		$this->collection->addModel('Not Going to Work 2!');
		$this->collection->addModel('foo bar!');
		$this->collection->addBar('another error');
		$this->collection->addModel('test');

		$x = $this->collection->get();

		var_dump($x);

		return __METHOD__;
	}

	public function test3(): string
	{
		\send::fourohfour('This is the body');

		return '3';
	}

	public function test4(): string
	{
		echo 'start<pre>';

		$this->collection->addLogin('Wrong Password default.');

		$this->collection->addLogin(['Right Password 3 lowest', 'Right Password 3 lowest #2'], Collection::PRIORITY_LOWEST);

		$this->collection->addLogin('Right Password 1 default');

		$this->collection->addLogin('A Password 2 highest', Collection::PRIORITY_HIGHEST);


		$rules = [
			'id'   => ['field' => 'id', 'label' => 'Id', 'rules' => 'required|integer|max_length[10]|less_than[4294967295]'],
			'url'  => ['field' => 'url', 'label' => 'URL', 'rules' => 'filter_str[8]|rtrim[/]|strtolower|max_length[8]'],
			'text' => ['field' => 'text', 'label' => 'Text', 'rules' => 'required|max_length[255]|filter_input[255]'],
		];

		$data = [
			'id' => 'abc',
			'url' => 'dklsdjflkdsfjlABC/123/XYZ/catdog',
			'text' => '',
		];

		$this->request->set('isAjax', true);

		$v = $this->validate;

		$v->isValid($data, $rules);

		$err = $v->errors(true);

		$this->collection->addModel($err)->get();

		$vars = $this->collection->groups();

		foreach ($vars as $var) {
			var_dump('VAR IS: ' . $var, json_encode($this->collection->get($var)));
		}

		//var_dump($this->collection->get('Login,Model'));

		return 'end';
	}

	public function phpinfo(): string
	{
		phpinfo();

		return '';
	}

	public function test5(): string
	{
		echo '<pre>';

		echo 'time ' . time() . PHP_EOL;

		$this->session->flashData->set('name1', 'Johnny Appleseed', 60);
		$this->session->flashData->set('name2', 'Johnny Appleseed', 75);
		$this->session->flashData->set('name3', 'Johnny Appleseed');

		var_dump($this->session->all());

		return 'end';
	}

	public function test6(): string
	{
		echo '<pre>';

		echo 'time ' . time() . PHP_EOL;

		var_dump($this->session->all());
		var_dump($this->session->flashData->all());

		return 'end';
	}

	public function test7(): void
	{
		echo 'start' . EOL . '<pre>';

		$this->assets->jsvariable(['names', 'Johnny Appleseed']);

		$this->assets->script('newfile.js');
		$this->assets->multipleScript(['aaa.js', 'bbb.js', 'ccc.js'], Assets::PRIORITY_LOWEST);

		$this->assets->link('newfile.css');
		$this->assets->multipleLink(['aaa.css', 'bbb.css', 'ccc.css'], Assets::PRIORITY_LOWEST);

		$this->assets->jsvariable(['name', 'Johnny Appleseed']);
		$this->assets->jsvariable(['age', 23]);
		$this->assets->jsvariable(['foo', 'bar']);
		$this->assets->multipleJsVariable([['namef', 'varfff'], ['israw', '{}', true]]);

		$this->assets->metaTag(['name', 'value']);
		$this->assets->metaTag(['foo', 'bar', 'FIRST'], Assets::PRIORITY_FIRST);
		$this->assets->multipleMetaTag([['name', 'true'], ['age', 18, 'content']]);

		$this->assets->foo('ZZZ ', Assets::PRIORITY_LAST);
		$this->assets->foo('AAA ', Assets::PRIORITY_LOWEST);
		$this->assets->foo('BBB ', Assets::PRIORITY_HIGH);
		$this->assets->foo('CCC1 ', Assets::PRIORITY_HIGHEST);
		$this->assets->foo('CCC2 ', Assets::PRIORITY_FIRST);
		$this->assets->foo('DDD ', Assets::PRIORITY_NORMAL);
		$this->assets->foo('CCC3 ', Assets::PRIORITY_FIRST);

		$this->assets->bar('Please ');
		$this->assets->bar('Keep ');
		$this->assets->bar('This ');
		$this->assets->bar('FIRST ', Assets::PRIORITY_FIRST);
		$this->assets->bar('In ');
		$this->assets->bar('Order ');

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

		$this->assets->add('bodyclass', 'another public old');

		$this->assets->multipleBodyclass(['public', 'old', 'admin']);

		$this->assets->changeFormatter('bar', function ($asArray) {
			return '[' . trim(strtoupper(implode(' ', $asArray))) . ']';
		});

		$vars = $this->assets->variables();

		var_dump($vars);

		foreach ($vars as $var) {
			var_dump('VAR IS: ' . $var, \htmlentities($this->assets->get($var)));
		}

		var_dump('DEBUG', $this->assets->debug());

		echo 'end' . EOL;
	}

	public function test8(): void
	{
		echo '<pre>start' . EOL;

		$this->cache->save('/models/people/name', 'value', 60);
		$this->cache->save('/models/people/age', 'value', 60);
		$this->cache->save('/models/people/cats', 'value', 60);
		$this->cache->save('/models/other/foo', 'value', 60);
		$this->cache->save('/models/other/bar', 'value', 60);

		$this->cache->save('name', 'value', 60);

		$this->cache->save('HGHJKNKJ%&^&&(*%^$^%GHJKJUejhfkjsdhfk@*(', 'value', 60);

		var_dump($this->cache->cacheInfo());

		$this->cache->delete('/models/people/*');

		var_dump($this->cache->cacheInfo());

		//$this->cache->clean();

		$this->cachep->save('/models/cars/subaru', '2020 Outback', 60);

		echo $this->cachep->get('/models/cars/subaru') . EOL;

		echo 'end' . EOL;
	}

	public function test9(): void
	{
		$this->redis->save('/models/people/name', 'value', 60);

		echo $this->redis->get('/models/people/name') . EOL;

		var_dump($this->redis->cacheInfo());
	}

	public function test10(): void
	{
		echo '<pre>';

		$aaa = 'aaa';
		$bbb = 'bbb';

		$this->registerEvent('testing', function (&$aaa, &$bbb) {
			$aaa = '111';
			$bbb = '222';
		}, Events::PRIORITY_HIGHEST);

		var_dump($aaa, $bbb);

		$this->triggerEvent('testing', $aaa, $bbb);

		var_dump($aaa, $bbb);
	}

	public function test11(): void
	{
		$e = new \projectorangebox\encryption\Encryption([]);

		//$e->create('/var/tmp');

		$x = $e->encrypt('this is a test');

		echo $x . EOL;

		$y = $e->decrypt($x);

		echo $y . EOL;
	}

	public function test12($a, $b): void
	{
		echo '<p>' . $a . '</p>';
		echo '<p>' . $b . '</p>';
	}

	public function test13(): void
	{
		echo '<pre>';

		$regex = '*';
		$regex = '%^(.*)/controllers/(.*).php$%m';

		foreach (FS::collect(__ROOT__, $regex, ['.git', 'var', 'vendor', '.vscode']) as $file) {
			var_dump($file);
		}
	}
} /* end class */
