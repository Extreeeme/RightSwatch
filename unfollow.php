<?php
	session_start();
	require_once 'inc/function.php';
	user_only();
	if(!isset($_GET["user_follow"])){
		$_SESSION["flash"]["danger"] = "Cet utilisateur n'existe pas";
		header('location: indexConnecte.php');
		exit();
	}else{
		require_once 'inc/db.php';
		$user_follow = $_GET["user_follow"];
		$req = $pdo->prepare('DELETE FROM AMIS WHERE pseudo = ? AND pseudo_ami = ?');
		$req->execute([$_SESSION["auth"]->pseudo, $user_follow]);
		$_SESSION["flash"]["success"] = "Vous ne suivez plus cette personne";
		header('location: visiteProfil.php?user_visit='.$user_follow);
		exit();
	}

?>