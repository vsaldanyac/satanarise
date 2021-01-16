<?php
	class ob_preferidos {
		
		public $id;
        public $nom;
		public $obs; 
        public $data;
        public $resp1;
        public $resp2;
        public $resp3;
        public $resp4;
        public $resp5;
        public $pic;
    
		
	
		public function reset_preferidos()
		{
			$this->id=0;
			$this->nom='';
			$this->obs='';
			$this->data='';
            $this->resp1='';
            $this->resp2='';
            $this->resp3=0;
            $this->resp4='';
            $this->resp5='';
            $this->pic='';
            
		}
	}
	
?>