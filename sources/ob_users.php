<?php
	class ob_users {
		
		public $user;
		public $pass;
		public $email;
		public $ide;
	
		public function reset_users()
		{
			$this->id=0;
			$this->user='';
			$this->pass='';
			$this->email='';
		}
	}
	
?>