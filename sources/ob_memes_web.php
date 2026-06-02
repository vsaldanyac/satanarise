<?php
class ob_memes_web
{
    public $meme_recent;   /* array with idMeme, img, dateIn — or FALSE */
    public $memes;         /* array of rows for archive listing */
    public $total;         /* total count of memes */

    public function __construct()
    {
        $this->meme_recent = FALSE;
        $this->memes       = array();
        $this->total       = 0;
    }

    public function extreure_meme_recent($bd)
    /* Fetches the single most recent meme uploaded within the last 3 days */
    {
        $query = "SELECT idMeme, img, author, dateIn FROM meme
                  WHERE dateIn >= DATE_SUB(NOW(), INTERVAL 3 DAY)
                  ORDER BY dateIn DESC LIMIT 1";
        $resultat = $bd->query($query);
        if ($resultat && $resultat->num_rows == 1) {
            $this->meme_recent = $resultat->fetch_assoc();
        }
    }

    public function extreure_memes_per_pagina($bd, $pagina, $per_pagina)
    /* Fetches a paginated list of all memes, most recent first */
    {
        $inici = ($pagina - 1) * $per_pagina;

        $query_total = "SELECT COUNT(*) AS total FROM meme";
        $res_total   = $bd->query($query_total);
        if ($res_total) {
            $row         = $res_total->fetch_assoc();
            $this->total = (int)$row['total'];
        }

        $query = "SELECT idMeme, img, author, dateIn FROM meme
                  ORDER BY dateIn DESC
                  LIMIT " . (int)$inici . ", " . (int)$per_pagina;
        $resultat = $bd->query($query);
        if ($resultat) {
            while ($row = $resultat->fetch_assoc()) {
                $this->memes[] = $row;
            }
        }
    }
}
?>
