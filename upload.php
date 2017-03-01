<?php
	session_start();
	require_once 'inc/function.php';
	require_once 'inc/db.php';
	user_only();

	$dossier = 'upload/';
	$fichier = basename($_FILES['avatar']['name']);
	$taille_maxi = 100000;
	$taille = filesize($_FILES['avatar']['tmp_name']);
	$extensions = array('.png', '.gif', '.jpg', '.jpeg');
	$extension = strrchr($_FILES['avatar']['name'], '.'); 
	//Début des vérifications de sécurité...
	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
	{
	     $_SESSION["flash"]["danger"] = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
	}
	if($taille>$taille_maxi)
	{
	     $_SESSION["flash"]["danger"] = 'Le fichier est trop gros...';
	}
	if(empty($_SESSION["flash"])) //S'il n'y a pas d'erreur, on upload
	{
	     //On formate le nom du fichier ici...
	     	$fichier = strtr($fichier, 
	          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
	          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	    	 $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
	     	$req = $pdo->prepare('UPDATE USERS SET photo = ? WHERE pseudo = ?');
		$req->execute([$fichier, $_SESSION["auth"]->pseudo]);
		$_SESSION["auth"]->photo = $fichier;
	     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
	     {
		$_SESSION["flash"]["success"] = 'Upload effectué avec succès !';
	     }
	     else //Sinon (la fonction renvoie FALSE).
	     {
		$_SESSION["flash"]["success"] = 'Echec de l\'upload !';
	     }
	}
	header('location: indexConnecte.php');
	exit();	