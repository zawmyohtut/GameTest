<?php 

/**
* Application model for application.
* 
* Category model is related to categories table in the database due to the naming convention.
* Categories data used in this application is mananged and manipulated through this model.
*
*/

	class Category extends AppModel
	{
		//$hasMany keyword is used to link category model to game model.
		// Now Category model also hold data from game table it is related to.		
		public $hasMany = 'Game';
		
		//validation made for the input of the category add page.
		public $validate = array(

				'name' => array(

					'isUnique' => array(

						'rule' => 'isUnique',
						'message'=> 'Category name is already taken!'						
					),

					'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Name cannot be empty!'						
					)
				),

				'length_type' => array(

					'isEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Length cannot be empty!'								
					)	
				)
			);


		// Method create for sole purpose of unit testing.
		public function countCategories(){
			$total = $this->find('all');
			return count($total);
		}

		// Method create for sole purpose of unit testing.
		public function totalGamesCount(){
			
			$gamescount = 0;
			$data = $this->find('all');

			foreach($data as $category){

				$gamescount += count($category['Game']);
			}
			return $gamescount;
		}


		
			
	}

?>


					