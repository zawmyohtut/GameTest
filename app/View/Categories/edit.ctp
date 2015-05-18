<h1> Update Category</h1>

<?php 
	  echo $this->Form->create('Category');
	  echo $this->Form->input('name');
	  echo $this->Form->input('length_type');
	  echo $this->Form->hidden('id');	  
	  echo $this->Form->end('Update');
?>