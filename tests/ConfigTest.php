<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
	private $config = null;
	private $tempFolder = '';

	public function setUp(): void
	{
		define('__ROOT__', dirname(__DIR__));

		FS::setRoot(__ROOT__, true);

		$this->tempFolder = __ROOT__ . '/' . $_ENV['TEMP_FOLDER'] . '/unittest';

		mkdir($this->tempFolder, 0777);

		file_put_contents($this->tempFolder . '/ut_config.php', '<?php return ["name"=>"Johnny Unit"];');

		$this->config = new \projectorangebox\config\ConfigFile(['folder' => $_ENV['TEMP_FOLDER']]);
	}

	public function tearDown(): void
	{
		unlink($this->tempFolder . '/ut_config.php');
	}

	public function testCreate(): void
	{
		$this->assertInstanceOf(\projectorangebox\config\ConfigInterface::class, $this->config);
	}

	public function testGet(): void
	{
		$this->assertEquals('Johnny Unit', $this->config->get('ut_config.name'));
	}

	public function testReplace(): void
	{
		$this->assertInstanceOf(\projectorangebox\config\ConfigInterface::class, $this->config->set('ut_config.name', 'Johnny Appleseed'));

		$this->assertEquals('Johnny Appleseed', $this->config->get('ut_config.name'));
	}

	public function testSet(): void
	{
		$this->assertInstanceOf(\projectorangebox\config\ConfigInterface::class, $this->config->set('new.name', 'Johnny Appleseed'));

		$this->assertEquals('Johnny Appleseed', $this->config->get('new.name'));
	}

	public function testCollect(): void
	{
		$this->assertEquals(['config' => ['folder' => '/var/tmp']], $this->config->collect());
	}

	public function testSetNotation(): void
	{
		$this->assertInstanceOf(\projectorangebox\config\ConfigInterface::class, $this->config->set('new.person.age', 23));

		$this->assertEquals(23, $this->config->get('new.person.age'));
	}

	public function testGetDefault(): void
	{
		$this->assertEquals('default value', $this->config->get('foo.bar', 'default value'));
	}
} /* end class */
