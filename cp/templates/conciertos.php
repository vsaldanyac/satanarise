<div id="columna_central">
	<?php
	require('../sources/ob_cp_conciertos.php');
	require('../sources/ob_concerts.php');
	$cp_concert = new cp_propers_concerts();

	$buscar_banda = isset($_GET['buscar_banda']) ? $_GET['buscar_banda'] : '';
	$buscar_data  = isset($_GET['buscar_data'])  ? $_GET['buscar_data']  : '';
	$filtros_activos = (trim($buscar_banda) != '' || trim($buscar_data) != '');

	switch ($page->action) {
		case 'main':
			?>
			<p class="titol_parcial">Conciertos actuales</p>
			<form method="get" action="home_cp.php">
				<input type="hidden" name="sec" value="conciertos" />
				<input type="hidden" name="action" value="main" />
				<p class="contingut">
					Banda: <input type="text" name="buscar_banda" value="<?php echo htmlspecialchars($buscar_banda); ?>" />
					&nbsp;&nbsp;
					Fecha: <input type="text" name="buscar_data" value="<?php echo htmlspecialchars($buscar_data); ?>" />
					&nbsp;&nbsp;
					<input type="submit" value="Buscar" />
					<?php if ($filtros_activos) { ?>&nbsp;<a class="linkk" href="home_cp.php?sec=conciertos&action=main">Limpiar filtros</a><?php } ?><br>
					<span style="font-size: 11px; color: #666; margin-left: 280px;">Formato: YYYY-MM-DD, YYYY-MM, YYYY, DD, o MM</span>
				</p>
			</form>
			<?php
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$cp_concert->presentar_concerts_formulari($basedades->bd, 'edit_del', $page->punter, $page->num_a_mostrar, $buscar_banda, $buscar_data, 'futuros');
				$total_nav = 0;
				$cp_concert->navegador_entrades($total_nav, $page->punter, $page->num_a_mostrar, $page->action);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}


			break;
		case 'add':
			?>
			<p class="titol_parcial">Añadir Concierto / Gira / Festival</p>
			<?php
			if ($cp_concert->recull_parametres_formulari_2($_POST, $page->id)) /* s'ha enviat el formulari 2? */{
				/* El formulari 2 esta omplert i recollit, verificar dades i omplir bbdd o tornar a demanar formulari 2 en cas de dades incorrectes */
				if ($cp_concert->validar_entrada()) {
					/* Dades ben introduides */
					print '<p class="terminal">Formularis OK!</p>';
					$basedades->conectar();
					if (!$basedades->__get('error_conexio')) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$cp_concert->introduir_concert($basedades->bd, FALSE, 0);
						$basedades->desconectar();
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				} else {
					/* Dades mal introduides, torna a demanar el formulari */
					print '<p class="terminal">' . $cp_concert->__get('error') . '</p>';
					$cp_concert->formulari_2();
				}

			} else { /* No està omplert el formulari 2 */

				if ($cp_concert->needs_dim_confirm) {
					?>
					<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
						<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
							<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
							<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_concierto').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
							<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
						</div>
					</div>
					<?php
					$cp_concert->formulari_2();
				} elseif ($cp_concert->recull_parametres_formulari_1($_POST, $page->id)) /* s'ha enviat el formulari 1? */{
					/* S'ha omplert formular 1, recollir dades i mostrar formulari 2 */
					$cp_concert->formulari_2(); /* Si no hi ha formular 2 ho genera formulari sense dades */

				} else {
					/* No s'ha omplert el fomulari 1, mostrar formular 1 */
					$cp_concert->formulari_1();
				}

			}

			break;
		case 'edit':
			?>
			<p class="titol_parcial">Elije el concierto a editar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
				?>
				<form method="get" action="home_cp.php">
					<input type="hidden" name="sec" value="conciertos" />
					<input type="hidden" name="action" value="edit" />
					<p class="contingut">
						Banda: <input type="text" name="buscar_banda" value="<?php echo htmlspecialchars($buscar_banda); ?>" />
						&nbsp;&nbsp;
						Fecha: <input type="text" name="buscar_data" value="<?php echo htmlspecialchars($buscar_data); ?>" />
						&nbsp;&nbsp;
						<input type="submit" value="Buscar" />
						<?php if ($filtros_activos) { ?>&nbsp;<a class="linkk" href="home_cp.php?sec=conciertos&action=edit">Limpiar filtros</a><?php } ?><br>
						<span style="font-size: 11px; color: #666; margin-left: 280px;">Formato: YYYY-MM-DD, YYYY-MM, YYYY, DD, o MM</span>
					</p>
				</form>
				<?php
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->presentar_concerts_formulari($basedades->__get('bd'), 'editar', $page->punter, $page->num_a_mostrar, $buscar_banda, $buscar_data, 'futuros');
					$total_nav = 0;
					$cp_concert->navegador_entrades($total_nav, $page->punter, $page->num_a_mostrar, $page->action);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				/* S'ha enviat el formilari  */
				if ($cp_concert->recull_parametres_formulari_2($_POST, $page->id)) { /* s'ha enviat el formulari 2 */
					if ($cp_concert->validar_entrada()) {
						/* Dades ben introduides */
						print '<p class="terminal">Formularis OK!</p>';
						/* Introduir dades de nou despres d'eliminar els registres vells*/
						$basedades->conectar();
						if (!$basedades->error_conexio) {
							$cp_concert->introduir_concert($basedades->__get('bd'), TRUE, $page->__get('id'));
						} else {
							print '<p class="terminal">Error de conexión a la base de datos</p>';
						}

					} else {
						/* AQUI */print '<p class="terminal">' . $cp_concert->__get('error') . '</p>';
						$cp_concert->formulari_2();
					}

				} else {

					if ($cp_concert->needs_dim_confirm) {
						?>
						<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
							<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
								<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
								<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_concierto').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
								<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
							</div>
						</div>
						<?php
						$cp_concert->formulari_2();
					} else {
						/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
						$basedades->conectar();
						if (!$basedades->error_conexio) {
							print '<p class="terminal">Conexió OK!</p>';
							$cp_concert->extreu_dades_concert_per_id($basedades->__get('bd'), $page->id);
							print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
							$basedades->desconectar();
							/* Una vegada extretes les dades correctament es presenta el formulari 2 */
							$cp_concert->formulari_2();

						} else {
							print '<p class="terminal">Error de conexión a la base de datos</p>';
						}
					}
				}



			}
			break;
		case 'del':
			?>
			<p class="titol_parcial">Elije el concierto a eliminar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
				?>
				<form method="get" action="home_cp.php">
					<input type="hidden" name="sec" value="conciertos" />
					<input type="hidden" name="action" value="del" />
					<p class="contingut">
						Banda: <input type="text" name="buscar_banda" value="<?php echo htmlspecialchars($buscar_banda); ?>" />
						&nbsp;&nbsp;
						Fecha: <input type="text" name="buscar_data" value="<?php echo htmlspecialchars($buscar_data); ?>" />
						&nbsp;&nbsp;
						<input type="submit" value="Buscar" />
						<?php if ($filtros_activos) { ?>&nbsp;<a class="linkk" href="home_cp.php?sec=conciertos&action=del">Limpiar filtros</a><?php } ?><br>
						<span style="font-size: 11px; color: #666; margin-left: 280px;">Formato: YYYY-MM-DD, YYYY-MM, YYYY, DD, o MM</span>
					</p>
				</form>
				<?php
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->presentar_concerts_formulari($basedades->bd, 'del', $page->punter, $page->num_a_mostrar, $buscar_banda, $buscar_data, 'futuros');
					$total_nav = 0;
					$cp_concert->navegador_entrades($total_nav, $page->punter, $page->num_a_mostrar, $page->action);
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
					$cp_concert->eliminar_registre($basedades->bd, $page->id);
					print '<p class="terminal">Registro Eliminado</p>';
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
			break;
		case 'borrar_fora_de_data':
			?>
			<p class="titol_parcial">Conciertos pasados</p>
			<?php
			if ($page->formulari) {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->eliminar_registre($basedades->bd, $page->id);
					print '<p class="terminal">Registro Eliminado</p>';
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->presentar_concerts_formulari($basedades->bd, 'edit_del', $page->punter, $page->num_a_mostrar, '', '', 'pasados');
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
    var pendingResizes = 0;

    function setSubmitDisabled(disabled) {
        var btn = document.querySelector('#form_concierto [type=submit]');
        if (btn) btn.disabled = disabled;
    }

    function attachImageResizer() {
        var form = document.getElementById('form_concierto');
        if (form) {
            form.addEventListener('submit', function (e) {
                if (pendingResizes > 0) e.preventDefault();
            });
        }
        var input = document.getElementById('cartell_generic');
        if (!input) return;
        input.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file || !file.type.match(/^image\//)) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var img = new Image();
                img.onload = function () {
                    var MAX_H = 720;
                    var w = img.width, h = img.height;
                    if (h <= MAX_H) return; /* already small enough, keep original */
                    w = Math.round(w * MAX_H / h);
                    h = MAX_H;
                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                    var mimeType = file.type === 'image/png' ? 'image/png' : 'image/jpeg';
                    var quality = 0.90;
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
                    }, mimeType, quality);
                };
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
    /* Run now if DOM is ready, otherwise wait */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachImageResizer);
    } else {
        attachImageResizer();
    }
})();
</script>