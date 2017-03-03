<?php
	if(!empty($_POST["username"]) AND !empty($_POST["password"])){
			require_once 'inc/function.php';
			require_once 'inc/db.php';
			$req = $pdo->prepare('SELECT * FROM USERS WHERE pseudo = :username AND valid_at IS NOT NULL');
			$req->execute([
				"username"=>$_POST["username"]]
				);
			$user = $req->fetch();
			session_start();
			if(!empty($user)){
				$password = $_POST["password"];
				if(password_verify($password, $user->password)){
					$_SESSION["auth"] = $user;
					$_SESSION["auth"]->password = $password;
					$_SESSION["flash"]["success"] = "Vous êtes connecté";
					header("location: indexConnecte.php");
					exit();
				}else{
					$_SESSION ["flash"]["danger"] = "Identifiant ou mot de passe incorrect";
				}
			}else{
				$_SESSION["flash"]["danger"] = "Identifiant ou mot de passe incorrect";
			}

			

	}



?>
<?php require 'inc/header_vert.php';?>

			
			<div id="container_connexion">

			<h1 id="connexion_titre">CONNEXION</h1>
				<form action="" method="post" id="formulaire">
					<div>
						<input id="formulaire_pseudo" type="text" name="username" placeholder="Pseudo" id="pseudo"/>
					</div>

					<div>
						<input  id="formulaire_password" type="password" name="password" placeholder="Mot de passe" id="password"/>
					</div>
					<div>
						<button type="submit" id="connexion_button"><img src="img/lock.png" alt=""></button>
					</div>
				</form>	
			</div>

<?php require 'inc/footer.php';?>