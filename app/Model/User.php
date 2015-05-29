<?php 

	class User extends AppModel
	{		
		public function beforeSave($options = array()){

			$this->data['User']['password'] = 
			AuthComponent::password($this->data['User']['password']);
						
			return true;		
		}	

		
		public $validate = array(

			'last_name' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Last name cannot be empty!'						
					),

			),

			'first_name' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'First name cannot be empty!'						
					),

			),

			'username' => array(

					'isUnique' => array(

						'rule' => 'isUnique',
						'message'=> 'Username is already taken!'						
					),

					'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'username cannot be empty!'						
					)
			),

			'password' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Password cannot be empty!'						
					)

			),

			'email' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Email cannot be empty!'						
					)

			)

		);


	}

?>