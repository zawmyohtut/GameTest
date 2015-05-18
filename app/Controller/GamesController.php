<?php 

	class GamesController extends AppController
	{						
		public function index(){

			$data = $this->Game->find('all');
			$count = $this->Game->find('count');

			$gameInformation = array(

					'games'=> $data,
					'count'=> $count
				);

			$this->set($gameInformation);

		}

		public function view($id = null){

			if(!isset($id)){
				
				$this->Session->setFlash(__('Please specify Games ID to view!. Now returning to Games Home page!'));
				$this->redirect('index');					
			}

			$data = $this->Game->findById($id);

			if(!$data){
				
				$this->Session->setFlash(__('ID you searched is not found in the database!.Now returning to Games Home page!'));
				$this->redirect('index');									
			}			

			$this->set('game',$data);

		}

		public function add(){

			$this->set('title_for_layout','Add new game');
			if($this->request->is('post')){

				$this->Game->create();
				
				if($this->Game->save($this->request->data)){

					$this->Session->setFlash(__('Congratulation! New game has been added to your list!'));
					$this->redirect('index');	
				}
				else{

						$this->Session->setFlash(__('Saving new game failed!'));
				} 
			}

			$this->set('categories',$this->Game->Category->find('list',array('order' => 'name')));
		}

		public function edit($id = null){

			$this->set('title_for_layout','Edit existing game');

			if(!isset($id)){
				
				$this->Session->setFlash(__('Please specify Games ID to edit!. Now returning to Games Home page!'));
				$this->redirect('index');					
			}			

			$data = $this->Game->findById($id);

			if(!$data){

				$this->Session->setFlash(__('ID you searched to edit is not found in the database!.Now returning to Games Home page!'));
				$this->redirect('index');
			}
							
			if($this->request->is('post') || $this->request->is('put')){

				if($this->Game->save($this->request->data))
				{
					$this->redirect('index');	
				}									
				
			}else{

				$this->request->data = $data;					
			}		

			$this->set('categories',$this->Game->Category->find('list',array('order'=>'name')));
		}

		public function delete($id = null){

			if(!isset($id)){

				$this->Session->setFlash(__('Please specify Games ID to delete!.Now returning to Games Home page!'));
				$this->redirect('index');	
			}
			
			if($this->Game->exists($id)){

				$this->Game->delete($id);
				$this->Session->setFlash(__('Game was successfuly deleted!'));
				$this->redirect('index');
			}
			else{

				$this->Session->setFlash(__('Game was not found in database to delete.'));
				$this->redirect('index');
			}			

		}

		public function search($search = null){

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