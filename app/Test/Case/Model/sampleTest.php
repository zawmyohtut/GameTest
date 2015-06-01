<?php 

    function calcTravelExpense($i,$j){

    	$sum = $i + $j;
    	$sum = 2 * $sum;
    	return $sum;
    }

	class sampleTest extends CakeTestCase
	{

		public function setUp(){

		}

		public function tearDown(){

		}

		function testTravelExpense(){

			$this->assertEqual(4,calcTravelExpense(1,1),'This should be the same');
		}




	}


?>