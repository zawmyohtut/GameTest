<h1> Update User</h1>

<?php 
	  echo $this->Form->create('User');	  
	  echo $this->Form->input('last_name');
	  echo $this->Form->input('first_name');
	  echo $this->Form->input('username',array('rows' => '1'));
	  echo $this->Form->input('password');
	  echo $this->Form->input("email");
	  echo $this->Form->end('Update');
?>