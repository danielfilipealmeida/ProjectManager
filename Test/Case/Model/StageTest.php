<?php
App::uses('Stage', 'Model');

/**
 * Stage Test Case
 *
 */
class StageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.stage'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Stage = ClassRegistry::init('Stage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Stage);

		parent::tearDown();
	}

}
