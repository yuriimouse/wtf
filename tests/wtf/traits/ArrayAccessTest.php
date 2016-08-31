<?php

namespace Wtf\Traits;

class MockArrayAccess implements \ArrayAccess, \IteratorAggregate {
	use ArrayAccess;
	
}

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-27 at 10:15:56.
 */
class ArrayAccessTest extends \PHPUnit_Framework_TestCase {

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
	 * @covers Wtf\Traits\ArrayAccess::offsetSet
	 * @covers Wtf\Traits\ArrayAccess::getIterator
	 * @covers Wtf\Traits\ArrayAccess::offsetGet
	 * @covers Wtf\Traits\ArrayAccess::offsetExists
	 * @covers Wtf\Traits\ArrayAccess::offsetUnset
	 */
	public function testMock() {
		$mock = new MockArrayAccess();

		$mock['one'] = 'first';
		$mock['two'] = 'second';
		$mock[0] = 'zero';
		$mock[] = 'pushed';

		$this->assertEquals([
			'one' => 'first',
			'two' => 'second',
			0 => 'zero',
			1 => 'pushed',
			], (array) $mock->getIterator());
		
		$this->assertTrue(isset($mock['one']));
		$this->assertFalse(isset($mock['three']));
		
		$this->assertTrue(isset($mock['two']));
		unset($mock['two']);
		$this->assertFalse(isset($mock['two']));
		
		$this->assertEquals('zero',$mock[0]);
	}
}
