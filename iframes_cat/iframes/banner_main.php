<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate" /> 
<title>Documento sin título</title>
<script type="text/javascript" src="../css/sliderman.1.3.6.js"></script>
<link rel="stylesheet" type="text/css" href="../css/sliderman.css" />
<link type="text/css" rel="stylesheet" media="all" href="../css/iframe.css" />
<link type="text/css" rel="stylesheet" media="all" href="../css/index.css" />
</head>

<body>
<script type="text/javascript">

// Flexible Image Slideshow- By JavaScriptKit.com (http://www.javascriptkit.com)
// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/
// This notice must stay intact for use

var ultimateshow=new Array()

//ultimateshow[x]=["path to image", "OPTIONAL link for image", "OPTIONAL link target"]

ultimateshow[0]=['../pics/banner/vivid.gif', 'http://www.artgatesrecords.com/catalog/product_info.php?products_id=50', '_new']
ultimateshow[1]=['../pics/banner/joserubio.gif', 'http://www.facebook.com/joserubionovaera', '_new']
ultimateshow[2]=['../pics/banner/menzia.jpg', 'http://www.menzia.net', '_new']
ultimateshow[3]=['../pics/banner/banner_amadeus.gif', 'http://www.amadeustheband.com/', '_new']
ultimateshow[4]=['../pics/banner/helloween_pentagram.gif', 'http://www.rrspromo.com/indexcast.php', '_new']

//configure the below 3 variables to set the dimension/background color of the slideshow

var slidewidth="700px" //set to width of LARGEST image in your slideshow
var slideheight="100px" //set to height of LARGEST iamge in your slideshow
var slidecycles="continuous" //number of cycles before slideshow stops (ie: "2" or "continous")
var randomorder="yes" //randomize the order in which images are displayed? "yes" or "no"
var preloadimages="yes" //preload images? "yes" or "no"
var slidebgcolor='black'

//configure the below variable to determine the delay between image rotations (in miliseconds)
var slidedelay=10000

////Do not edit pass this line////////////////

var ie=document.all
var dom=document.getElementById
var curcycle=0

if (preloadimages=="yes"){
for (i=0;i<ultimateshow.length;i++){
var cacheimage=new Image()
cacheimage.src=ultimateshow[i][0]
}
}

var currentslide=0

function randomize(targetarray){
ultimateshowCopy=new Array()
var the_one
var z=0
while (z<targetarray.length){
the_one=Math.floor(Math.random()*targetarray.length)
if (targetarray[the_one]!="_selected!"){
ultimateshowCopy[z]=targetarray[the_one]
targetarray[the_one]="_selected!"
z++
}
}
}

if (randomorder=="yes")
randomize(ultimateshow)
else
ultimateshowCopy=ultimateshow

function rotateimages(){
curcycle=(currentslide==0)? curcycle+1 : curcycle
ultcontainer='<center>'
if (ultimateshowCopy[currentslide][1]!="")
ultcontainer+='<a href="'+ultimateshowCopy[currentslide][1]+'" target="'+ultimateshowCopy[currentslide][2]+'">'
ultcontainer+='<img src="'+ultimateshowCopy[currentslide][0]+'" border="0">'
if (ultimateshowCopy[currentslide][1]!="")
ultcontainer+='</a>'
ultcontainer+='</center>'
if (ie||dom)
crossrotateobj.innerHTML=ultcontainer
if (currentslide==ultimateshow.length-1) currentslide=0
else currentslide++
if (curcycle==parseInt(slidecycles) && currentslide==0)
return
setTimeout("rotateimages()",slidedelay)
}

if (ie||dom)
document.write('<div id="slidedom" style="width:'+slidewidth+';height:'+slideheight+'; background-color:'+slidebgcolor+'"></div>')

function start_slider(){
crossrotateobj=dom? document.getElementById("slidedom") : document.all.slidedom
rotateimages()
}

if (ie||dom)
window.onload=start_slider

</script>


</body>
</html>
