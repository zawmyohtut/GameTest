<?php 

	App::uses('Game','Model');

	class GameTest extends CakeTestCase
	{
		public $fixtures = array('app.game','app.category');

		public function setup(){

			parent::setup();
			$this->Game = ClassRegistry::init('Game');
		}
	
		public function testcountSportCategory(){

			$this->assertEquals($this->Game->countSportCategory(),2,"Sport count test failed!");			
		}

	}


?>