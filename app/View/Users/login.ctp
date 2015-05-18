<h2>Please Log In.</h2>
<p>Log in to start editing contents.</p>

<?php 	
	echo $this->Form->create('User');
	echo $this->Form->input('username',array('rows' => '1'));
	echo $this->Form->input('password');
	echo $this->Form->end(__('Login'));
?>