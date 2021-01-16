<?php
	class ob_bbdd {
		public $error_conexio; /* control de conecció */
		public $bd;
		
		public function __consctruct() {
			$this->error_conexio=FALSE;
		}
		public function __set($name,$value)
		{
			$this->$name=$value;
		}
		public function __get($name)
		{
			return $this->$name;
		}
		public function conectar()
		{

			
			@ $this->bd = new  mysqli('62.149.150.175','Sql613596','9d8a8df8','Sql613596_1');
			if (mysqli_connect_errno()) {
				$this->error_conexio=TRUE;
			}
						
		}
		public function desconectar()
		{
			
			$error=$this->bd->close();
			return $error;
		}
		
		public function contar_entrades($taula)
		{
			$this->conectar();
			$query = "SELECT * FROM ".$taula."";  // sentencia sql
			$result = $this->bd->query($query);
			$numero =$result->num_rows;
            
		  return ($numero);
		}
	}
?>