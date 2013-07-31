<?php
App::uses('Timelog', 'Model');

/**
 * Timelog Test Case
 *
 */
class TimelogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.timelog'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Timelog = ClassRegistry::init('Timelog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Timelog);

		parent::tearDown();
	}

}
