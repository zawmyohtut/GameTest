<h1> Add New Category</h1>

<?php 
	  echo $this->Form->create('Category');
	  echo $this->Form->input('name');
	  echo $this->Form->input('length_type',array('label' => 'Game play hours'));		  
	  echo $this->Form->end('Save Category');
?>