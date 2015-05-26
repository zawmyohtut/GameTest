<?php 

	define('FACEBOOK_SDK_V4_SRC_DIR','../Vendor/fb/src/Facebook/');
	require_once("../Vendor/fb/autoload.php");
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;

	class UsersController extends AppController
	{				
		public function beforeFilter(){

			parent::beforeFilter();
			$this->Auth->allow('add');
		}

		//make OAuth login redirectquest to facebook.
		public function fblogin(){
			
			$this->autoRender = false;	
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
			$helper = new FacebookRedirectLoginHelper(FACEBOOK_REDIRECT_URI);
			$url = $helper->getLoginUrl(array('email'));
			$this->redirect($url);

		}

		//handle fb OAuth login response from facebook
		public function fb_login(){

			$this->layout = 'ajax';
			FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
			$helper = new FacebookRedirectLoginHelper(FACEBOOK_REDIRECT_URI);
			$session = $helper->getSessionFromRedirect();

			if(isset($_SESSION['token'])){
				$session = new FacebookSession($_SESSION['token']);
				try{
					$session->validate(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
				}catch(FacebookAuthorizationException $e){
				//	echo $e->getMessage();
					$this->Session->setFlash($e->getMessage());
					$this->redirect(BASE_PATH.'login');
				}
			}

			$data = array();
			$fb_data = array();

			if(isset($session)){
				$_SESSION['token'] = $session->getToken();
				$request = new FacebookRequest($session, 'GET', '/me');
				$response = $request->execute();
				$graph = $response->getGraphObject(GraphUser::className());

				$fb_data = $graph->asArray();
				$id = $graph->getId();
				$image = "https://graph.facebook.com/".$id."/picture?width=100";

				if( !empty( $fb_data )){
					$result = $this->User->findByEmail( $fb_data['email'] );
					if(!empty( $result )){
						if($this->Auth->login($result['User'])){

							$this->Session->setFlash('You have previously signed in with the facebook account!.Now redirecting to the home page!.');
							$this->redirect(BASE_PATH);

						}else{

							$this->Session->setFlash('Failed to sign in using facebook account!');
							$this->redirect(BASE_PATH.'login');

						}

					}else{
						
						$data['email'] = $fb_data['email'];
						$data['first_name'] = $fb_data['first_name'];
						$data['social_id'] = $fb_data['id'];
						$data['picture'] = $image;
						$data['uuid'] = String::uuid ();
						$this->User->save( $data );
						if($this->User->save( $data )){
							$data['id'] = $this->User->getLastInsertID();
							if($this->Auth->login($data)){
								$this->Session->setFlash('You have successfully signed in using your facebook account!');								
								$this->redirect(BASE_PATH);
							}else{
								$this->Session->setFlash('Failed to sign in using facebook account!');
								$this->redirect(BASE_PATH.'index');
							}

						}else{
							$this->Session->setFlash('Failed to sign in using facebook account!');
							$this->redirect(BASE_PATH.'index');
						}
					}

				}else{
					$this->Session->setFlash('Failed to sign in using facebook account!');
					$this->redirect(BASE_PATH.'index');
				}
			}
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
					
					// send email to registered email.Uses gmail ssl.
					$Email = new CakeEmail('gmail');
					$Email->from(array('zaw@intersetive.com' => 'Game Test'));
					$Email->to($this->request->data['User']['email']);
					$Email->subject('Thanks for Registering!');
					$Email->send('Start managing your games right away!');
					$this->Session->setFlash("User Registration successful");
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