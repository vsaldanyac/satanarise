// JavaScript Document


enlace = new Array()
enlace[0] = '<a target="_blank" href="http://www.myspace.com/humancarnagebcn"><img src="../pics/banner/humancarnage.gif" width="700" height="100" /></a>'
enlace[1] = '<a target="_blank" href="http://www.blacktroll.net"><img src="../pics/banner/banner_troll.jpg" width="700" height="100" /></a>'
enlace[2] = '<a target="_blank" href="http://www.wix.com/sombrasfolk/sombras"><img src="../pics/banner/sombras.gif" width="700" height="100" /></a>'
enlace[3] = '<a target="_blank" href="http://www.doriaoficial.com/" title="Web de Doria"><img src="../pics/banner/banner_doria.gif" width="700" height="100" /></a>'
enlace[4] = '<a target="_blank" href="https://www.facebook.com/wereworld" title="Web de Wereworld"><img src="../pics/banner/banner_wereworld.gif" width="700" height="100" /></a>'
enlace[5] = '<a target="_blank" href="http://www.ankor.es/" title="Ankor"><img src="../pics/banner/ankor.jpg" width="700" height="100" /></a>'
enlace[6] = '<a target="_blank" href="http://www.myspace.com/leviathanmelodicdeath" title="Leviathan"><img src="../pics/banner/leviathan.gif" width="700" height="100" /></a>'


aleatorio = Math.random() * (enlace.length)
aleatorio = Math.floor(aleatorio)
document.write(enlace[aleatorio])
