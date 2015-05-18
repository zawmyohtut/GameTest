<h1> Add New Game</h1>

<?php 
	  echo $this->Form->create('Game');
	  echo $this->Form->input('category_id'); //because of the naming convention,php knows that user want to have list of the categories.
	  echo $this->Form->input('title');
	  echo $this->Form->input('year');
	  echo $this->Form->input('description');
	  echo $this->Form->input('developer');
	  echo $this->Form->end('Save Game');
?>