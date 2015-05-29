<?php 
	
	App::uses('User','Model');
	App::uses('Controller','Controller');


	class UsersControllerTest extends ControllerTestCase
	{
		public $fixtures = array('app.user');

		public function setup(){

			parent::setup();
			$this->User = ClassRegistry::init('User');

		}

		public function testLogin(){

			   $this->Users = $this->generate( 'Users', array());

				$data = array();
		        $data['User']['username'] = 'unittest';
		        $data['User']['password'] = 'unittestpassword';

		        //test login action
		        $result = $this->testAction( "/users/login", array(
		                "method" => "post",
		                "return" => "contents",
		                "data" => $data
		            )
		        );

		       // debug($result);		        

		        $foo[] = $this->view;
		        $this->assertNotNull( $this->headers['Location'] );
		        $this->assertContains( 'users', $this->headers['Location'] );
		        $this->assertNotContains( '"/users/login" id="UserLoginForm"', $foo );

		        //logout mocked user
		        $this->Users->Auth->logout();
		        debug($this->headers['Location']);
		}
/*
			//test correct data display in view
	 	public function testPassDataToIndexView(){

			$result = $this->testAction('users/index',array('return' => 'vars'));
			debug($result);
		}

		public function testIndexRenderedHtml(){

			$result = $this->testAction('users/index',array('return' => 'contents'));
			debug($result);			
		}


		public function testAddUser(){

			$Users = $this->generate('Users', array(
        		 'components' => array(
           		 'Session',
           		 'Email' => array('send')
     		   )
    		));    		

	    	$Users->Session->expects($this->once())
	        ->method('setFlash');
	  		
	  	   $Users->Email
	        ->expects($this->once())
	        ->method('send')
	        ->will($this->returnValue(true));        
			$data = array(
				
				'User' => array(
					'id' => '1',
					'last_name' => 'controllerTest',
					'first_name' => 'controllerTest',
					'username' => 'controllerTest',
					'password' => 'controllerTest',
					'email' => 'controllerTest',
		        	'modified' => '2015-05-17',
		        	'created' => '2015-05-17'
			));

			$result = $this->testAction('users/add',array('data' => $data,'method' => 'get'));
			debug($result);	
		} 
*/	



	}

?>
