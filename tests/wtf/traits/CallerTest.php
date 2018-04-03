<?php

namespace Wtf\Traits;

class CallerMock implements \Wtf\Interfaces\Caller {

	use Caller;
}

class Caller_ArrayMock implements \Wtf\Interfaces\Caller, \ArrayAccess {

	use Caller;

	private $_array = [];

	public function offsetExists($offset) {
		return isset($this->_array[$offset]);
	}

	public function offsetGet($offset) {
		return isset($this->_array[$offset]) ? $this->_array[$offset] : null;
	}

	public function offsetSet($offset, $value) {
		$this->_array[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->_array[$offset]);
	}

}

class Caller_InvokableMock implements \Wtf\Interfaces\Invokable {

	use Invokable;
}

class Caller_SingletonMock implements \Wtf\Interfaces\Caller, \Wtf\Interfaces\Singleton {

	use Caller,
	 Singleton;
}

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-10 at 11:06:25.
 */
class CallerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Caller
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
	 * @covers Wtf\Traits\Caller::__call
	 */
	public function test__callArray() {
		$obj = new Caller_ArrayMock();

		$obj['foo'] = 'bar';
		$this->assertEquals('bar', $obj->foo());
	}

	/**
	 * @covers Wtf\Traits\Caller::__call
	 */
	public function test__callGetter() {
		$obj = new CallerMock();

		$obj->foo = 'bar';
		$this->assertEquals('bar', $obj->foo());
	}

	/**
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Method 'Wtf\Traits\CallerMock::foo' not available
	 */
	public function test__callError() {
		$obj = new CallerMock();

		$obj->foo();
	}

	/**
	 * @covers Wtf\Traits\Caller::__call
	 */
	public function test__callArgs() {
		$caller = new CallerMock();
		$caller->foo = 'bar';

		$invoke = new Caller_InvokableMock();
		$invoke->baz = 'qwe';

		$object = new CallerMock();
		$object->caller = $caller;
		$object->invoker = $invoke;
		$object->thescalar = 'quuz';

		$this->assertEquals('bar', $object->caller('foo'));
		$this->assertEquals('qwe', $object->invoker('baz'));
		$this->assertEquals('quuz', $object->thescalar());

		return $object;
	}

	/**
	 * @depends test__callArgs
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Wrong arguments list
	 */
	public function test__callArgsError1($object) {
		$this->assertInstanceOf(\Wtf\Interfaces\Caller::class, $object);
		$this->assertEquals('bar', $object->caller('foo', 'bar'));
	}

	/**
	 * @depends test__callArgs
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Method 'Wtf\Traits\CallerMock::baz' not available
	 */
	public function test__callArgsError2($object) {
		$this->assertInstanceOf(\Wtf\Interfaces\Caller::class, $object);
		$this->assertEquals('qwe', $object->caller('baz', 'bar'));
	}

	/**
	 * @depends test__callArgs
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Method 'Wtf\Traits\Caller_InvokableMock::bar' not available
	 */
	public function test__callArgsError3($object) {
		$this->assertInstanceOf(\Wtf\Interfaces\Caller::class, $object);
		$this->assertEquals('qwe', $object->invoker('baz', 'bar'));
	}

	/**
	 * @depends test__callArgs
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Method 'Wtf\Traits\Caller_InvokableMock::bar' not available
	 */
	public function test__callArgsError4($object) {
		$this->assertInstanceOf(\Wtf\Interfaces\Caller::class, $object);
		$this->assertEquals('qwe', $object->invoker('bar', 'baz'));
	}

	/**
	 * @depends test__callArgs
	 * @covers Wtf\Traits\Caller::__call
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Wrong arguments list
	 */
	public function test__callArgsError5($object) {
		$this->assertInstanceOf(\Wtf\Interfaces\Caller::class, $object);
		$this->assertEquals('quuz', $object->thescalar('foo'));
	}

	/**
	 * @covers Wtf\Traits\Caller::__callStatic
	 */
	public function test__callStaticOk() {
		$obj = Caller_SingletonMock::singleton();
		$obj->foo = 'bar';

		$this->assertEquals('bar', Caller_SingletonMock::foo());
	}

	/**
	 * @covers Wtf\Traits\Caller::__callStatic
	 * @expectedException ErrorException
	 * @expectedExceptionMessage Object 'Wtf\Traits\CallerMock' must implements the 'Singleton' pattern
	 */
	public function test__callStaticErr() {
		CallerMock::call();
	}

}