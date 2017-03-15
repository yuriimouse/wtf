<?php

namespace Wtf\Helper;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-27 at 10:09:58.
 */
class CommonTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Common
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	/**
	 * @covers Wtf\Helper\Common::parsePhp
	 */
	public function testParsePhp() {
		$phpret = <<<EOT
<?php
	echo 'trash';
	return 'some text';

EOT;

		$phpstr = <<<EOT
<?php
	echo 'trash';
	'some text';

EOT;

		$phparr = <<<EOT
<?php
	echo 'trash';
	return ['some text'];

EOT;

		$phperr = <<<EOT
<?php
	echo 'trash';
	return ['some text';
EOT;

		$this->expectOutputString('');
		$this->assertEquals('some text', Common::parsePhp($phpret));
		$this->assertEmpty(Common::parsePhp($phpstr));
		$this->assertEquals(['some text'], Common::parsePhp($phparr));

		$this->expectException(\ErrorException::class);
		$this->expectExceptionMessage('Parse error');
		$this->assertEmpty(Common::parsePhp($phperr));
	}

	/**
	 * @covers Wtf\Helper\Common::camelCase
	 */
	public function testCamelCase() {

		$this->assertEquals('SomeSnakedString', Common::camelCase('some_snaked_string'));
		$this->assertEquals('someSnakedString', Common::camelCase('some_snaked_string', false));
	}

	/**
	 * @covers Wtf\Helper\Common::snakeCase
	 */
	public function testSnakeCase() {

		$this->assertEquals('some_camel_cased_string', Common::snakeCase('someCamelCasedString'));
		$this->assertEquals('some_camel_cased_string', Common::snakeCase('SomeCamelCasedString'));
	}

	/**
	 * @covers Wtf\Helper\Common::plural
	 */
	public function testPlural() {

		$this->assertEquals('leaves', Common::plural('leaf'));
		$this->assertEquals('processes', Common::plural('process'));
		$this->assertEquals('bodies', Common::plural('bodies'));
		$this->assertEquals('nuses', Common::plural('nus'));
		$this->assertEquals('boxes', Common::plural('box'));
		$this->assertEquals('entities', Common::plural('entity'));
		$this->assertEquals('clezes', Common::plural('clez'));
		$this->assertEquals('bars', Common::plural('bar'));
		$this->assertEquals('foos', Common::plural('foo'));
	}

	/**
	 * @covers Wtf\Helper\Common::normalizePath
	 */
	public function testNormalizePath() {

		$this->assertEquals('foo', Common::normalizePath('foo'));
		$this->assertEquals('foo/bar', Common::normalizePath('/foo/./bar'));
		$this->assertEquals('this/a/test/is', Common::normalizePath('this/is/../a/./test/.///is'));
		$this->assertEquals('foo/bar', Common::normalizePath('/./foo/./bar/./'));
	}

	/**
	 * @covers Wtf\Helper\Common::absolutePath
	 */
	public function testAbsolutePath() {

		$this->assertEquals(str_replace('\\', '/', realpath('')) . '/foo', Common::absolutePath('foo'));
		$this->assertEquals(str_replace('\\', '/', realpath('/')) . 'foo', Common::absolutePath('foo', '/'));
		$this->assertEquals(str_replace('\\', '/', realpath('/')) . 'foo', Common::absolutePath('/foo', '/bar'));
		$this->assertEquals(str_replace('\\', '/', realpath('/')) . 'bar', Common::absolutePath('foo/../bar', '/'));
		$this->assertEquals(str_replace('\\', '/', realpath('.')) . '/foo', Common::absolutePath(realpath('.') . '/foo', '/'));
	}

	/**
	 * @covers Wtf\Helper\Common::includePhp
	 */
	public function testIncludePhp() {
		$phpconst = <<<EOT
some text here
EOT;
		$phpstr = <<<EOT
<?php
	echo 'some text';

EOT;

		$phparr = <<<'EOT'
<?php
	echo $a;
	echo $b;
EOT;

		$phpobj = <<<'EOT'
class=<?=get_class($this)?>
EOT;

		$phperr = <<<EOT
<?php
	return ['some text';
EOT;

		$this->expectOutputString('');
		$this->assertEquals('some text here', Common::includePhp($phpconst));
		$this->assertEquals('some text', Common::includePhp($phpstr));
		$this->assertEquals('sometext', Common::includePhp($phparr, ['a' => 'some', 'b' => 'text']));
		$this->assertEquals('class=stdClass', Common::includePhp($phpobj, ['a' => 'some', 'b' => 'text'], new \stdClass));

		$this->expectException(\ErrorException::class);
		$this->expectExceptionMessage('Parse error');
		$this->assertEmpty(Common::includePhp($phperr, ['a' => 'some', 'b' => 'text'], new \stdClass));
	}

	/**
	 * @covers Wtf\Helper\Common::normalizePath
	 */
	public function testReturnBytes() {

		$this->assertEquals(1024, Common::returnBytes('1K'));
		$this->assertEquals(2 * 1024 * 1024, Common::returnBytes('2M'));
		$this->assertEquals(5.5 * 1024 * 1024, Common::returnBytes('5.5M'));
		$this->assertEquals(42, Common::returnBytes('42l'));
		$this->assertEquals(0, Common::returnBytes('some42'));
		$this->assertEquals(4.222 * 1024 * 1024 * 1024, Common::returnBytes('4.222G'));
	}

}
