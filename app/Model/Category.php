<?php 

	class Category extends AppModel
	{
		public $hasMany = 'Game';
		//public $displayField = "length_type";  to display this specific column from the database while using find('list') query

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


		public function countCategories(){
			$total = $this->find('all');
			return count($total);
		}

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


					