<?php 

/**
* Game Contents Controller
*
*This controller will render views from view/games
*
*The main purpose of this controller is to show the users the list of all 
*the games in the database and will also allow the user view each games 
*on seperate page.Morever, users will be able to delete and edit the games
*and manage them as they wish.
*/

	class GamesController extends AppController
	{				

		/**
		* This controller use @Game model from model/Game.php
		*/

		/**
		*  Display a view 
		*  Show the list of all the games to the users.
		*
		*  @return void
		*/
		public function index(){

			// fetch all the games from DB.
			$data = $this->Game->find('all');
			$count = $this->Game->find('count');

			$gameInformation = array(

					'games'=> $data,
					'count'=> $count
				);

			//pass data array to /view/games/index
			$this->set($gameInformation);	
		}


		/**
		*  Display a view 
		*  Show details of each game that user click.
		*
		*  @return void
		*/
		public function view($id = null){

			// check if ID is passed.
			if(!isset($id)){
				
				$this->Session->setFlash(__('Please specify Games ID to view!. Now returning to Games Home page!'));
				$this->redirect('index');					
			}

			// fetch passed ID's data from DB.
			$data = $this->Game->findById($id);

			//if data is not found,error msg.
			if(!$data){
				
				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to Games Home page!'));
				$this->redirect('index');									
			}			

			// pass found data to /view/games/view
			$this->set('game',$data);

		}

		/**
		*  Display a view 
		*  Form for adding new games.
		*
		*  @return void
		*/
		public function add(){

			// set the title for 'add' game page
			$this->set('title_for_layout','Add new game');

			//check if Form is already submitted.
			if($this->request->is('post')){

				$this->Game->create();
				
				// save new data to DB via Game model
				if($this->Game->save($this->request->data)){

					// saving new game is successful
					$this->Session->setFlash(__('Congratulation! New game has been added to your list!'));
					$this->redirect('index');	
				}
				else{

					//saving new game failed..
					$this->Session->setFlash(__('Saving new game failed!'));
				} 
			}
			// passing category data from DB using Game model to populate category top down list on game add page.
			$this->set('categories',$this->Game->Category->find('list',array('order' => 'name')));
		}

		/**
		*  Display a view 
		*  Form for editing existing games.
		*
		*  @return void
		*/
		public function edit($id = null){

			//set title for 'edit' game page.
			$this->set('title_for_layout','Edit existing game');

			//check if ID to edit does exist or not.
			if(!isset($id)){
				
				$this->Session->setFlash(__('Please specify Games ID to edit!. Now returning to Games Home page!'));
				$this->redirect('index');					
			}			

			//fetch data from DB with passed ID
			$data = $this->Game->findById($id);

			//check if requested data exist or not.
			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to Games Home page!'));
				$this->redirect('index');
			}
			
			// check if form is submitted to edit.		
			if($this->request->is('post') || $this->request->is('put')){

				//update the data in DB using data from edit form(ID is provied in the form but its made hideden)
				if($this->Game->save($this->request->data))
				{
					$this->redirect('index');	
				}									
				
			}else{

				$this->request->data = $data;					
			}		
			// passing category data from DB using Game model to populate category top down list on game add page.
			$this->set('categories',$this->Game->Category->find('list',array('order'=>'name')));
		}

		/**
		*  Do not display view. Redirect to index view instead.
		*  Method to delete games.
		*
		*  @return void
		*/
		public function delete($id = null){

			// check if ID exist to search and delete.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Games ID to delete!.Now returning to Games Home page!'));
				$this->redirect('index');	
			}
			
			//check if ID exist in DB or not.
			if($this->Game->exists($id)){

				//if ID exist , delete data with that ID.
				$this->Game->delete($id);
				$this->Session->setFlash(__('Game was successfuly deleted!'));
				$this->redirect('index');
			}
			else{
				//show msg, data with that ID not found.
				$this->Session->setFlash(__('Game was not found in database to delete.'));
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

			// if user try to search through the URL
			if(!isset($search)){

				$data = $this->Game->find('all');				
			}	
			else{

				$data = $this->Game->find('all',array('order'=>'year','conditions' => array('title LIKE' => '%'.$search.'%')
					));
			}

			$count = count($data);
			$gameInformation = array(

					'games'=> $data,
					'count'=> $count
				);

			$this->set($gameInformation);
			$this->render('index');
		}

	}

?>