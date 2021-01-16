// JavaScript Document


enlace = new Array()
enlace[0] = '<a target="_blank" href="http://www.invainmetal.com/"><img src="../pics/banner/banner_iv_800x100.gif" width="700" height="100" /></a>'
enlace[1] = '<a target="_blank" href="http://www.myspace.com/pimeametsa"><img src="../pics/banner/Primea_Metsa700.jpg" width="700" height="100" /></a>'
enlace[2] = '<a target="_blank" href="http://www.myspace.com/perfectsmilees"><img src="../pics/banner/banner_perfect_smile.gif" width="700" height="100" /></a>'
enlace[3] = '<a target="_parent" href="../concurso_drakum.html"><img src="../pics/banner/concursdrakum.gif" width="700" height="100" /></a>'

aleatorio = Math.random() * (enlace.length)
aleatorio = Math.floor(aleatorio)
document.write(enlace[aleatorio])
