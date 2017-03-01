<?php
	require_once 'inc/db.php';
	require_once "inc/function.php";
	user_only();
	$req2 = $pdo->prepare('SELECT * FROM AMIS WHERE pseudo = ? ORDER BY id');
	$donnees2 = $req2->execute([$_SESSION["auth"]->pseudo]);
	$donnees2 = $req2->fetchall();
	$req = $pdo->query('SELECT * FROM TIMELINE ORDER BY id DESC');
	$donnees = $req->fetchall();

	?>
	
	<?php for ($i=0; $i <count($donnees) ; $i++) { 
		for($j=0; $j < count($donnees2); $j++){
			if($donnees[$i]->pseudo == $donnees2[$j]->pseudo_ami){?>
	<div id="message">
		
	<div id="pseudo">
	<?php echo "<a id='lien_profil' href='visiteProfil.php?user_visit=".$donnees[$i]->pseudo."''>".$donnees[$i]->pseudo."</a>"; ?>
	<?php
		if(!empty($donnees[$i]->photo)){
			echo "<img id='photo_profil_message' src='upload/".$donnees[$i]->photo."'>";
		}else{
			echo "<img id='photo_profil_message' src='img/avatar.png'>";
		}?>
	</div>

	<?php if(strlen($donnees[$i]->message) < 1000){ ?>
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
<?php 		}
	}
	} ?>