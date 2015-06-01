<h1> Add New User</h1>

<?php 
	  echo $this->Form->create('User');	  
	  echo $this->Form->input('last_name');
	  echo $this->Form->input('first_name');
	  echo $this->Form->input('username',array('rows' => '1'));
	  echo $this->Form->input('password');
	  echo $this->Form->input('confirm_password',array('label' => 'Re-enter Password','type' => 'password'));
	  echo $this->Form->input('email');
	  echo $this->Form->hidden('unhashed_password');
	  echo $this->Form->end('Register');
?>