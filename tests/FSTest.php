<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FSTest extends TestCase
{
  private $tempFolder = '';

  public function setUp(): void
  {
    define('__ROOT__', dirname(__DIR__));

    FS::setRoot(__ROOT__, true);

    $this->tempFolder = __ROOT__ . '/' . $_ENV['TEMP_FOLDER'] . '/unittest';

    mkdir($this->tempFolder, 0777);
  }

  public function tearDown(): void
  {
    foreach (glob($this->tempFolder . '/*') as $file) {
      unlink($file);
    }

    rmdir($this->tempFolder);
  }

  public function testGetRoot(): void
  {
    $this->assertEquals(__ROOT__, FS::getRoot());
  }

  public function testResolve(): void
  {
    $this->assertEquals('/foo/bar', FS::resolve('/foo/bar', true));
    $this->assertEquals(__ROOT__ . '/foo/bar', FS::resolve('/foo/bar', false));
  }

  public function testglob(): void
  {
  }

  public function testglobr(): void
  {
  }
} /* end class */
