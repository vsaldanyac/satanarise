<?php
/* Meme del día widget — shared by col_left (desktop) and inici.php (mobile).
   Visibility is controlled via CSS classes:
     .meme-widget-desktop  → shown on desktop, hidden on mobile
     .meme-widget-mobile   → shown on mobile,  hidden on desktop
   The $meme_widget_class variable is set by the including file.
*/

if (!isset($meme_widget_class)) $meme_widget_class = '';

$meme_widget_leng = isset($page) ? $page->leng : 'ES';
$titol_meme = ($meme_widget_leng === 'CAT') ? 'Memes del dia' : 'Memes del día';
$sec_memes  = ($meme_widget_leng === 'CAT') ? 'memes' : 'memes';

$meme_widget_data = FALSE;
$basedades->conectar();
if (!$basedades->error_conexio) {
    $bd_w = $basedades->__get('bd');
    $q    = "SELECT idMeme, img FROM meme
             WHERE dateIn >= DATE_SUB(NOW(), INTERVAL 3 DAY)
             ORDER BY dateIn DESC LIMIT 1";
    $res  = $bd_w->query($q);
    if ($res && $res->num_rows === 1) {
        $meme_widget_data = $res->fetch_assoc();
    }
}
$basedades->desconectar();
?>
<style>
.meme-widget {
    margin-bottom: 14px;
    border-bottom: 3px solid #600;
    padding-bottom: 10px;
}
.meme-widget-title {
    position: relative;
    width: 100%;
    height: 25px;
    clear: both;
    background-color: #600;
    background-image: url(pics/back_large.jpg);
    box-sizing: border-box;
}
.meme-widget-title p {
    text-align: left;
    font-family: "Copperplate Gothic Light", Arial, Helvetica, sans-serif;
    font-size: 15px;
    color: #fff;
    padding-left: 10px;
    margin: 0;
    line-height: 25px;
}
</style>
<div class="meme-widget <?php echo htmlspecialchars($meme_widget_class); ?>">

    <!-- Overlay for enlarge -->
    <div id="meme-widget-overlay" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.88);z-index:9990;align-items:center;justify-content:center;">
        <button id="meme-widget-close" aria-label="Cerrar" style="position:absolute;top:18px;right:24px;background:none;border:none;color:#fff;font-size:32px;cursor:pointer;line-height:1;">&#10005;</button>
        <img id="meme-widget-overlay-img" src="" alt="Meme" style="max-width:90vw;max-height:90vh;border-radius:4px;" />
    </div>
    <script>
    (function(){
        if (window._memeWidgetOverlayInit) return;
        window._memeWidgetOverlayInit = true;
        var ov  = document.getElementById('meme-widget-overlay');
        var img = document.getElementById('meme-widget-overlay-img');
        document.getElementById('meme-widget-close').addEventListener('click', function(){ ov.style.display='none'; });
        ov.addEventListener('click', function(e){ if(e.target===ov) ov.style.display='none'; });
        document.addEventListener('keydown', function(e){ if(e.key==='Escape') ov.style.display='none'; });
        window.openMemeWidgetOverlay = function(src){ img.src=src; ov.style.display='flex'; };
    })();
    </script>

    <div class="meme-widget-title">
        <p>
            <a class="men" href="index.php?ln=<?php echo $meme_widget_leng; ?>&sec=<?php echo $sec_memes; ?>">
                <?php echo htmlspecialchars($titol_meme); ?>
            </a>
        </p>
    </div>

    <?php if ($meme_widget_data !== FALSE): ?>
    <div style="text-align:center;margin:8px 0;">
        <img src="<?php echo htmlspecialchars($meme_widget_data['img']); ?>"
             alt="Meme del día"
             style="max-width:100%;height:auto;cursor:pointer;border-radius:3px;"
             onclick="openMemeWidgetOverlay('<?php echo htmlspecialchars($meme_widget_data['img']); ?>')" />
    </div>
    <?php endif; ?>

</div>
