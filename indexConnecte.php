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
				$req = $pdo->prepare('INSERT INTO TIMELINE SET pseudo = ?, message = ?, date2 = ?, photo = ?');
				$date = date("H:i  d-m-Y");
				$message = htmlspecialchars($_POST["message"]);
				$req->execute([$_SESSION["auth"]->pseudo, $message, $date,  $_SESSION["auth"]->photo]);
				$_SESSION["auth"]->xp = $_SESSION["auth"]->xp + 20;
				$req4 = $pdo->prepare('UPDATE USERS SET xp = ?, niveau_xp = ? WHERE pseudo = ?');
				$req4->execute([$_SESSION["auth"]->xp, $_SESSION["auth"]->niveau_xp, $_SESSION["auth"]->pseudo]);
				header('location: indexConnecte.php');
				exit();
		}
		
	}
?>
<?php require 'inc/header.php';?>
	<div id="container4">
				
				<div id="profil">
				<?php if($_SESSION["auth"]->niveau_xp < 5) { ?>
				<div id="profil_head">
				<?php }elseif($_SESSION["auth"]->niveau_xp < 10){ ?>
				<div id="profil_head_5">
				<?php }elseif($_SESSION["auth"]->niveau_xp < 20){ ?>
				<div id="profil_head_10">
				<?php }elseif($_SESSION["auth"]->niveau_xp < 30){ ?>
				<div id="profil_head_20">
				<?php }else{ ?>
				<div id="profil_head_30">
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
					<?php if($_SESSION["auth"]->niveau_xp < 5) { ?>

					<div id="ageDIV">
						<h2 id="age"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>
					<?php }elseif($_SESSION["auth"]->niveau_xp < 10){ ?>
					<div id="ageDIV_5">
						<h2 id="age_5"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>
					<?php }elseif($_SESSION["auth"]->niveau_xp < 20){ ?>

					<div id="ageDIV_10">
						<h2 id="age_10"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>
					<?php }elseif($_SESSION["auth"]->niveau_xp < 30){ ?>
					<div id="ageDIV_20">
						<h2 id="age_20"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>
					<?php }else{ ?>
					<div id="ageDIV_30">
						<h2 id="age_30"><?php if($_SESSION["auth"]->age != 0){
							echo ($_SESSION["auth"]->age)." ans";
						}
						?></h2>
					</div>
					<?php } ?>
				</div>
				<div id="profil_corps">
				<?php if($_SESSION["auth"]->niveau_xp < 5) { ?>

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
				<?php }elseif($_SESSION["auth"]->niveau_xp < 10){ ?>
				<?php if(isset($_SESSION["auth"]->bio)){
						if(strlen($_SESSION["auth"]->bio) <300){
							echo '<div id="description_5">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long_5">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter_20 jaune">';
					echo '<span style="width: '.$_SESSION["auth"]->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau_5">';
					echo '<p>Niveau '.$_SESSION["auth"]->niveau_xp.'</p>';
					echo '</div>';
					?>
				<?php }elseif($_SESSION["auth"]->niveau_xp < 20){ ?>

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
				<?php }elseif($_SESSION["auth"]->niveau_xp < 30){ ?>
				<?php if(isset($_SESSION["auth"]->bio)){
						if(strlen($_SESSION["auth"]->bio) <300){
							echo '<div id="description_20">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long_20">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter_20 blue">';
					echo '<span style="width: '.$_SESSION["auth"]->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau_20">';
					echo '<p>Niveau '.$_SESSION["auth"]->niveau_xp.'</p>';
					echo '</div>';
					?>
				<?php }else{ ?>
					<?php if(isset($_SESSION["auth"]->bio)){
						if(strlen($_SESSION["auth"]->bio) <300){
							echo '<div id="description_30">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long_30">';
							echo '<p id="bio">';
							echo ($_SESSION["auth"]->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter_30 blue">';
					echo '<span style="width: '.$_SESSION["auth"]->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau_30">';
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