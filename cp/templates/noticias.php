<div id="columna_central">

	<?php

	require('../sources/ob_cp_noticias.php');
	$noticia_add = new cp_noticia;
	switch ($page->action) {
		case 'main':
			?>
			<p class="titol_parcial">Noticias actuales</p>

			<?php
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$noticia_add->consulta_noticies($basedades->bd, $page->punter, $page->num_a_mostrar);
				$noticia_add->presentar_noticies_formulari($basedades->bd, 'edit_del');
				$noticia_add->navegador_entrades($basedades->contar_entrades('news'), $page->punter, $page->num_a_mostrar, $page->action);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}


			break;
		case 'add':

			?>
			<p class="titol_parcial">Añadir noticia</p>
			<?php

			if (isset($_POST['enviat'])) { /* s'ha enviat rl formulari? */
				if ($noticia_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
					if (!$noticia_add->validar_entrada($page)) {
						print '<p class="terminal">' . $noticia_add->error . '</p>';
					}

				} else {
					if (!$noticia_add->needs_dim_confirm) {
						$noticia_add->inicialitzar_noticia(); /* no esta enviat o no es correcte, es posa tot a 0 */
					}
				}


			} else {
				$noticia_add->inicialitzar_noticia(); /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$noticia_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */

				if ($noticia_add->needs_dim_confirm) { ?>
					<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
						<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
							<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
							<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_noticia').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
							<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
						</div>
					</div>
				<?php }
				$noticia_add->formulari();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$noticia_add->introduir($basedades->bd, FALSE, FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}

			break;
		case 'edit':
			?>
			<p class="titol_parcial">Elije la noticia a editar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */

				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$noticia_add->consulta_noticies($basedades->bd, $page->punter, $page->num_a_mostrar);
					$noticia_add->presentar_noticies_formulari($basedades->bd, 'editar');
					$noticia_add->navegador_entrades($basedades->contar_entrades('news'), $page->punter, $page->num_a_mostrar, $page->action);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					if ($noticia_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
						if (!$noticia_add->validar_entrada($page)) {
							print '<p class="terminal">' . $noticia_add->error . '</p>';

						}

					} else {
						print '<p class="terminal">Error al recollir el formulari de edició</p>';

					}

				} else {

					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$noticia_add->extreu_dades_noticia_per_id($basedades->bd, $page->id);
						print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$noticia_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
					if ($noticia_add->needs_dim_confirm) { ?>
						<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
							<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
								<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
								<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_noticia').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
								<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
							</div>
						</div>
					<?php }
					$noticia_add->formulari();

				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$noticia_add->eliminar_registre($basedades->bd, $page->id);
						$noticia_add->introduir($basedades->bd, TRUE, $page->id);
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}


			}
			break;
		case 'del':
			?>
			<p class="titol_parcial">Elije la noticia a eliminar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */

				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$noticia_add->consulta_noticies($basedades->bd, $page->punter, $page->num_a_mostrar);
					$noticia_add->presentar_noticies_formulari($basedades->bd, 'del');
					$noticia_add->navegador_entrades($basedades->contar_entrades('news'), $page->punter, $page->num_a_mostrar, $page->action);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$noticia_add->eliminar_registre($basedades->bd, $page->id);
					print '<p class="terminal">Registro Eliminado</p>';
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
			break;
	}
	?>
</div>
<script>
(function () {
    var MAX_DIM = 550;
    var pendingResizes = 0;

    function setSubmitDisabled(disabled) {
        var btn = document.querySelector('#form_noticia [type=submit]');
        if (btn) btn.disabled = disabled;
    }

    function resizeInput(input) {
        input.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file || !file.type.match(/^image\//)) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var img = new Image();
                img.onload = function () {
                    var w = img.width, h = img.height;
                    if (Math.max(w, h) <= MAX_DIM) return; /* already small enough */
                    var scale = MAX_DIM / Math.max(w, h);
                    var nw = Math.round(w * scale);
                    var nh = Math.round(h * scale);
                    var canvas = document.createElement('canvas');
                    canvas.width = nw;
                    canvas.height = nh;
                    canvas.getContext('2d').drawImage(img, 0, 0, nw, nh);
                    var mimeType = file.type === 'image/png' ? 'image/png' : 'image/jpeg';
                    pendingResizes++;
                    setSubmitDisabled(true);
                    canvas.toBlob(function (blob) {
                        var ext = mimeType === 'image/png' ? '.png' : '.jpg';
                        var fileName = file.name.replace(/\.[^.]+$/, '') + ext;
                        var resized = new File([blob], fileName, { type: mimeType });
                        var dt = new DataTransfer();
                        dt.items.add(resized);
                        input.files = dt.files;
                        pendingResizes--;
                        if (pendingResizes === 0) setSubmitDisabled(false);
                    }, mimeType, 0.90);
                };
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    function attachAll() {
        var form = document.getElementById('form_noticia');
        if (form) {
            form.addEventListener('submit', function (e) {
                if (pendingResizes > 0) e.preventDefault();
            });
        }
        for (var i = 1; i <= 5; i++) {
            var el = document.getElementById('file_' + i);
            if (el) resizeInput(el);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachAll);
    } else {
        attachAll();
    }
})();
</script>