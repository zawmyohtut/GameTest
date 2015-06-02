<?php 

/**
* Application model for application.
* 
* Game model is related to games table in the database due to the naming convention.
* Games data used in this application is mananged and manipulated through this model.
*
*/

	class Game extends AppModel 
	{
		//$belongsTo keyword is used to link game model to category model.
		// Now game model also hold data from category table it is related to.		
		public $belongsTo = 'Category';				

		
		//validation made for the input of the games add page.
		public $validate = array(

				'category_id' => array(

					'isValid' => array(
						'rule' => 'numeric',
						'message' => 'invalid category id.'								
					)	
				),

				'title' => array(

					'isUnique' => array(

						'rule' => 'isUnique',
						'message'=> 'Title name is already taken!'						
					),

					'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Title cannot be empty!'						
					)
				),

				'year' => array(

					'isEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Year cannot be empty!'								
					),

					'isNumber' => array(
						'rule' => 'numeric',
						'message' => 'Numbers only!'								
					)						
				),

				'developer' => array(

					'isEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Developer name cannot be empty!'								
					)	
				)
			);

			//Method to unit test
			public function countSportCategory(){

				$allGames = $this->find('all');
				$sportCount = 0;

				foreach($allGames as $game):				
					if($game['Category']['id'] == '2')
						$sportCount++;
				endforeach;

				return $sportCount;
			}
	}

?>