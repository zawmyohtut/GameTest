<?php 

	class UsersController extends AppController
	{				
		public function beforeFilter(){

			parent::beforeFilter();
			$this->Auth->allow('add');
		}

		public function login(){
			
			if(AuthComponent::user()){
				
				$this->redirect(array('controller'=>'games','action'=>'index'));
			}

			if($this->request->is('post')){
							
				if($this->Auth->login()){


				    $this->redirect($this->Auth->redirectUrl());
				}
				else{

					$this->Session->setFlash(__('Incorrect username or password!'));										
					$this->redirect('login');
				}				
			}
		}

		public function logout(){

			$this->Auth->logout();
			$this->Session->setFlash(__('You have been logged out!'));										
			$this->redirect('login');
		}	

		public function index(){

			$data = $this->User->find('all');
			$count = $this->User->find('count');

			$gameInformation = array(

					'users'=> $data,
					'count'=> $count
				);

			$this->set($gameInformation);

		}

		public function view($id = null){

			if(!isset($id)){

				$this->Session->setFlash(__('Please specify User ID to view!. Now returning to User Home page!'));
				$this->redirect('index');									
			}

			$data = $this->User->findById($id);

			if(!$data){

				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to User Home page!'));
				$this->redirect('index');						
			}			

			$this->set('user',$data);
		}


		//User Registering
		public function add(){

			$this->set('title_for_layout','Add new user');

			if($this->request->is('post')){

				$this->User->create();
				
				if($this->User->save($this->request->data)){
				/*	
					$userEmail = $this->request->data['User']['email'];
					$this->Email->to = $userEmail;
					$this->Email->subject = "Registering Testing";
					$this->Email->from = "zawmyohtut@gmail.com";
					$this->Email->smtpOptions = array(
							'port' => '465',
							'timeout' => '30',
							'host' => 'ssl://smtp.gmail.com',
							'username' => 'zawmyohtut@gmail',
							'password' => 'whyalwaysme12345',
					);

					$this->Email->delivery = 'smtp';
					if($this->Email->send()){
						return true;
					}
					else{
						echo $this->Email->smtpError;
					}
					*/
					$this->redirect('index');	
				}
				else{

						$this->Session->setFlash(__('Saving new user failed!'));
				} 
			}			
		}

		public function edit($id = null){

			$this->set('title_for_layout','Edit existing game');
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify User ID to edit!. Now returning to User Home page!'));
				$this->redirect('index');					
			}			

			$data = $this->User->findById($id);

			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to User Home page!'));
				$this->redirect('index');
			}
							
			if($this->request->is('post') || $this->request->is('put')){

				if($this->User->save($this->request->data))
				{
					$this->redirect('index');	
				}									
				
			}else{

				$this->request->data = $data;					
			}		
			
		}

		public function delete($id = null){

			if(!isset($id)){

				throw new NotFoundException(__('ID is not set.'));
			}
			
			if($this->User->exists($id)){

				$this->User->delete($id);
				$this->Session->setFlash(__('User was successfuly deleted!'));
				$this->redirect('index');
			}
			else{

				$this->Session->setFlash(__('User was not found in database to delete.'));
				$this->redirect('index');
			}			

		}

		public function search($search = null){

			if(!isset($search)){

				$data = $this->User->find('all');				
			}	
			else{

				$data = $this->User->find('all',array('order'=>'year','conditions' => array('title LIKE' => '%'.$search.'%')
					));
			}

			$count = count($data);
			$userInformation = array(

					'users'=> $data,
					'count'=> $count
				);

			$this->set($userInformation);
			$this->render('index');
		}





	}

?>