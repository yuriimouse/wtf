<?php

namespace Wtf\Helper;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-27 at 10:09:58.
 */
class HtmlTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Html
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
	 * @covers Wtf\Helper\Html::show
	 * @todo   Implement testShow().
	 */
	public function testShow() {
		$scalars = [
			'first' => 'one',
			'second' => 'two',
			'third' => 'three',
		];

		$this->assertEquals([
			'first' => '!one+first',
			'second' => '!two+second',
			'third' => '!three+third',
			], Html::show($scalars, '!%2$s+%1$s')
		);

		$complex = $scalars;
		$complex['array'] = [
			'sub1',
			'sub2',
			'sub3',
		];

		$this->assertEquals([
			'first' => '!one+first',
			'second' => '!two+second',
			'third' => '!three+third',
			'array' => '#array[!sub1+0,!sub2+1,!sub3+2]'
			], Html::show($complex, ['!%2$s+%1$s', '#%1$s[%2$s]', ','])
		);

		$this->assertEquals([
			'first' => '!one+first',
			'second' => '!two+second***',
			'third' => '!three+third',
			'array' => '#array[!sub1+0,!sub2+1*_*,!sub3+2]'
			], Html::show($complex, ['!%2$s+%1$s%3$s', '#%1$s[%2$s]', ','], ['second' => '***', 'array' => [1 => '*_*']])
		);
	}

	/**
	 * @covers Wtf\Helper\Html::showAttrs
	 * @todo   Implement testShowAttrs().
	 */
	public function testShowAttrs() {
		$attrs = [
			'first' => 'one',
			'second' => 'two',
			'third' => 'three',
		];

		$this->assertEquals([
			'first="one"',
			'second="two"',
			'third="three"',
			], Html::showAttrs($attrs)
		);
	}

	/**
	 * @covers Wtf\Helper\Html::showOptions
	 * @todo   Implement testShowOptions().
	 */
	public function testShowOptions() {
		$opts = [
			'first' => 'one',
			'second' => 'two',
			'third' => 'three',
		];

		$this->assertEquals([
			'<option value="first">one</option>',
			'<option value="second">two</option>',
			'<option value="third">three</option>',
			], Html::showOptions($opts)
		);

		$groups = [
			'drinks' => [
				'JD' => 'Jack Deniels',
				'JW' => 'Johnie Walker',
				'JB' => 'Jim Beam',
			],
			'softdrinks' => [
				'CC' => 'Coca-Cola',
				'Sp' => 'Sprite',
				'Cw' => 'Clean water',
			],
			'juices' => [
				'Or' => 'Orange',
				'Ap' => 'Apple',
				'To' => 'Tomato',
			],
		];

		$this->assertEquals([
			'<optgroup label="drinks"><option value="JD">Jack Deniels</option><option value="JW">Johnie Walker</option><option value="JB">Jim Beam</option></optgroup>',
			'<optgroup label="softdrinks"><option value="CC">Coca-Cola</option><option value="Sp">Sprite</option><option value="Cw">Clean water</option></optgroup>',
			'<optgroup label="juices"><option value="Or">Orange</option><option value="Ap">Apple</option><option value="To">Tomato</option></optgroup>',
			], Html::showOptions($groups)
		);

		$this->assertEquals([
			'<option value="first">one</option>',
			'<option value="second" selected="selected">two</option>',
			'<option value="third">three</option>',
			], Html::showOptions($opts, 'second')
		);

		$this->assertEquals([
			'<optgroup label="drinks"><option value="JD">Jack Deniels</option><option value="JW" selected="selected">Johnie Walker</option><option value="JB">Jim Beam</option></optgroup>',
			'<optgroup label="softdrinks"><option value="CC">Coca-Cola</option><option value="Sp">Sprite</option><option value="Cw">Clean water</option></optgroup>',
			'<optgroup label="juices"><option value="Or">Orange</option><option value="Ap">Apple</option><option value="To">Tomato</option></optgroup>',
			], Html::showOptions($groups, 'JW')
		);
	}

	/**
	 * @covers Wtf\Helper\Html::showInput
	 * @todo   Implement testShowInput().
	 */
	public function testShowInput() {
		$this->assertEquals([
			'<input type="text" name="text[]"',
			'value="" />'
			], Html::showInput());

		$this->assertEquals([
			'<input type="checkbox" name="checkbox[]"',
			'value="1" />'
			], Html::showInput(null, null, null, true));

		$this->assertEquals([
			'<input type="type" name="name"',
			'value="value" />'
			], Html::showInput(null, 'type', 'name', 'value'));

		$this->assertEquals([
			'<label>Label Text',
			'<input type="text" name="text[]"',
			'value="" />',
			'</label>',
			], Html::showInput([
				'label' => 'Label Text',
		]));

		$this->assertEquals([
			'<div class="class">',
			'<input type="text" name="text[]"',
			'value="" />',
			'</div>',
			], Html::showInput([
				'div' => ['class' => 'class'],
		]));

		$this->assertEquals([
			'<div class="class">',
			'<label>Label Text',
			'<input type="text" name="text[]"',
			'value="" />',
			'</label>',
			'</div>',
			], Html::showInput([
				'label' => 'Label Text',
				'div' => ['class' => 'class'],
		]));

		$this->assertEquals([
			'<select name="select[]" >',
			'<option value="0">zero</option>' . PHP_EOL
			. '<option value="1" selected="selected">one</option>' . PHP_EOL
			. '<option value="2">two</option>',
			'</select>',
			], Html::showInput([
				'value' => ['zero', 'one', 'two'],
				'selected' => '1',
				], 'select'));

		$this->assertEquals([
			'<textarea name="area" >',
			'text 1' . PHP_EOL
			. 'text 2' . PHP_EOL
			. 'text 3',
			'</textarea>',
			], Html::showInput([
				'value' => ['text 1', 'text 2', 'text 3'],
				], 'textarea', 'area'));

		$this->assertEquals([
			'<button name="button" >',
			'<img src="http_link" />',
			'</button>',
			], Html::showInput([
				'value' => 'http_link',
				], 'image', 'button'));

		$this->assertEquals([
			'<input type="password" name="unnamed"',
			'value="&quot;&amp;+\" />'
			], Html::showInput(null, 'password', 'unnamed', '"&+\\'));

		$this->assertEquals([
			'<input type="text" name="holder"',
			'placeholder="placeholder text" id="uniqId"',
			'value="" />'
			], Html::showInput([
				'name' => 'holder',
				'placeholder' => 'placeholder text',
				'id' => 'uniqId',
		]));
	}

	/**
	 * @covers Wtf\Helper\Html::showTree
	 * @todo   Implement testShowTree().
	 */
	public function testShowTree() {
		$tree = [
			'first',
			'second',
			[
				'complex1',
				'complex2',
				[
					'subcomplex1',
					'subcomplex2',
				]
			],
			'last',
		];

		$this->assertEquals([
			'<ul>',
			'<li>first</li>',
			'<li>second</li>',
			'<li><ul>' . PHP_EOL
			. '<li>complex1</li>' . PHP_EOL
			. '<li>complex2</li>' . PHP_EOL
			. '<li><ul>' . PHP_EOL
			. '<li>subcomplex1</li>' . PHP_EOL
			. '<li>subcomplex2</li>' . PHP_EOL
			. '</ul></li>' . PHP_EOL
			. '</ul></li>',
			'<li>last</li>',
			'</ul>',
			], Html::showTree($tree));
	}

	/**
	 * @covers Wtf\Helper\Html::showMenu
	 * @todo   Implement testShowMenu().
	 */
	public function testShowMenu() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

}