<h1> Update Game</h1>

<?php 
	  echo $this->Form->create('Game');
	  echo $this->Form->input('category_id');
	  echo $this->Form->input('title');
	  echo $this->Form->input('year');
	  echo $this->Form->input('description');
	  echo $this->Form->input('developer');
	  echo $this->Form->hidden('id');	  
	  echo $this->Form->end('Update');
?>