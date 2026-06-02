<?php
/* ---- Memes archive page ---- */

$per_pagina  = 20; /* 4 cols x 5 rows */
$pagina      = isset($_GET['pag']) ? max(1, (int)$_GET['pag']) : 1;
$memes_web   = new ob_memes_web;

$basedades->conectar();
if (!$basedades->error_conexio) {
    $memes_web->extreure_memes_per_pagina($basedades->bd, $pagina, $per_pagina);
    $basedades->desconectar();
}

$titol = ($page->leng === 'CAT') ? 'Memes del dia' : 'Memes del día';
$total_pagines = ($memes_web->total > 0) ? (int)ceil($memes_web->total / $per_pagina) : 1;
?>

<!-- Meme overlay -->
<div id="meme-overlay" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.88);z-index:9990;align-items:center;justify-content:center;">
    <button id="meme-overlay-close" aria-label="Cerrar" style="position:absolute;top:18px;right:24px;background:none;border:none;color:#fff;font-size:32px;cursor:pointer;line-height:1;">&#10005;</button>
    <img id="meme-overlay-img" src="" alt="Meme" style="max-width:90vw;max-height:90vh;border-radius:4px;" />
</div>
<script>
(function(){
    var overlay = document.getElementById('meme-overlay');
    var overlayImg = document.getElementById('meme-overlay-img');
    document.getElementById('meme-overlay-close').addEventListener('click', function(){ overlay.style.display='none'; });
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.style.display='none'; });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') overlay.style.display='none'; });
    window.openMemeOverlay = function(src){ overlayImg.src=src; overlay.style.display='flex'; };
})();
</script>

<div class="titdiscos">
    <p><span class="men"><?php echo htmlspecialchars($titol); ?></span></p>
</div>

<?php if (empty($memes_web->memes)): ?>
    <p class="p_noticia_index" style="padding:20px 0;">
        <?php echo ($page->leng === 'CAT') ? 'Encara no hi ha memes.' : 'Todavía no hay memes.'; ?>
    </p>
<?php else: ?>

<div class="memes-grid">
    <?php foreach ($memes_web->memes as $meme): ?>
    <div class="meme-cell">
        <img src="<?php echo htmlspecialchars($meme['img']); ?>"
             alt="Meme"
             class="meme-thumb"
             onclick="openMemeOverlay('<?php echo htmlspecialchars($meme['img']); ?>')" />
        <div class="meme-meta">
            <span class="meme-author"><?php echo !empty($meme['author']) ? htmlspecialchars($meme['author']) : ''; ?></span>
            <span class="meme-date"><?php echo date('d/m/Y', strtotime($meme['dateIn'])); ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<div class="navegador" style="margin-top:20px;">
    <?php if ($pagina > 1): ?>
        <a class="linkk" href="index.php?ln=<?php echo $page->leng; ?>&sec=memes&pag=<?php echo $pagina - 1; ?>">
            <img class="ico_navegador" src="pics/containers/prev.jpg" width="43" height="43" />
        </a>
    <?php endif; ?>
    <?php if ($pagina < $total_pagines): ?>
        <a class="linkk" href="index.php?ln=<?php echo $page->leng; ?>&sec=memes&pag=<?php echo $pagina + 1; ?>">
            <img class="ico_navegador" src="pics/containers/next.jpg" width="43" height="43" />
        </a>
        <p style="display:inline;margin-left:12px;">
            <a class="men" href="index.php?ln=<?php echo $page->leng; ?>&sec=memes&pag=<?php echo $pagina + 1; ?>">
                <?php echo ($page->leng === 'CAT') ? 'Més' : 'Más'; ?> &rsaquo;
            </a>
        </p>
    <?php endif; ?>
</div>

<style>
.memes-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin: 16px 0;
}
.meme-cell img.meme-thumb {
    width: 100%;
    height: auto;
    display: block;
    cursor: pointer;
    border-radius: 3px;
    transition: opacity 0.15s;
}
.meme-cell img.meme-thumb:hover {
    opacity: 0.82;
}
.meme-meta {
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: #aaa;
    margin-top: 2px;
}
.meme-author { text-align: left; }
.meme-date   { text-align: right; }
</style>

<?php endif; ?>
