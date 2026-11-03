<?php
	class ob_bbdd {
		public $error_conexio; /* control de conecció */
		public $bd;
		
		public function __construct() {
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

			@ $this->bd = new  mysqli('31.11.38.54','Sql613596','9d8a8df8','Sql613596_1');
			if (mysqli_connect_errno()) {
				$this->error_conexio=TRUE;
				$this->bd=null;
			} else {
				/* Columns are latin1 holding UTF-8 bytes. MySQL 5.7 defaulted the connection to latin1 (no
				   conversion); MySQL 8.0 defaults to utf8mb4, which would convert and double-encode. Pin it. */
				$this->bd->set_charset('latin1');
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