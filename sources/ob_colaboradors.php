<?php
	class ob_colaboradors {
		
		public $id;
        public $nom;
		public $tipus; /* 1 - Responsables 2 - Staff 3 - Redactor 4 - Colaborador */ 
		public $mail;
		public $actiu; /* 1 si 2 no */
        public $bio_es;
        public $bio_cat;
        public $ruta;
        public $carreg_es;
        public $carreg_cat;
	
		public function reset_colaboradors()
		{
			$this->id=0;
			$this->nom='';
			$this->tipus='';
			$this->mail='';
            $this->actiu='';
            $this->bio_es='';
            $this->bio_cat='';
            $this->carreg_es='';
            $this->carreg_cat='';
            $this->ruta='';           
		}
	}
	
?>