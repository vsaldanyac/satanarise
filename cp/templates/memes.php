<div id="columna_central">

	<?php

	require('../sources/ob_cp_memes.php');
	$meme_cp = new cp_meme;

	switch ($page->action) {

		case 'add':
			?>
			<p class="titol_parcial">Añadir meme</p>
			<?php

			if (isset($_POST['enviat'])) {
				if ($meme_cp->recull_parametres($_POST, $_FILES)) {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$meme_cp->introduir($basedades->bd);
						$basedades->desconectar();
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				} else {
					if ($meme_cp->needs_dim_confirm) { ?>
						<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
							<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
								<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
								<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_meme').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
								<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
							</div>
						</div>
					<?php }
					if ($meme_cp->error !== 'Error: ') {
						print '<p class="terminal">' . $meme_cp->error . '</p>';
					}
				}
			}

			if (!$meme_cp->formulari_ok) {
				$meme_cp->formulari();
			}
			break;

		case 'del':
			?>
			<p class="titol_parcial">Eliminar meme</p>
			<?php

			if (!$page->formulari) {
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$meme_cp->consulta_memes($basedades->bd, $page->punter, $page->num_a_mostrar);
					$meme_cp->presentar_memes_formulari($basedades->bd, 'del');
					$meme_cp->navegador_entrades(
						$meme_cp->contar_memes($basedades->bd),
						$page->punter,
						$page->num_a_mostrar,
						$page->action
					);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$meme_cp->eliminar_meme($basedades->bd, $page->id);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
			break;

		case 'main':
		default:
			?>
			<p class="titol_parcial">Memes</p>
			<?php
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$meme_cp->consulta_memes($basedades->bd, $page->punter, $page->num_a_mostrar);
				$meme_cp->presentar_memes_formulari($basedades->bd, 'main');
				$meme_cp->navegador_entrades(
					$meme_cp->contar_memes($basedades->bd),
					$page->punter,
					$page->num_a_mostrar,
					$page->action
				);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}
			break;
	}
	?>
</div>
