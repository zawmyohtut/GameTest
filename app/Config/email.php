<?php 
	
	class EmailConfig
	{
		public $smtp = array(
		'transport' => 'Smtp',
		'from' => array('site@localhost' => 'My Site'),
		'host' => 'localhost',
		'port' => 587,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => false,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
		);

		public $default = array(

			'transport' => 'Mail',
			//'from' => 'you@localhost',
			'from' => 'zawmyohtut@gmail.com'
			//'charset' => 'utf-8',
			//'headerCharset' => 'utf-8',

		);

		public $gmail = array(

	        'host' => 'ssl://smtp.gmail.com',
	        'port' => 465,
	        'username' => 'zaw@intersective.com',
	        'password' => 'test1234',
	        'transport' => 'Smtp'

    	);
		
	}

?>