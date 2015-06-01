<?php 

	class User extends AppModel
	{		
		public function beforeSave($options = array()){

			$this->data['User']['unhashed_password'] = $this->data['User']['password'];
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
					),
				'min' => array(  

						'rule' => array('minLength',6),
						'message' => 'Password must be at least 6 characters!'
					)

			),

			'confirm_password' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Confirm Password cannot be empty!'						
					),
				'min' => array(  

						'rule' => array('minLength',6),
						'message' => 'Confirm Password must be at least 6 characters!'
					),

				'match' => array(

						'rule' => 'validatePasswordConfirm',
						'message' => 'Passwords do not match!'
					)

			),

			'email' => array(

				'isEmpty' => array(

						'rule' => 'notEmpty',
						'message' => 'Email cannot be empty!'						
					)

			)

		);
		
		public function validatePasswordConfirm(){

			if($this->data['User']['password'] != $this->data['User']['confirm_password'])
				return false;

			return true;

		}

	}

?>