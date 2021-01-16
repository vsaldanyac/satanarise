<?php
ob_start(); /* Buffer de sortida on */
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Entrada al Panel de Control de Satan Arise</title>
	<link type="text/css" rel="stylesheet" media="all" href="../css/main_cp.css" />
	</head>
	<body>
	<div id="cont_aut">
	<a class="linkk" href="index_cp.php"><img class="logosatan" src="../pics/containers/logo_cp.jpg" width="1000" height="100" alt="'.$alt.'" /></a>

<?php
require ('../sources/ob_bbdd.php');
session_start();
$bd= new ob_bbdd;
if (!isset($_GET['action']))
{
	if ((isset($_POST['userid'])) && (isset($_POST['password'])))
	{
		/* si s'han omplert les dades per part de l'usuari */
        
        print 'si';
		$userid=$_POST['userid'];
		$password=$_POST['password'];
        print 'Usari: '.$userid.' Pass: '.$password.'.';
		$bd->conectar();        
		$query="select * from users where name='".$userid."' and pass='".sha1($password)."'";
        print $query;       
		$resultat=$bd->bd->query($query);
		if ($resultat->num_rows>0)
		{
			/*si hi ha resultats es que el usuari esta validat correctament*/
			$_SESSION['valid_user']=$userid;
		}
		$bd->desconectar();
		
		
	}
	?>
	<?php
	
	if (isset ($_SESSION['valid_user'])) {
		
		ob_clean();
		header('Location: home_cp.php');
		exit();
	} else {
		if ((isset($userid)) || (isset($password)))
		{
			print '<p class="contingut_aut">El usuario o contraseña no son correctos</p>';
		}
	}
	
	/*Presentem el formulari */
	print '<div id="formulari_aut">';
	print '<form method="post" action="index_cp.php">';
	print '<table class="aut">';
	print '<tr><td><p class="text_form_aut">Usuario:</p></td>';
	print '<td><input type="text" name="userid" /></td></tr>';
	print '<tr><td><p class="text_form_aut">Contraseña:</p></td>';
	print '<td><input type="password" name="password" /></td></tr>';
	print '<tr><td colspan="2" align="center">';
	print '<input type="submit" value="Iniciar sesión" /></td></tr>';
	print '</table>';
	print '</form>';
	print '<div style="text-align:center; margin-top:50px"><a class="linkk" href="index_cp.php?action=olvidada">¿Has olvidado la contraseña?<p class="text_form_aut"></a></p></div>';
	print '</div>';
	?>
	

	<?php
} else {
	/* el usuari ha olvidat la contrassenya */
	if (isset($_POST['userid']))
	{
		/* si s'han omplert les dades per part de l'usuari */
		$userid=$_POST['userid'];
		$punter_bd=$bd->conectar();
		$query="select mail, id_user from users where name='$userid'";
		$resultat=$punter_bd->query($query);
		if ($resultat->num_rows==1)
		{
			/* si l'usuari existeix enviar mail amb una nova pass */
			$row=$resultat->fetch_assoc();
			$email=$row['mail'];
			$id=$row['id_user'];
			/* Generar nueva contraseña */
			require('../sources/generapass.php');
			$new_pass=generaPass();			
			$new_pass_bbdd=sha1($new_pass);
			if (!get_magic_quotes_gpc())
			{				
				$new_pass_bbdd=addslashes($new_pass_bbdd);
			}			
			/* guardarla */			
			$query="update users set pass='$new_pass_bbdd' where id_user='$id'";
			$resultat=$punter_bd->query($query);
			/* enviar mail */
			$subject='NO REPLY: Constraseña del panel de control de Satan Arise:';
			$message="La contrseña del usuario: $userid<br /><br />La nueva contraseña es:  <br /><br />".$new_pass;
			mail($email,$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: web@pareidolian.com\r\nReply-To: $email \r\n");
			print '<p class="contingut_aut">Mail enviado con la nueva contraseña.</p>';
		} else {
			print '<p class="contingut_aut">El usuario o contraseña no son correctos</p>';
		}
		$bd->desconectar();
		
		
	}
	
	if (isset ($_SESSION['valid_user'])) {
		
		ob_clean();
		header('Location: home_cp.php');
		exit();
	}
	/*Presentem el formulari */
	print '<div id="formulari_aut">';
	print '<form method="post" action="index_cp.php?action=olvidada">';
	print '<table class="aut">';
	print '<tr><td><p class="text_form_aut">Usuario:</p></td>';
	print '<td><input type="text" name="userid" /></td></tr>';
	print '<tr><td colspan="2" align="center">';
	print '<input type="submit" value="Recuperar contraseña" /></td></tr>';
	print '</table>';
	print '</form>';
	print '</div>';
	?>
	

	<?php
}
?>
	</div>
	</body>
	</html>
<?php
/* obrir buffer */
ob_end_flush();
?>