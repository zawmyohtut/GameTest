<?php 

	class Category extends AppModel
	{
		public $hasMany = 'Game';
		//public $displayField = "length_type";  to display this specific column from the database while using find('list') query


		//public $validate = array(

		//	'name' => 'notEmpty',
		//	'length_type' => 'notEmpty'
		//	);


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
		
			
	}

?>


					