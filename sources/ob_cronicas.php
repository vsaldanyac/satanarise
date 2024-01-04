<?php
class ob_cronicas
{
  public $id;
  public $titol;
  public $cartell;
  public $num_div;
  public $intro;
  public $intro_es;
  public $intro_cat;
  public $outro;
  public $outro_es;
  public $outro_cat;
  public $idioma; /* ES CAT BOTH */
  public $idcolaborador1;
  public $colaborador1;
  public $idcolaborador2;
  public $colaborador2;
  public $link;
  public $idfoto1;
  public $foto1;
  public $idfoto2;
  public $foto2;
  public $timestamp;
  public $dia;
  public $mes;
  public $anydata;
  public $setlist;


  public function reset_cronicas()
  {
    $this->id = 0;
    $this->titol = '';
    $this->cartell = '';
    $this->num_div = 0;
    $this->intro = '';
    $this->intro_es = '';
    $this->intro_cat = '';
    $this->outro = '';
    $this->outro_es = '';
    $this->outro_cat = '';
    $this->idioma = ''; /* ES CAT BOTH */
    $this->idcolaborador1 = 0;
    $this->colaborador1 = '';
    $this->idcolaborador2 = 0;
    $this->colaborador2 = '';
    $this->idfoto1 = 0;
    $this->foto1 = '';
    $this->idfoto2 = 0;
    $this->foto2 = '';
    $this->timestamp = 0;
    $this->dia = 0;
    $this->mes = 0;
    $this->anydata = 0;
    $this->link = '';
    $this->setlist = '';
  }

  public function crear_divisions()
  {
    for ($i = 1; $i <= $this->num_div; $i++) {
      $nom = 'div' . $i;
      $this->$nom = new ob_divisio;
      $this->$nom->reset_divisio();
    }
  }
}

class ob_divisio
{

  public $id;
  public $id_cronica;
  public $imgs;
  public $texte_es;
  public $texte_cat;
  public $ordre;


  public function reset_divisio()
  {
    $this->id = 0;
    $this->id_cronica = 0;
    $this->imgs[1] = '';
    $this->imgs[2] = '';
    $this->imgs[3] = '';
    $this->imgs[4] = '';
    $this->imgs[5] = '';
    $this->texte_es = '';
    $this->texte_cat = '';
    $this->ordre = 0;
  }
}

?>