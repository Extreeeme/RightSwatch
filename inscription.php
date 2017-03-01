<?php
	session_start();
	require_once 'inc/function.php';
	visitor_only();
	if (!empty($_POST)){
		require_once 'inc/function.php';
		require_once 'inc/db.php';
		if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
			$_SESSION["flash"]["danger"]= "Votre pseudo n'est pas valide (alpha_numerique)";
		}else{
			$req = $pdo->prepare('SELECT id FROM USERS WHERE pseudo = ?');
			$req->execute([$_POST["username"]]);
			$user = $req->fetch();
			if($user){
				$_SESSION["flash"]["danger"]= "Ce pseudo est déjà utilisé";
			}
		}
		if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
			$_SESSION["flash"]["danger"] = "Votre mail n'est pas valide";
		}else{
			$req = $pdo->prepare('SELECT id FROM USERS WHERE mail = ?');
			$req->execute([$_POST["mail"]]);
			$user = $req->fetch();
			if($user){
				$_SESSION["flash"]["danger"] = "Ce mail est déjà utilisé";
			}
		}
		if (empty($_POST['password']) || $_POST["password"] != $_POST["password-confirm"]){
			$_SESSION["flash"]["danger"]= "Les mots de passe ne correspondent pas";
		}
		if ((empty($_POST['prenom']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['prenom'])) || empty($_POST['nom']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['nom'])){
			$_SESSION["flash"]["danger"]= "Nom ou prénom non valide";
		}

		if (empty($_SESSION["flash"])){
			$token = str_random(60);
			$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
			$nom = mb_strtoupper($_POST["nom"]);
			$prenom = ucfirst($_POST["prenom"]);
			$req = $pdo->prepare('INSERT INTO USERS SET pseudo = ?, mail = ?, password = ?, prenom = ?, nom = ?, valid_token = ?, xp = ?, niveau_xp = ?');
			$req->execute([$_POST["username"], $_POST["mail"], $password, $prenom, $nom, $token, 0, 0]);
			$user_id = $pdo->lastInsertId();

			my_mail(
				$_POST["mail"], 
				$_POST["username"], 
				"Confirmation de votre compte", 
				"Mail de confirmation : Merci de cliquer sur le lien pour confirmer votre  compte<br/>\n\n http://martin.coding-moulins.xyz/confirm.php?id=$user_id&token=$token"
				);
			$_SESSION["flash"]["success"] = "Un mail de confirmation vous a été envoyé";
			header('location: connexion.php');
			exit();
		}
		
	}

?>
<?php require 'inc/header_vert.php';?>

			
			<div id="container_connexion">
				<h1 id="inscription_titre">S'INSCRIRE</h1>

				<form action="" method="post" id="formulaire">
					
					<div>
						<input  id="formulaire_pseudo" type="text" name="username" placeholder="Pseudo" />
					</div>	

					<div>
						<input  id="formulaire_pseudo" type="text" name="prenom" placeholder="Prénom" />
					</div>	

					<div>
						<input  id="formulaire_pseudo" type="text" name="nom" placeholder="Nom" />
					</div>	

					<div>
						<input   id="formulaire_pseudo" type="text" name="mail" placeholder="Votre adresse mail" />
					</div>

					<div>	
						<input id="formulaire_password" type="password" name="password" placeholder="Mot de passe" />	
					</div>

					<div>	
						<input  id="formulaire_password" type="password" name="password-confirm" placeholder="Confirmation du mot de passe" />	
					</div>

					<button type="submit" id="connexion_button"><img src="img/inscription.png" alt="" width="100%"></button>

				</form>

				
			</div>

<?php require 'inc/footer.php';?>