<?php 

	class GameFixture extends CakeTestFixture 
	{
		public $useDbConfig = 'test';
		public $import = 'Game';	

		public $records = array(

			array(
				'id' => 1,
		        'title' => 'test_title',
		        'year' => '123',
		        'description' => 'test_description',
		        'developer' => 'test_developer',
		        'category_id' => '2',
		        'modified' => '2015-05-17',
		        'created' => '2015-05-17'
			),
			array(
				'id' => 2,
		        'title' => 'test_title2',
		        'year' => '124',
		        'description' => 'test_description2',
		        'developer' => 'test_developer2',
		        'category_id' => '2',
		        'modified' => '2015-05-17',
		        'created' => '2015-05-17'
			)
			 
		); 

	}

?>