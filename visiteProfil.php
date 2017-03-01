<?php
	session_start();
	require_once 'inc/function.php';
	user_only();
	if(isset($_GET["user_visit"])){
		$user_visit = $_GET["user_visit"];
		require_once 'inc/db.php';
		$req = $pdo->prepare('SELECT * FROM USERS WHERE pseudo = ?');
		$req->execute([$user_visit]);
		$user = $req->fetch();
		require_once 'inc/db.php';
		require_once "inc/function.php";
		$req2 = $pdo->prepare("SELECT * FROM TIMELINE WHERE pseudo = ? ORDER BY id DESC LIMIT 100");
		$req2->execute([$user->pseudo]);
		$donnees = $req2->fetchall();
		if(!$user){
			$_SESSION["flash"]["danger"] = "Cette utilisateur n'existe pas";
			header('location: indexConnecte.php');
			exit();
		}
	}else{
		header('location: indexConnecte.php');
		exit();
	}
?>
<?php require 'inc/header_visit.php';?>

			
			<div id="container4">
				
				<div id="profil">
				<?php if($user->niveau_xp < 10) { ?>
				<div id="profil_head">
				<?php }else{ ?>
				<div id="profil_head_10">
				<?php } ?>


				<?php
			if(!empty($user->photo)){
				echo "<img id='photo_profil' src='upload/".$user->photo."'>";
			}else{
				echo "<img id='photo_profil' src='img/avatar.png'>";
			}?>
				
					<div id="profil_texte">
						<h3><?php echo $user->prenom ?></h3>
						<h4><?php echo $user->nom ?></h4>
					</div>

					<?php if($user->niveau_xp < 10) { ?>

					<div id="ageDIV">
						<h2 id="age"><?php if($user->age != 0){
							echo ($user->age)." ans";
						}
						?></h2>
					</div>

					<?php }else{ ?>

					<div id="ageDIV_10">
						<h2 id="age_10"><?php if($user->age != 0){
							echo ($user->age)." ans";
						}
						?></h2>
					</div>

					<?php } ?>
				</div>
				<div id="profil_corps">
				<?php if($user->niveau_xp < 10) { ?>

					<?php if(isset($user->bio)){
						if(strlen($user->bio) <300){
							echo '<div id="description">';
							echo '<p id="bio">';
							echo ($user->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long">';
							echo '<p id="bio">';
							echo ($user->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter white">';
					echo '<span style="width: '.$user->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau">';
					echo '<p>Niveau '.$user->niveau_xp.'</p>';
					echo '</div>';
				?>
				<?php }else{ ?>

					<?php if(isset($user->bio)){
						if(strlen($user->bio) <300){
							echo '<div id="description_10">';
							echo '<p id="bio">';
							echo ($user->bio);
							echo '</p>';
							echo '</div>';
						}else{
							echo '<div id="description_long_10">';
							echo '<p id="bio">';
							echo ($user->bio);
							echo '</p>';
							echo '</div>';
						}
					} ?>
					<?php
					echo '<div class="meter_10 indigo">';
					echo '<span style="width: '.$user->xp.'%"></span>';
					echo '</div>';
					echo '<div id="niveau_10">';
					echo '<p>Niveau '.$user->niveau_xp.'</p>';
					echo '</div>';
					?>

				<?php } ?>

					<div id="profil_bas">
					<?php
					if($_SESSION["auth"]->pseudo == $user_visit){
						echo "<div id='follow'>Vous</div>";
					}else{
						$req3 = $pdo->prepare("SELECT * FROM AMIS WHERE pseudo = ? ORDER BY id");
						$req3->execute([$_SESSION["auth"]->pseudo]);
						$donnees3 = $req3->fetchall();
						if($donnees3){
							$follow = false;
							for ($i=0; $i <count($donnees3) ; $i++){
								if($donnees3[$i]->pseudo_ami == $user_visit){
									$follow = true;
								}
							}
							if($follow == true){
								echo '<form action="unfollow.php?user_follow='.$user_visit.'" method="post">';
								echo "<button type='submit' id='unfollow_button'>NE PLUS SUIVRE</button>";
								echo "</form>";
							}else{
								echo '<form action="follow.php?user_follow='.$user_visit.'" method="post">';
								echo "<button type='submit' id='follow_button'>Suivre</button>";
								echo "</form>";
							}
						}else{
							echo '<form action="follow.php?user_follow='.$user_visit.'" method="post">';
							echo "<button type='submit' id='follow_button'>Suivre</button>";
							echo "</form>";
						}
						$req4 = $pdo->prepare("SELECT * FROM AMIS WHERE pseudo = ? ORDER BY id");
						$req4->execute([$user_visit]);
						$donnees4 = $req4->fetchall();
						$follow2 = false;
						if($donnees4){
							for ($i=0; $i <count($donnees4) ; $i++){
								if($donnees4[$i]->pseudo_ami == $_SESSION["auth"]->pseudo){
									$follow2 = true;
								}
							}
							
						}
						if($follow2 == true){
							echo "<p id='follow'>Vous suit</p>";
						}else{
							echo "<p id='follow'>Ne vous suis pas</p>";
						}

					}
					
				?>
					</div>

				</div>

					
				</div>
				
					<div id="timeline">
				
						
					<?php for ($i=0; $i <count($donnees) ; $i++) { ?>
					<div id="message">
						
					<div id="pseudo">
					<?php echo "<a id='lien_profil' href='visiteProfil.php?user_visit=".$donnees[$i]->pseudo."''>".$donnees[$i]->pseudo."</a>"; ?>
					</div>
					<?php if(strlen($donnees[$i]->message) < 1195){ ?>
						<div id="messageDIV">
						<?php echo $donnees[$i]->message; ?>
						</div>
						<?php }else{?>
						<div id="messageDIV_count">
						<?php echo $donnees[$i]->message; ?>
						</div>
					<?php } ?>
					<div id="date">
						<span id="date2"><?php echo $donnees[$i]->date2; ?></span>
					</div>
					</div>
				<?php } ?>
				</div>
					
			</div>

<?php require 'inc/footer.php';?>