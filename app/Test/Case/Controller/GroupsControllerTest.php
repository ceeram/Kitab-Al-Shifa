<?php
/* Groups Test cases generated on: 2011-12-14 16:06:25 : 1323896785*/
App::uses('GroupsController', 'Controller');

/**
 * TestGroupsController *
 */
class TestGroupsController extends GroupsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * GroupsController Test Case
 *
 */
class GroupsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.group', 'app.usergroup', 'app.user', 'app.profile', 'app.shifts', 'app.user_usergroup_map');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Groups = new TestGroupsController();
		$this->Groups->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Groups);

		parent::tearDown();
	}

}
