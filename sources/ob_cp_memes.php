<?php
class cp_meme
{
    const MAX_DIM      = 960;  /* max width or height after resize */
    const WARN_DIM     = 500;  /* warn if both dims below this */
    const UPLOAD_DIR   = '../pics/meme_pics/';
    const PUBLIC_DIR   = 'pics/meme_pics/';

    public $formulari_ok;
    public $needs_dim_confirm;
    public $img;
    public $descripcio;
    public $author;
    public $error;
    public $memes;         /* result set for listing */
    public $total;

    public function __construct()
    {
        $this->formulari_ok     = FALSE;
        $this->needs_dim_confirm = FALSE;
        $this->img              = '';
        $this->descripcio       = '';
        $this->author           = '';
        $this->error            = 'Error: ';
        $this->memes            = FALSE;
        $this->total            = 0;
    }

    /* ---------------------------------------------------------------
       UPLOAD
    --------------------------------------------------------------- */

    public function recull_parametres($post, $files)
    {
        if (!isset($post['enviat']) || $post['enviat'] !== 'si') {
            return FALSE;
        }
        $this->formulari_ok = TRUE;
        $this->descripcio   = isset($post['descripcio']) ? trim($post['descripcio']) : '';
        $this->author       = isset($post['author'])     ? trim($post['author'])     : '';

        if ($files['file_meme']['error'] === UPLOAD_ERR_NO_FILE) {
            $this->error .= 'No has seleccionado ningún archivo.';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        if ($files['file_meme']['error'] !== UPLOAD_ERR_OK) {
            $this->error .= 'Error al subir el archivo (código ' . $files['file_meme']['error'] . ').';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        if (!isset($files['file_meme']['size']) || (int)$files['file_meme']['size'] > 5000000) {
            $this->error .= 'La imagen supera el tamaño máximo permitido (5MB).';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        $ext = $this->_get_ext($files['file_meme']['name']);
        if ($ext === '') {
            $this->error .= 'El archivo no es una imagen válida (jpg, jpeg, png, gif, webp).';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        $time_file = str_replace(array('-', ' ', ':'), '', date('Y-m-d H:i:s'));
        $filename  = $time_file . $ext;
        $dest      = self::UPLOAD_DIR . $filename;

        if (!is_uploaded_file($files['file_meme']['tmp_name'])) {
            $this->error .= 'El archivo no es un upload válido.';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        if (!move_uploaded_file($files['file_meme']['tmp_name'], $dest)) {
            $this->error .= 'Error al mover la imagen a su carpeta.';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        $img_info = @getimagesize($dest);
        if ($img_info !== FALSE) {
            $orig_w = $img_info[0];
            $orig_h = $img_info[1];

            /* Resize if longest side > MAX_DIM */
            if (max($orig_w, $orig_h) > self::MAX_DIM) {
                if ($orig_w >= $orig_h) {
                    $new_w = self::MAX_DIM;
                    $new_h = (int)round($orig_h * self::MAX_DIM / $orig_w);
                } else {
                    $new_h = self::MAX_DIM;
                    $new_w = (int)round($orig_w * self::MAX_DIM / $orig_h);
                }
                $img_resized = imagecreatetruecolor($new_w, $new_h);
                switch ($img_info[2]) {
                    case IMAGETYPE_JPEG:
                        $img_src = imagecreatefromjpeg($dest);
                        imagecopyresampled($img_resized, $img_src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
                        imagejpeg($img_resized, $dest, 90);
                        break;
                    case IMAGETYPE_PNG:
                        $img_src = imagecreatefrompng($dest);
                        imagealphablending($img_resized, false);
                        imagesavealpha($img_resized, true);
                        imagecopyresampled($img_resized, $img_src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
                        imagepng($img_resized, $dest);
                        break;
                    case IMAGETYPE_GIF:
                        $img_src = imagecreatefromgif($dest);
                        imagecopyresampled($img_resized, $img_src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
                        imagegif($img_resized, $dest);
                        break;
                    case IMAGETYPE_WEBP:
                        $img_src = imagecreatefromwebp($dest);
                        imagecopyresampled($img_resized, $img_src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
                        imagewebp($img_resized, $dest, 90);
                        break;
                }
                if (isset($img_src)) { imagedestroy($img_src); }
                imagedestroy($img_resized);
                $img_info = @getimagesize($dest);
            }

            /* Warn if both dims below WARN_DIM */
            if (!isset($post['confirm_small_img']) || $post['confirm_small_img'] !== 'si') {
                if ($img_info !== FALSE && $img_info[0] < self::WARN_DIM && $img_info[1] < self::WARN_DIM) {
                    $this->needs_dim_confirm = TRUE;
                    $this->formulari_ok      = FALSE;
                    $this->img               = self::PUBLIC_DIR . $filename;
                    return FALSE;
                }
            }
        } else {
            @unlink($dest);
            $this->error .= 'El archivo subido no es una imagen válida.';
            $this->formulari_ok = FALSE;
            return FALSE;
        }

        $this->img          = self::PUBLIC_DIR . $filename;
        $this->formulari_ok = TRUE;
        return TRUE;
    }

    public function introduir($bd)
    {
        $img        = $bd->real_escape_string($this->img);
        $descripcio = $bd->real_escape_string($this->descripcio);
        $author     = $bd->real_escape_string($this->author);
        $query = "INSERT INTO meme (img, descripcio, author, dateIn) VALUES ('" . $img . "', '" . $descripcio . "', '" . $author . "', NOW())";
        $res = $bd->query($query);
        if ($res) {
            print '<p class="terminal">¡¡Meme añadido correctamente!!</p>';
        } else {
            print '<p class="terminal">Error: no se ha podido añadir el meme.</p>';
        }
    }

    /* ---------------------------------------------------------------
       LIST
    --------------------------------------------------------------- */

    public function consulta_memes($bd, $desde, $quantitat)
    {
        $inici = (int)$desde - 1;
        $query = "SELECT idMeme, img, author, dateIn FROM meme ORDER BY dateIn DESC LIMIT " . $inici . ", " . (int)$quantitat;
        $this->memes = $bd->query($query);
        if (!$this->memes) {
            print '<p class="terminal">Error al extraer los memes.</p>';
        }
    }

    public function contar_memes($bd)
    {
        $query = "SELECT COUNT(*) AS total FROM meme";
        $res   = $bd->query($query);
        if ($res) {
            $row         = $res->fetch_assoc();
            $this->total = (int)$row['total'];
        }
        return $this->total;
    }

    /* ---------------------------------------------------------------
       DELETE
    --------------------------------------------------------------- */

    public function eliminar_meme($bd, $id)
    {
        $id = (int)$id;

        /* Fetch image path before deleting */
        $query = "SELECT img FROM meme WHERE idMeme = " . $id;
        $res   = $bd->query($query);
        if ($res && $res->num_rows == 1) {
            $row      = $res->fetch_assoc();
            $img_path = '../' . $row['img'];
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }

        $query = "DELETE FROM meme WHERE idMeme = " . $id;
        $res   = $bd->query($query);
        if ($res) {
            print '<p class="terminal">Meme eliminado correctamente.</p>';
        } else {
            print '<p class="terminal">Error al eliminar el meme.</p>';
        }
    }

    /* ---------------------------------------------------------------
       FORM
    --------------------------------------------------------------- */

    public function formulari()
    {
        print '<form id="form_meme" action="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '" method="post" enctype="multipart/form-data">';
        print '<input type="hidden" name="enviat" value="si" />';
        print '<input type="hidden" name="confirm_small_img" id="confirm_small_img" value="no" />';
        print '<fieldset><legend><p class="contingut">Subir meme</p></legend>';
        print '<p class="contingut"><input type="hidden" name="MAX_FILE_SIZE" value="5000000" />';
        if ($this->img !== '') {
            print '<img src="../' . htmlspecialchars($this->img) . '" width="150" /><br />';
        }
        print '<input type="file" name="file_meme" id="file_meme" /></p>';
        print '<p class="contingut"><label for="author">Autor:</label><br />';
        print '<input type="text" name="author" id="author" maxlength="100" size="40" value="' . htmlspecialchars($this->author) . '" /></p>';
        print '<p class="contingut"><label for="descripcio">Descripción (interna):</label><br />';
        print '<textarea name="descripcio" id="descripcio" rows="3" cols="40">' . htmlspecialchars($this->descripcio) . '</textarea></p>';
        print '<input type="submit" value="Añadir meme" /></fieldset>';
        print '</form>';
    }

    public function presentar_memes_formulari($bd, $tasca)
    {
        if (!$this->memes || $this->memes->num_rows == 0) {
            print '<p class="terminal">No hay memes.</p>';
            return;
        }
        while ($row = $this->memes->fetch_assoc()) {
            $id     = (int)$row['idMeme'];
            $img    = htmlspecialchars($row['img']);
            $fecha  = substr($row['dateIn'], 0, 10);
            $author = !empty($row['author']) ? htmlspecialchars($row['author']) : '—';
            print '<div class="noticia_curta">';
            print '<fieldset><legend class="white">Id: ' . $id . ' — Fecha: ' . $fecha . ' — Autor: ' . $author . '</legend>';
            print '<img src="../' . $img . '" width="100" /><br />';
            if ($tasca === 'del') {
                print '<form action="home_cp.php?sec=memes&action=del&id=' . $id . '&formulari=TRUE" method="post">';
                print '<input type="hidden" name="enviat_del" value="si" />';
                print '<input class="esq" type="submit" value="Eliminar" />';
                print '</form>';
            }
            print '</fieldset></div>';
        }
    }

    public function navegador_entrades($total, $punter, $quantitat, $action)
    {
        ?>
        <div class="navegador">
        <?php
        if ($punter != 1) {
            print '<a class="linkk" href="home_cp.php?sec=memes&action=' . $action . '&punter=1">
                    <img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>';
            $punter_dir = $punter - $quantitat;
            print '<a class="linkk" href="home_cp.php?sec=memes&action=' . $action . '&punter=' . $punter_dir . '">
                    <img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
        }
        if ($total >= ($punter + $quantitat)) {
            $punter_dir = $punter + $quantitat;
            print '<a class="linkk" href="home_cp.php?sec=memes&action=' . $action . '&punter=' . $punter_dir . '">
                    <img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
        }
        ?>
        </div>
        <?php
    }

    /* ---------------------------------------------------------------
       PRIVATE HELPERS
    --------------------------------------------------------------- */

    private function _get_ext($filename)
    {
        $filename = strtolower($filename);
        foreach (array('.webp', '.jpg', '.jpeg', '.gif', '.png') as $e) {
            if (substr($filename, -strlen($e)) === $e) {
                return $e;
            }
        }
        return '';
    }
}
?>
