<?php
	if(isset($_GET["id"]) && isset($_GET["token"])){ //SI les éléments sont présents dans le lien
		$user_id = $_GET['id'];	//On les récupère
		$user_token = $_GET["token"];
		require_once 'inc/db.php';	//On inclus la base de données
		$req = $pdo->prepare("SELECT * FROM USERS WHERE id = ?");
		$req->execute([$user_id]);	//On sélectionne dans la base la ligne avec ce pseudo
		$user = $req->fetch();

		if($user && $user->valid_token == $user_token){ //égal à $user["valid_token"]
			$pdo->prepare('UPDATE USERS SET valid_token = NULL, valid_at = NOW() WHERE id = ?')->execute([$user_id]);
			session_start();
			$_SESSION["auth"] = $user;
			$req2 = $pdo->prepare('INSERT INTO TIMELINE SET pseudo = ?, message = ?, date2 = ?');
				$date = date("H:i  d-m-Y");
				$message = $user->pseudo." viens de s'incrire sur RightSwatch";
				$req2->execute([$_SESSION["auth"]->pseudo, $message, $date]);
			$_SESSION["flash"]["success"] = "Votre compte a bien été validé";
			header('location: indexConnecte.php');
			exit();
		}

	}
		
	header('location: index.php');
?>