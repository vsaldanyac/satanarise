//Overlap Image Viewer (March 2nd, 08'): By JavaScript Kit: http://www.javascriptkit.com

var overlapviewer={

	thumbclass: "jkimagelarge", //Shared css class name to apply efect to
	startopacity: 1, //Opacity of element before mouse moves over it
	endopacity: 0.5, //Opacity of element when mouse is over it (and showing enlarged image)
	increment: 0.1, //Amount of opacity to increase after each iteration (suggestion: 0.1 or 0.2)
	loadingmsg: "Loading Image. Please Wait...",

	isContained:function(m, e){
		var e=window.event || e
		var c=e.relatedTarget || ((e.type=="mouseover")? e.fromElement : e.toElement)
		while (c && c!=m)try {c=c.parentNode} catch(e){c=m}
		if (c==m)
			return true
		else
			return false
	},

	dim_and_reveal:function(e, t, config){
		var windowsize={w: $(window).width(), h: $(window).height()}
		var scrollpoint={x: e.pageX-e.clientX, y: e.pageY-e.clientY}
		$(t).fadeTo('normal', overlapviewer.endopacity, function(){
			config.$popupdiv.html('<img id="jkpopupimage" src="'+t.getAttribute('targetimage')+'" border="0" />')
			var isimglink=t.childNodes.length==1 && t.firstChild.tagName=="IMG" //see if anchor object is image link
			var $target=(isimglink)? $(t.firstChild) : $(t)
			var targetcoord=$target.offset()
			$('#jkpopupimage').one('load', function(){
				var popupdiv=config.$popupdiv.get(0)
				targetcoord.left=(windowsize.w < targetcoord.left-scrollpoint.x+popupdiv.offsetWidth)? targetcoord.left-popupdiv.offsetWidth+$target.width() : targetcoord.left
				config.$popupdiv.css({left: targetcoord.left, top: targetcoord.top, visibility: 'visible'})
			})
		})
	},

	undim_and_hide:function(e, t, config){
		$(t).fadeTo('normal', overlapviewer.startopacity)
		config.$popupdiv.empty().css({left:0, top:0, visibility: 'hidden'})
	},

	init:function(config){
		$(document).ready(function(){
			config.$thumbnails=$('.'+overlapviewer.thumbclass)
			config.$popupdiv=$('<div id="overlappopup"></div>').prependTo('body')
			config.$thumbnails.each(function(index){
				$(this).attr('targetimage', this.getAttribute('title')).attr('title', '') //save url to enlarged image in custom 'targetimage' attribute
				$(this).bind('mouseenter', function(e){
					if (!overlapviewer.isContained(config.$popupdiv.get(0), e)) //check if mouse accidently entered pop up div
						overlapviewer.dim_and_reveal(e, this, config)
				})
				$(this).bind('mouseleave', function(e){
					if (!overlapviewer.isContained(config.$popupdiv.get(0), e))  //check if mouse accidently entered pop up div
						overlapviewer.undim_and_hide(e, this, config)
				})
			}) //end each loop
			config.$popupdiv.bind('mouseleave', function(e){
				config.$thumbnails.stop().fadeTo('normal', overlapviewer.startopacity)
				config.$popupdiv.empty().css({left:0, top:0, visibility: 'hidden'})
			})
		}) //end document.ready
	}
}

overlapviewer.init({})