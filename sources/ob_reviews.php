<?php
	class ob_reviews {
		
		public $id;
        public $disc;
		public $tipus; /* 1 - LP 2 - EP 3 - DEMO */
        public $banda;
        public $portada;
        public $logo;
        public $video; /* 1 - Video 2 - Foto banda */
        public $media; /* Si video, codi del video, si foto banda, ruta de la foto */
        public $media_video;
        public $media_foto;
        public $texte_es;
        public $texte_cat;
        public $link;
        public $tracklist;
        public $formacio_es;
        public $formacio_cat;
        public $idcolaboradors;
        public $colaborador;
        public $nota;
        public $idpais;
        public $pais;
        public $bandera;
        public $any;
        public $idestil;
        public $estil;
		public $estil_global;
        public $idlabel;
        public $label;
        public $link_label;
        public $timestamp;
        public $dia = 0;
        public $mes = 0;
        public $anydata = 0;
        public $release_dia = 0;
        public $release_mes = 0;
        public $release_any = 0;
		
	
		public function reset_reviews()
		{
			$this->id=0;
			$this->disc='';
			$this->tipus='';
			$this->banda='';
            $this->portada='';
            $this->logo='';
            $this->video=0;
            $this->media='';
            $this->media_video='';
            $this->media_foto='';
            $this->texte_es='';
            $this->texte_cat='';
            $this->link='';
            $this->tracklist='';
            $this->formacio_es='';
            $this->formacio_cat='';
            $this->idcolaboradors=0;
            $this->colaborador;
            $this->nota='';
            $this->idpais=0;
            $this->pais;
            $this->bandera;
            $this->any='';
            $this->idestil=0;
            $this->estil;
			$this->estil_global=0;
            $this->idlabel=0;
            $this->label;
            $this->link_label;  
            $this->timestamp='';         
            $this->dia=0;
            $this->mes=0;
            $this->anydata=0;
            $this->release_dia=0;
            $this->release_mes=0;
            $this->release_any=0;
		}
	}
	
?>