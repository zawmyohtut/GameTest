<?php 

	class UserFixture extends CakeTestFixture 
	{
		public $useDbConfig = 'test';
		public $import = 'User';	

		public $records = array(

			array(
				'id' => 1,
		        'last_name' => 'test_last_name',
		        'first_name' => 'test_first_name',
		        'username' => 'unittest',
		        'password' => 'unittestpassword',
		        'email' => 'test',
		        'modified' => '2015-05-17',
		        'created' => '2015-05-17'
			),
			array(
				'id' => 2,
		        'last_name' => 'test_last_name2',
		        'first_name' => 'test_first_name2',
		        'username' => 'unittest2',
		        'password' => 'unittestpassword2',
		        'email' => 'test2',
		        'modified' => '2015-05-17',
		        'created' => '2015-05-17'
			)
			 
		); 

	}

?>