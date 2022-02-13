<?php

// boite_outils.php contient du code qui permet de g�rer l'identification de 
// mani�re automatique.
// Si l'utilisateur n'est pas connect�, une page d'identification 
// est envoy�e � la place de la page normale.
// Une fois l'utilisateur identifi�, il sera envoy� sur la page qu'il a 
// demand� � l'origine.

// IMPORTANT:
// Une fois le login v�rifi�, il est stock� dans la variable $login.
// Cette variable sera tr�s souvent utilis�e car elle permet de savoir quel 
// est l'utilisateur courant.
// Rmq: pour pouvoir utiliser cette variable dans la d�finition d'une fonction,
// il faut d�clarer global $login;


// De plus, boite_outils.php d�finit les fonctions suivantes:


// sauve_photo($nom_param)
//
// Permet de sauvegarder sur le disque du serveur un fichier envoy�.
// La fonction renvoie le nom (relatif � la page d'accueil) du fichier
// qui est typiquement stock� dans la base.
// Si le fichier n'a pas pu �tre sauv�, la fonction renvoie null, ce qui
// permet de tester si le fichier a bien �t� sauv�.
// L'argument $nom_param est le nom du param�tre sp�cifi� dans le formulaire
// pour envoyer la photo.
// Voir ajoute_photo.php pour un exemple d'utilisation


// input_date($nomChamp,$nomForm,$valeur)
//
// G�n�re un composant input pour saisir une date, avec un bouton faisant
// appara�tre un petit calendrier.
// Utiliser cette fonction n�cessite d'avoir ajout� dans la partie <head>
// du document g�n�r� le code suivant:
// <script  type="text/javascript" language="JavaScript" src="fonctions.js"> </script>
// L'argument $nomChamp est le nom du param�tre utilis� pour envoyer la date.
// L'argument $nomForm est le nom du formulaire 
//   (attribut name="..." dans la balise <form>).
// L'argument $valeur est optionnel et pr�cise �ventuellement une valeur de 
// d�part pour la date (fonctionnalit� identique � celle de l'attribut 
// value="..." dans un composant <input type="text" ...>)
// Voir index.php et modifie_photo.php pour des exemples d'utilisation.


// verifie_date($date)
//
// V�rifie que $date est une cha�ne de caract�res pouvant �tre utilis�e
// pour sp�cifier une valeur de date dans le SGBD.
// Renvoie une cha�ne de caract�res avec correctement form�e correspondant � 
// la date pass�e en argument, ou, � d�faut, une cha�ne qui correspond � la 
// date du jour.


//////////////////////////////////////////////////////////////////////////////
// D�but du code des fonctionnalit�s de la bo�te � outils
//////////////////////////////////////////////////////////////////////////////


// Le fichier inclus le fichier valeurs.php qui contient un certain nombre de 
// d�finitions de variables, en particuliers les valeurs n�cessaires 
// � la connection � la base de donn�es.
include('../app/configs/valeurs.php');
include('../app/configs/config.php');

// On utilise syst�matiquement une session

// fonction �tablissant une connexion � la bd
function connexion_bd() {
	global $bd_machine, $bd_port, $bd_login, $bd_password, $bd_base;
	$connect = mysqli_connect("$bd_machine:$bd_port",$bd_login,$bd_password)
		or die('Echec de connection au SGBD: '.mysqli_error($connect));
	mysqli_select_db($connect,$bd_base)
		or die('Echec de s�lection de la base: '.mysqli_error($connect));
	return $connect;
}

// fonction affichant un formulaire permettant de saisir un login et 
// un mot de passe avant de rediriger l'utilisateur vers la page choisie
function formulaire_login($message='') {
	$action = $_SERVER['REQUEST_URI'];
	?>
<html>
	<head><title>Saisie des identifiants</title></head>
    <body>
   		<?php 
   		if ($message) {
     		print $message;
	    }
		print "<form action='$action' method='POST'>\n";
		?> 
      <p>Connexion au site:</p>
      <table>
	      <tr>
	        <td>Identifiant:</td>
	        <td><input type="text" name="login" size="32" maxlength="128"></td>
	      </tr>
	      <tr>
	        <td>Mot de passe:</td>
	        <td><input type="password" name="password" size="32" maxlength="32"></td>
	      </tr>
	      <tr><td colspan="2" align="center">
	        <input type="submit" value="Se connecter">
	        <input type="reset" value="Effacer">
	      </td></tr>
      </table>
    </form>
    <hr>
    <p><a href="inscription.html">S'inscrire</a></p>
  </body>
</html>
    <?php
    exit;
}

// fonction v�rifiant un login et un mot de passe
function verifie_login($login,$passwd) {
	$connect = connexion_bd();
	$requete = "SELECT * FROM utilisateur WHERE login='$login' AND password='$passwd'";
	$resultat = mysqli_query($connect,$requete)
	  or die("Erreur lors de l'ex�cution de la requ�te: ".mysqli_error($connect));
	// si le r�sultat n'est pas vide
	if ($ligne = mysqli_fetch_assoc($resultat)) {
		$login_ok = true;
	} else {
		$login_ok = false;
	}
	mysqli_close($connect);
	return $login_ok;
}

