<?php 

	App::uses('Category','Model');

	class CategoryTest extends CakeTestCase
	{
		public $fixtures = array('app.category','app.gameforcategory');

		public function setup(){

			parent::setup();
			$this->Category = ClassRegistry::init('Category');
		}

		//public function testTotalGamesCount(){	

			//$this->assertEquals($this->Category->totalCountCategories(),6,"Category count test failed!");		
		//}
	
		public function testCountCategories(){

			$this->assertEquals($this->Category->countCategories(),6,"Category count test failed!");			
		}

		public function testGameExist(){

			$flag;

			if($this->Category->totalGamesCount > 0)
				$flag = true;
			else 
				$flag = false;

			$this->assertEquals($flag,true,"Total games count not passed passed!");		
		}
	}


?>