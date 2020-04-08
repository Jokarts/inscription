<?php
session_start();
include'fonctions/bdd.php';
$bdd=bdd();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title>compte</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="design/style.css">
		<link rel="icon" href="design/browser.ico" />
	</head>
	<body>
	<?php include'menu.php';?>	
		<div class="container">			
			<h1>Mon Compte</h1>			
		</div>
		
		<?php
			if(isset($_SESSION["connect"])):
		?>
		
		<img class="avatar" src="<?= $_SESSION["avatar"] ?>" alt="">
		<p>Bienvenue <?= $_SESSION["pseudo"] ?> !</p>
		<p>rappel: ton email: <?= $_SESSION["email"] ?></p>
		
		<?php 		
			 endif;
		?>
		
	</body>
</html>