$login='';

// Fonction qui verifie si le login et le mot de passe ont
// bien �t� saisis et qui dans le cas contraire affiche une 
// page de connection
// Assigne �galement la valeur des variables qui d�pendent 
// de la session
function login_ou_reconnection() {
	global $login;
	if (isset($_SESSION['login'])) {
		$login = $_SESSION['login'];
	} else if (isset($_POST['login']) && isset($_POST['password'])) {
		$login = $_POST['login'];
		if (verifie_login($login,$_POST['password'])) {
			$_SESSION['login'] = $login;	
		} else {
			formulaire_login("<h3>Erreur d'identification</h3>\n".
							 "<p>Veuillez saisir � nouveau vos identifiants</p>");
		}
	} else {
		formulaire_login();
	}
}


function detruire_session()
{
	// On ecrase le tableau de session
	$_SESSION = array();

	// On detruit la session
	session_write_close();
}

function deconnexion() {
	detruire_session();	
}

function charger_page($page)
{	
	echo "<script language=JavaScript>
				 <!-- Hide from JavaScript-Impaired Browsers
 				 parent.location=\"" . $page . "\"
				 // End Hiding -->
				 </script>";
}
	
function genere_nom_fichier($nom_depart) {
	if (file_exists($nom_depart)) {
		$ppos = strrpos($nom_depart,'.');
		$ext = substr($nom_depart,$ppos);
		$prefix = substr($nom_depart,0,$ppos);
		$i=0;
		while(file_exists("$prefix$i$ext")) {
			$i++;
		}
		return $prefix.$i.$ext;
	} else {
		return $nom_depart;
	}
}
	
function sauve_photo($param_fichier) {
	global $login;
	if ($param_fichier == null) {
		die("Il faut sp�cifier le nom du param�tre dans ".
		    "lequel est stock�e la photo � la fonction sauve_photo !!!");
	}	
	
	if ($_FILES[$param_fichier]['error']) {
		switch ($_FILES[$param_fichier]['error']){
	    case UPLOAD_ERR_INI_SIZE:
           	print "Le fichier depasse la limite autorisee par le serveur (fichier php.ini).";
           	break;
        case UPLOAD_ERR_FORM_SIZE:
           	print "Le fichier depasse la limite autorisee dans le formulaire HTML.";
           	break;
        case UPLOAD_ERR_PARTIAL:
           	print "L'envoi du fichier a ete interrompu pendant le transfert.";
          	break;
        case UPLOAD_ERR_NO_FILE:
           	print "Le fichier que vous avez envoye a une taille nulle.";
         	break;
	 	case UPLOAD_ERR_NO_TMP_DIR:
	 		print "Pas de repertoire temporaire defini.";
	 		break;
	 	case UPLOAD_ERR_CANT_WRITE:
	 		print "Ecriture du fichier impossible.";
	 	default:
			print "Erreur inconnue.";
		}
		return null;
	}
	else {
	 	// $_FILES[$param_fichier]['error'] vaut 0 soit UPLOAD_ERR_OK
	 	// ce qui signifie qu'il n'y a eu aucune erreur
	 	$chemin_destination = APPROOT.'\photos\\'.rawurlencode($login);
        // echo $chemin_destination;
        if (!file_exists($chemin_destination)) {
            mkdir($chemin_destination);
        }
	 	$chemin_destination = $chemin_destination.'\\';
	 	$urlphoto=$chemin_destination.$_FILES[$param_fichier]['name'];
	 			$urlphoto=genere_nom_fichier($urlphoto);
	 	move_uploaded_file($_FILES[$param_fichier]['tmp_name'],$urlphoto);
	 	return $urlphoto;
	}
}


function input_date($nomChamp,$nomForm,$valeur='') 
{
  echo "<input type=\"Text\" name=\"$nomChamp\" value=\"$valeur\" size=\"20\">";
  echo "<a href=\"javascript:cal$nomChamp.popup();\"><img src=\"img/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Cliquez ici pour obtenir la date.\"></a>\n";
  echo "<script language=\"JavaScript\">\n";
  echo "var cal$nomChamp = new calendar1(document.forms['$nomForm'].elements['$nomChamp']);\n";
  echo "cal$nomChamp.year_scroll = true;\n";
  echo "cal$nomChamp.time_comp = false;\n";
  echo "</script>\n";
  return 0;
}
	
// on verifie que l'on a bien une date correcte
// et dans le bon format
// sinon on tente de la convertir
// ou bien on met la date courante � la place
// renvoie la date bien format�e
// !!! ne g�re pas bien les date d'avant 1970
function verifie_date($date) {
	$timestamp = strtotime($date);
	if ($timestamp && $timestamp != -1) {
		return date('Y-m-d',$timestamp);
	} else {
		return date('Y-m-d');
	}
}
	
login_ou_reconnection();

?>