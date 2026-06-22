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
			if ($this->bd instanceof mysqli) return;

			@ $this->bd = new  mysqli('62.149.150.175','Sql613596','9d8a8df8','Sql613596_1');
			if (mysqli_connect_errno()) {
				$this->error_conexio=TRUE;
				$this->bd=null;
			}

		}
		public function desconectar()
		{
			if (!($this->bd instanceof mysqli)) return false;
			$error=$this->bd->close();
			$this->bd=null;
			return $error;
		}
		
		public function contar_entrades($taula)
		{
			$owned = !($this->bd instanceof mysqli);
			$this->conectar();
			if ($this->error_conexio) return 0;
			$query = "SELECT COUNT(*) FROM ".$taula."";
			$numero = $this->bd->query($query);
			if ($owned) $this->desconectar();

		  return ($numero);
		}
	}
?>