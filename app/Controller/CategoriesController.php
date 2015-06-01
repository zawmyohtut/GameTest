<?php 

/**
* Category Contents Controller
*
*This controller will render views from view/categories
*
*The main purpose of this controller is to show the users the list of all 
*the categories in the database and will also allow the user view each category 
*on seperate page.Morever, users will be able to edit the user but will not be
*able to delete the category since it has the relationship with game table in DB
*and deleting the category will violate the rules of the table relationship in DB.
*/


	class CategoriesController extends AppController
	{

		/**
		* This controller use @Category model from model/Category.php
		*/

		/**
		*  Display a view 
		*  Show the list of all the Categories to the users.
		*
		*  @return void
		*/
		public function index(){

			$this->set('categories',$this->Category->find('all'));			
		}

		/**
		*  Display a view 
		*  Show details of each category that user click.
		*
		*  @return void
		*/
		public function view($id = null){

			// check if ID is passed.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to view!. Now returning to Category Home page!'));
				$this->redirect('index');					
			}

			// fetch passed ID's data from DB.
			$data = $this->Category->findById($id);			

			//if data is not found,error msg.
			if(!$data){

				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');		
			}
			
			// pass found data to /view/categories/view
			$this->set('category',$data);

		}

		/**
		*  Display a view 
		*  Form for adding new categories.
		*
		*  @return void
		*/
		public function add(){

			//check if Form is already submitted.
			if($this->request->is('post')){

				$this->Category->create();

				// save new data to DB via Category model
				if($this->Category->save($this->request->data)){

					// saving new category is successful
					$this->Session->setFlash(__('Congratulation! New category has been added to your list!'));
					$this->redirect('index');	
				}			
			} 
		}

		/**
		*  Display a view 
		*  Form for editing existing categories.
		*
		*  @return void
		*/
		public function edit($id = null){

			//check if ID to edit does exist or not.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to edit!. Now returning to Category Home page!'));
				$this->redirect('index');					
			}

			//fetch data from DB with passed ID
			$data = $this->Category->findById($id);			

			//check if requested data exist or not.
			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');
			}

			// check if form is submitted to edit.		
			if($this->request->is('post') || $this->request->is('put')){

				//update the data in DB using data from edit form(ID is provied in the form but its made hideden)
				if($this->Category->save($this->request->data)){	

					$this->redirect('index');	
				}				
			}	
			else{

				$this->request->data = $data;	
			}		
		}

		/**
		*  Do not display view. Redirect to index view instead.
		*  Method to delete categories.
		*
		*  This method is not the user to user as category should not be able to delete as explained in the 
		*  controller description at the top of this class.
		*  @return void
		*/
		public function delete($id = null){

			// check if ID exist to search and delete.
			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to delete!.Now returning to Category Home page!'));
				$this->redirect('index');	
			}

			//check if data with that ID exist or not.
			$data = $this->Category->findById($id);

			//check if data exist
			if($data){

				//delete data with that ID.
				$this->Category->delete($id);				
				$this->redirect('index');
			}
			else{

				$this->Session->setFlash(__('ID you searched to delete is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');
			}


		}

	}
?>