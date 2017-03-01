<?php 
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RightSwatch</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" type="image/png" href="img/favicon.png" />
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script type='text/javascript' src='js/jquery.mousewheel.min.js'></script>
		<script type="text/javascript">
			function message() {
			   $.ajax({
			      type: "GET",
			      url: "messages.php"
			   }).done(function (html) {
			      $('#timeline').html(html); // Retourne dans #messages le contenu de ta page
			      setTimeout(message, 5000);
			   });
			}      
			message();
		</script>
		<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-92815217-1', 'auto');
			  ga('send', 'pageview');
		</script>

	</head>
	<body>
		<div id="container">
			<header>
				<nav>
					<ul>	<h1 id="rightswatch"><a id="lien-principal" href="index.php">RightSwatch</a></h1>
						<?php  if(!isset($_SESSION["auth"])): ?>
						<li><a href="index.php">Qu'est ce que RightSwatch ?</a></li>
						<li><a href="connexion.php">Se connecter</a></li>
						<li><a href="inscription.php">S'inscrire</a></li>
						<li><a href="changelog.php">Nouveautés</a></li>
						<?php else: ?> 
						<li><a href="indexConnecte.php">Timeline Globale</a></li>
						<li><a href="timelineAmis.php">Timeline Amis</a></li>
						<li><a href="visiteProfil.php?user_visit=<?=$_SESSION['auth']->pseudo?>">Mon Profil</a></li>
						<li><a href="profil.php">Modifier le profil</a></li>
						<li><a href="changelog.php">Nouveautés</a></li>
						<li><a href="logout.php">Deconnexion</a></li>
						<?php endif; ?>	

					</ul>
			
				</nav>
				
				
			</header>
	<?php if(isset($_SESSION["flash"])) : ?>
	<?php foreach ($_SESSION["flash"] as $type => $message) : ?>
	<div class="alert alert-<?= $type ?> ">
	<?= $message; ?><a href="<?=$_SERVER['PHP_SELF'] ?>" class="alert_button button_<?=$type ?>">x</a>
	</div>
	<?php endforeach; ?>
	<?php unset($_SESSION["flash"]); ?>
	<?php endif; ?>
