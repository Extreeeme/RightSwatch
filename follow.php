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
		$req = $pdo->prepare('SELECT * FROM USERS WHERE pseudo = ?');
		$req->execute([$user_follow]);
		$user = $req->fetch();
		if(!$user){
			$_SESSION["flash"]["danger"] = "Cet utilisateur n'existe pas";
			header('location: indexConnecte.php');
			exit();
		}else{
			$req2 = $pdo->prepare('INSERT INTO AMIS SET pseudo = ?, pseudo_ami = ?');
			$req2->execute([$_SESSION["auth"]->pseudo, $user->pseudo]);
			$_SESSION["flash"]["success"] = "Vous suivez cette personne";
			header('location: visiteProfil.php?user_visit='.$user->pseudo);
			exit();
		}
	}

?>