<?php
	session_start();
	require_once 'inc/function.php';
	user_only();
	
	if (!empty($_POST)){
		require_once 'inc/db.php';
		if (empty($_POST['age']) && empty($_POST['bio']) ){
			$_SESSION["flash"]["danger"]= "Âge ou bio non valide";
		}

		if (empty($_SESSION["flash"])){
			if(!empty($_POST['age']) && empty($_POST["bio"])){
				$age = htmlspecialchars($_POST["age"]);
				if(strlen($age > 99)){
					$_SESSION["flash"]["success"] = "Age non valide";
					header('location: profil.php');
					exit();
				}else{
					$req = $pdo->prepare('UPDATE USERS SET age = ? WHERE pseudo = ?');
					$req->execute([$age, $_SESSION["auth"]->pseudo]);
					$user_id = $pdo->lastInsertId();
					$_SESSION["auth"]->age = $age;
					$_SESSION["flash"]["success"] = "Âge modifié";
					header('location: indexConnecte.php');
					exit();
				}
			}elseif(empty($_POST['age']) && !empty($_POST["bio"])){
				$bio = htmlspecialchars($_POST["bio"]);
				$req = $pdo->prepare('UPDATE USERS SET bio = ? WHERE pseudo = ?');
				$req->execute([$bio, $_SESSION["auth"]->pseudo]);
				$user_id = $pdo->lastInsertId();
				$_SESSION["auth"]->bio = $bio;
				$_SESSION["flash"]["success"] = "Bio modifié";
				header('location: indexConnecte.php');
				exit();
			}else{
				$age = htmlspecialchars($_POST["age"]);
				if(strlen($age > 99)){
					$_SESSION["flash"]["success"] = "Age non valide";
					header('location: profil.php');
					exit();
				}else{
					$bio = htmlspecialchars($_POST["bio"]);
					$req = $pdo->prepare('UPDATE USERS SET bio = ?, age = ? WHERE pseudo = ?');
					$req->execute([$bio, $age, $_SESSION["auth"]->pseudo]);
					$user_id = $pdo->lastInsertId();
					$_SESSION["auth"]->bio = $bio;
					$_SESSION["auth"]->age = $age;
					$_SESSION["flash"]["success"] = "Âge et Bio modifiés";
					header('location: indexConnecte.php');
					exit();
				}
			}
			
			
		}
		
	}

?>
<?php require 'inc/header_vert.php';?>

	<div id="container5">
		<div id="container_connexion-1">
				<h1 id="inscription_titre">Modifier le profil</h1>

				<form action="" method="post" id="formulaire">
					
					<div>
						<input  id="formulaire_pseudo" type="number" name="age" placeholder="Âge" />
					</div>	

					<div>
						<textarea  cols="30" rows="10" id="formulaire_pseudo" type="text" name="bio" placeholder="Bio" ><?php if(!empty($_SESSION["auth"]->bio)){
							echo $_SESSION["auth"]->bio;
						}?>
							
						</textarea>
					</div>

					<button type="submit" id="connexion_button"><img src="img/inscription.png" alt="" width="100%"></button>

				</form>
		</div>
		<div id="container_connexion-2">
				<form  id="formulaire" method="POST" action="upload.php" enctype="multipart/form-data">
					     <!-- On limite le fichier à 100Ko -->
					     <input type="hidden" name="MAX_FILE_SIZE" value="100000">
					    <h1  id="inscription_titre"> Fichier : </h1><input type="file" name="avatar">
					     <input  id="connexion_button_avatar" type="submit" name="envoyer" value="Changer l'avatar">
				</form>

				
		</div>

<?php require 'inc/footer.php';?>