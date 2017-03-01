<?php 
	session_start();
	session_unset($_SESSION["auth"]);
	$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecté";
	header ("location: index.php");