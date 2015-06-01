<?php 

/**
* User Contents Controller
*
*This controller will render views from view/users
*
*The main purpose of this controller is to show the users the list of all 
*the users in the database and will also allow the user view each user 
*on seperate page.Morever, users will be able to delete and edit the users
*and manage them as they wish.This controller will implement cakePHP autht component
*together with Facebook login API.
*/
	 
	/**
	* Importing require classes and packages from Facebook SDk
	* to implement facebook login in the page.
	*/
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

	App::uses('AppController', 'Controller');

	class UsersController extends AppController
	{			
		/**
		* This controller use @User model from model/User.php
		*/

		//Method to allow user to register new users even if not logged in.
		public function beforeFilter(){

			parent::beforeFilter();
			$this->Auth->allow('add');
		}

		//make OAuth login redirect request to facebook.
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

		/**
		*  Display a view 
		*  Show the login page to the user.
		*
		*  @return void
		*/		
		public function login(){
			
			// check if user is already logged in.
			if(AuthComponent::user()){
				
				//if user is logged in, redirect to game's index page.
				$this->redirect(array('controller'=>'games','action'=>'index'));
			}

			// check if login form is submitted.
			if($this->request->is('post')){
					
				//authenticate using username and password from login form.		
				if($this->Auth->login()){

				    $this->redirect($this->Auth->redirectUrl());
				}
				else{

					$this->Session->setFlash(__('Incorrect username or password!'));										
					$this->redirect('login');
				}				
			}
		}	

		/**
		*  Do not display a view.
		*  Method to handle logout request.
		*
		*  @return void
		*/	
		public function logout(){

			$this->Auth->logout();					
			$this->Session->setFlash(__('You have been logged out!'));										
			$this->redirect('login');
		}	

		/**
		*  Display a view 
		*  Show the list of all the Categories to the users.
		*
		*  @return void
		*/
		public function index(){

			$data = $this->User->find('all');
			$count = $this->User->find('count');

			$gameInformation = array(

					'users'=> $data,
					'count'=> $count
				);

			$this->set($gameInformation);
		}

		/**
		*  Display a view 
		*  Show details of each user that user click.
		*
		*  @return void
		*/
		public function view($id = null){

			// check if ID is passed.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify User ID to view!. Now returning to User Home page!'));
				$this->redirect('index');									
			}

			// fetch passed ID's data from DB.
			$data = $this->User->findById($id);

			//if data is not found,error msg.
			if(!$data){

				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to User Home page!'));
				$this->redirect('index');						
			}			

			// pass found data to /view/users/view
			$this->set('user',$data);
		}


		/**
		*  Display a view 
		*  Form for adding new users.
		*
		*  @return void
		*/
		public function add(){

			// set the title for 'add' user page
			$this->set('title_for_layout','Add new user');

			//check if Form is already submitted.
			if($this->request->is('post')){

				$this->User->create();
				
				// save new data to DB via User model
				if($this->User->save($this->request->data)){
					
					// send notification email to registered email.Uses gmail ssl.
					$Email = new CakeEmail('gmail');
					$Email->from(array('zaw@intersetive.com' => 'Game Test'));
					$Email->to($this->request->data['User']['email']);
					$Email->subject('Thanks for Registering!');
					$Email->send('Start managing your games right away!');
					$this->Session->setFlash("User Registration successful");
					return $this->redirect('index');		
				}
				else{

					$this->Session->setFlash(__('Saving new user failed!'));
				} 
			}			
		}

		/**
		*  Display a view 
		*  Form for editing existing users.
		*
		*  @return void
		*/
		public function edit($id = null){

			// set the title for 'edit' user page
			$this->set('title_for_layout','Edit existing Users');

			//check if ID to edit does exist or not.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify User ID to edit!. Now returning to User Home page!'));
				$this->redirect('index');					
			}			

			//fetch data from DB with passed ID
			$data = $this->User->findById($id);

			//check if requested data exist or not.
			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to User Home page!'));
				$this->redirect('index');
			}
							
			if($this->request->is('post') || $this->request->is('put')){

				//update the data in DB using data from edit form(ID is provied in the form but its made hideden)
				if($this->User->save($this->request->data))
				{
					$this->redirect('index');	
				}									
				
			}else{

				$this->request->data = $data;					
			}		
			
		}

		/**
		*  Do not display view. Redirect to index view instead.
		*  Method to delete users.
		*
		*  @return void
		*/
		public function delete($id = null){

			// check if ID exist to search and delete.
			if(!isset($id)){

				throw new NotFoundException(__('ID is not set.'));
			}
			
			//check if ID exist in DB or not.
			if($this->User->exists($id)){

				//if ID exist , delete data with that ID.
				$this->User->delete($id);
				$this->Session->setFlash(__('User was successfuly deleted!'));
				$this->redirect('index');
			}
			else{

				//show msg, data with that ID not found.
				$this->Session->setFlash(__('User was not found in database to delete.'));
				$this->redirect('index');
			}			

		}

		/**
		*  Do not display a view.
		*  Method to handle if the user search via URL.
		*
		*  This method solely for testing. Not for user.
		*  @return void
		*/
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