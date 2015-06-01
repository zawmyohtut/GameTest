<?php 

	App::uses('User','Model');

	//Test Cast Model for User.php
	class UserTest extends CakeTestCase
	{
		public $fixtures = array('app.user');
		//public $autoFixtures = false;  // not to load the fixture automatically.

		// then can load the fixture using $this->loadFixture('User','Comment');

		public function setup(){

			parent::setup();
			$this->User = ClassRegistry::init('User');

		}

		public function testDoesItExist(){			

			$result = $this->User->doesItExist('username');
			$expected = true;	

			$this->assertEqual($result,$expected,'username provided not exist!');
		}

	}
?>