<?php

namespace Wtf\Traits;

class FactoryMock {

	use Factory;
}

class ClassMock {
	
}

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-27 at 10:15:56.
 */
class FactoryTest extends \PHPUnit_Framework_TestCase {

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
	 * @covers Wtf\Traits\Factory::factory
	 */
	public function testFactoryUncorrect() {
		$object = FactoryMock::factory(true);
		$this->assertNull($object);
	}

	/**
	 * @covers Wtf\Traits\Factory::factory
	 */
	public function testFactoryContracted() {
		$app = \Wtf\Core\App::singleton();
		$app->contract('name', ClassMock::class);
		$app->contract('object', new ClassMock);
		$app->contract('singleton', \Wtf\Core\App::singleton());
		
		$object = FactoryMock::factory('name');
		$this->assertInstanceOf('\\Wtf\\Traits\\ClassMock', $object);
		$object = FactoryMock::factory('object');
		$this->assertInstanceOf('\\Wtf\\Traits\\ClassMock', $object);
		$object = FactoryMock::factory('singleton');
		$this->assertInstanceOf('\\Wtf\\Core\\App', $object);
	}

	/**
	 * @covers Wtf\Traits\Factory::factory
	 */
	public function testFactoryClassname() {
		$object = FactoryMock::factory(ClassMock::class);
		$this->assertInstanceOf('\\Wtf\\Traits\\ClassMock', $object);
	}

	/**
	 * @covers Wtf\Traits\Factory::factory
	 */
	public function testFactoryObject() {
		$object = FactoryMock::factory(new ClassMock);
		$this->assertInstanceOf('\\Wtf\\Traits\\ClassMock', $object);
	}

}