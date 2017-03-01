<?php
	session_start();
	require_once 'inc/function.php';
	require_once 'inc/db.php';
	user_only();

	if (!empty($_POST)){
		if (empty($_POST['message'])){
			$_SESSION["flash"]["danger"]= "Message non valide";
		}
		if (empty($_SESSION["flash"])){
			$date_message_now = date("Y-m-d H:i:s");
			$req2 = $pdo->prepare('SELECT * FROM TIMELINE WHERE pseudo= ? AND date_message<NOW()-1000 ORDER BY id DESC LIMIT 1');
			$donnees = $req2->execute([$_SESSION["auth"]->pseudo]);
			$donnees = $req2->fetchall();
			if($donnees){
				$req = $pdo->prepare('INSERT INTO TIMELINE SET pseudo = ?, message = ?, date2 = ?, photo = ?');
				$date = date("H:i  d-m-Y");
				$message = htmlspecialchars($_POST["message"]);
				$req->execute([$_SESSION["auth"]->pseudo, $message, $date,  $_SESSION["auth"]->photo]);
				header('location: timelineAmis.php');
				exit();
			}
		}
		
	}
?>
<?php require 'inc/headerTimeline.php';?>
	<div id="container4">
				
				<div id="profil">
				<?php if($_SESSION["auth"]->niveau_xp < 10) { ?>
				<div id="profil_head">
				<?php }else{ ?>
				<div id="profil_head_10">
				<?php } ?>


				<?php
			if(!empty($_SESSION["auth"]->photo)){
				echo "<img id='photo_profil' src='upload/".$_SESSION["auth"]->photo."'>";
			}else{
				echo "<img id='photo_profil' src='img/avatar.png'>";
			}?>
				
					<div id="profil_texte">
						<h3><?php echo $_SESSION["auth"]->prenom ?></h3>
						<h4><?php echo $_SESSION["auth"]->nom ?></h4>
					</div>

					<?php if($_SESSION["auth"]->niveau_xp < 10) { ?>

					<div id="ageDIV">
						<h2 id="age"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>

					<?php }else{ ?>

					<div id="ageDIV_10">
						<h2 id="age_10"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>

					<?php } ?>
				</div>
				<div id="profil_corps">
				<?php if($_SESSION["auth"]->niveau_xp < 10) { ?>

					<?php if(isset($_SESSION["auth"]->bio)){
						if(strlen($_SESSION["auth"]->bio) <300){
							echo '<div id="description">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter white">';
					echo '<span style="width: '.$_SESSION["auth"]->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau">';
					echo '<p>Niveau '.$_SESSION["auth"]->niveau_xp.'</p>';
					echo '</div>';
				?>
				<?php }else{ ?>

					<?php if(isset($_SESSION["auth"]->bio)){
						if(strlen($_SESSION["auth"]->bio) <300){
							echo '<div id="description_10">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long_10">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter_10 indigo">';
					echo '<span style="width: '.$_SESSION["auth"]->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau_10">';
					echo '<p>Niveau '.$_SESSION["auth"]->niveau_xp.'</p>';
					echo '</div>';
					?>

				<?php } ?>
			

			<form action="" method="post">

				<textarea  id="formulaire_envoi_input" type="text" name="message" placeholder="Écrivez quelque chose" ></textarea>

				<button type="submit" id="envoi_button">Envoyer</button>

			</form>
		</div>

			
		</div>	

		<div id="timeline">
		
		</div>

	</div>

<?php require 'inc/footer.php';?>