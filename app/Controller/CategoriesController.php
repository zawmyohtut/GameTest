<?php 

	class CategoriesController extends AppController
	{

		public function index(){

			$this->set('categories',$this->Category->find('all'));
		}

		public function view($id = null){

			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to view!. Now returning to Category Home page!'));
				$this->redirect('index');					
			}

			$data = $this->Category->findById($id);			

			if(!$data){

				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');		
			}
			
			$this->set('category',$data);

		}

		public function add(){

			if($this->request->is('post')){

					$this->Category->create();
					if($this->Category->save($this->request->data)){

						$this->redirect('index');	
					}			
			} 
		}

		public function edit($id = null){

			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to edit!. Now returning to Category Home page!'));
				$this->redirect('index');					
			}

			$data = $this->Category->findById($id);			

			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');
			}

			if($this->request->is('post') || $this->request->is('put')){

				if($this->Category->save($this->request->data)){	

					$this->redirect('index');	
				}				
			}	
			else{

				$this->request->data = $data;	
			}		
		}


		public function delete($id = null){

			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Category ID to delete!.Now returning to Category Home page!'));
				$this->redirect('index');	
			}

			$data = $this->Category->findById($id);

			if($data){

				$this->Category->delete($id);	
				//alert message to tell user item is already deleted.			
				$this->redirect('index');
			}
			else{

				$this->Session->setFlash(__('ID you searched to delete is not found in the database!.Now returning to Category Home page!'));
				$this->redirect('index');
			}


		}

	}
?>