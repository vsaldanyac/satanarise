// JavaScript Document

	/*
	    Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
	    bajo los términos de la Licencia Pública General GNU publicada 
	    por la Fundación para el Software Libre, ya sea la versión 3 
	    de la Licencia, o (a su elección) cualquier versión posterior.
 
	*/
	//funció de validació de formulari
 
	function valida_form(){ 
		//validació del nom
		if (document.formulari.nom.value.length==0){
			alert("¡Debes escribir tu nombre!");
			document.formulari.nom.style.border = "1px solid red";
			return false;
	   	}else{
			document.formulari.nom.style.border = "1px solid #FFF";
		}
		//validació del cognom
		if (document.formulari.cognoms.value.length==0){
			alert("¡Debes escribir tus apellidos! ");
			document.formulari.cognoms.style.border = "1px solid red";
			return false;
	  	}else{
			document.formulari.cognoms.style.border = "1px solid #FFF";
		}
		//validació del mail
		if ((document.formulari.email.value.indexOf ('@', 0) == -1)||(document.formulari.email.value.length < 5)) {
			alert("Debes escribir un e-mail váido /n Por ejemplo: nom@domini.cat");
			document.formulari.email.style.border = "1px solid red";
			return  false;
		}else{
			document.formulari.email.style.border = "1px solid #FFF";
		}
		//validació del missatge a enviar
		//if (document.formulari.consulta.value.length==0){
		//	alert("Has d'escriure un missatge en el camp consulta");
		//	document.folmulari.consulta.style.border = "2px solid red";
		//	return false;
	   	//}else{
		//	document.formulari.consulta.style.border = "2px solid #90FF00";
		//}
	
		//en cas de que tot sigui correcte retorna true

		return true;
	}
	
	//funcio que avisa quan se surt del formulari i hi ha camps amb text.
	function adeu() {
		if (document.formulari.nom.value.length > 0 || document.formulari.cognoms.value.length > 0 || document.formulari.email.value.length > 0) {
			alert("Alerta ! Estàs sortint de la pàgina amb dades al formulari i es perdran les dades !");
		}
	}
	//Funció de descripció de camp del formulari de contacte
	function posarDescripcio(text){  
		document.getElementById("descripcio").innerHTML = text;
	}	    
	function borrarDescripcio(){  
	    document.getElementById("descripcio").innerHTML = "";  
	}
	// Nom
		function posarDescripcioNom(text){  
		document.getElementById("descripcioNom").innerHTML = text;
	}	    
	function borrarDescripcioNom(){  
	    document.getElementById("descripcioNom").innerHTML = "";  
	} 
		// Cognom
		function posarDescripcioCognom(text){  
		document.getElementById("descripcioCognom").innerHTML = text;
	}	    
	function borrarDescripcioCognom(){  
	    document.getElementById("descripcioCognom").innerHTML = "";  
	} 
			// Mail
		function posarDescripcioMail(text){  
		document.getElementById("descripcioMail").innerHTML = text;
	}	    
	function borrarDescripcioMail(){  
	    document.getElementById("descripcioMail").innerHTML = "";  
	}
	function posarDescripcioEnkesta(text){  
		document.getElementById("descripcioEnkesta").innerHTML = text;
	}	    
	function borrarDescripcioEnkesta(){  
	    document.getElementById("descripcioEnkesta").innerHTML = "";  
	}
			// Texte
		function posarDescripcioTexte(text){  
		document.getElementById("descripcioTexte").innerHTML = text;
	}	    
	function borrarDescripcioTexte(){  
	    document.getElementById("descripcioTexte").innerHTML = "";  
	} 

	
	/* segon disc eden */
		// Nom
		function posarDescripcioNom1(text){  
		document.getElementById("descripcioNom1").innerHTML = text;
	}	    
	function borrarDescripcioNom1(){  
	    document.getElementById("descripcioNom1").innerHTML = "";  
	} 
		// Cognom
	function posarDescripcioCognom1(text){  
		document.getElementById("descripcioCognom1").innerHTML = text;
	}	    
	function borrarDescripcioCognom1(){  
	    document.getElementById("descripcioCognom1").innerHTML = "";  
	} 	
			// Mail
		function posarDescripcioMail1(text){  
		document.getElementById("descripcioMail1").innerHTML = text;
	}	    
	function borrarDescripcioMail1(){  
	    document.getElementById("descripcioMail1").innerHTML = "";	
	}
	function posarDescripcioEnkesta1(text){  
		document.getElementById("descripcioEnkesta1").innerHTML = text;
	}	    
	function borrarDescripcioEnkesta1(){  
	    document.getElementById("descripcioEnkesta1").innerHTML = "";  
	}	
			// Texte
		function posarDescripcioTexte1(text){  
		document.getElementById("descripcioTexte1").innerHTML = text;
	}	    
	function borrarDescripcioTexte1(){  
	    document.getElementById("descripcioTexte1").innerHTML = "";  
	} 	
	
	/* tercer disc eden */
		// Nom
		function posarDescripcioNom2(text){  
		document.getElementById("descripcioNom2").innerHTML = text;
	}	    
	function borrarDescripcioNom2(){  
	    document.getElementById("descripcioNom2").innerHTML = "";  
	} 
		// Cognom
	function posarDescripcioCognom2(text){  
		document.getElementById("descripcioCognom2").innerHTML = text;
	}	    
	function borrarDescripcioCognom2(){  
	    document.getElementById("descripcioCognom2").innerHTML = "";  
	} 	
			// Mail
		function posarDescripcioMail2(text){  
		document.getElementById("descripcioMail2").innerHTML = text;
	}	    
	function borrarDescripcioMail2(){  
	    document.getElementById("descripcioMail2").innerHTML = "";	
	}
	function posarDescripcioEnkesta2(text){  
		document.getElementById("descripcioEnkesta2").innerHTML = text;
	}	    
	function borrarDescripcioEnkesta2(){  
	    document.getElementById("descripcioEnkesta2").innerHTML = "";  
	}	
			// Texte
		function posarDescripcioTexte2(text){  
		document.getElementById("descripcioTexte2").innerHTML = text;
	}	    
	function borrarDescripcioTexte2(){  
	    document.getElementById("descripcioTexte2").innerHTML = "";  
	} 	