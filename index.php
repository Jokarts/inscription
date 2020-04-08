<?php
session_start();
require_once"fonctions/bdd.php";
$bdd = bdd();

//Intégrer l'inscription:
	
		if(!empty($_POST['pseudo']) && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["Cmdp"]) && !empty($_POST["avatar"]) ){	
			
	//intégrer les posts dans des variables:
		$pseudo		= htmlspecialchars($_POST['pseudo']);
		$email		= htmlspecialchars($_POST['email']);
		$mdp		= htmlspecialchars($_POST['mdp']);
		$Cmdp		= htmlspecialchars($_POST['Cmdp']);
		$avatar		= htmlspecialchars($_POST["avatar"]);
	//test si le pseudo est disponible:
		$requete=$bdd->prepare('select count(*) as pseudo from users where pseudo= ?');
		$requete->execute(array($pseudo));
			
		while($pass = $requete->fetch()){			
			
			if($pass["pseudo"] != 0 ){
			
				//sorti *
				header('location: ?error=1&pseudo=1');
				exit();
			} 
		}	
			
	//test si l'email est disponible:
		$requete=$bdd->prepare('select count(*) as email from users where email= ?');
		$requete->execute(array($email));
		while($mail = $requete->fetch()){
						
			if($mail["email"] != 0 ){
				//sorti *
				
				header('location: ?error=1&email=1');
				exit();
			} 
		}
	// test si les mdp. correspondent:
		if($mdp != $Cmdp){
			//sorti *
						
			header('location: ?error=1&pass=1');
			exit();
		}
	//création du key unique pour chaque utilisateur afin qu'il puisse se connecter.
	//explication: sha1 crypte le contenu (), time() ajoute le temps actuel en seconde.
		$secret = sha1($email).time();  
		$secret = sha1($secret).time().time(); 
	//hash du mdp:les valeurs entre "" sont des grains de sel
		$password = "g5p8".sha1($mdp."8p5g")."a9z1e4r2t6";
	//Envoi les post dans la base de données
		$requete = $bdd->prepare('insert into users(pseudo,email,password,secret,avatar)values(?,?,?,?,?)');
		$requete->execute(array($pseudo,$email,$password,$secret,$avatar));
			//sorti *
			header('location: compte.php?sucess=1');
			exit();
		}



?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title>index</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="design/style.css">
		<link rel="icon" href="design/browser.ico" />
	</head>
	<body>
		<?php include'menu.php' ?>

		<div class="container">
			<div class="row">
					<div class="col-md-12">
						<h1>Le formulaire d'inscription</h1>
						<p id="intro">
							 Inscrivez-vous dans la base de données!<br><br>
							Le serveur contrôle si :<br><br>
							-> le pseudo, l'adresse mail existe déja.<br><br>
							-> Le mot de passe correspond au mot de passe de confirmation.<br><br>
							Une fonction hash le mot de passe afin de le masquer dans la base de données. 
							<?= var_dump($bdd); ?>  
						</p>						
					</div>
				</div>			
<!--sorti de verification:
les headers //sorti *  envoient les valeurs dans l'url.
ici on recupere les valeurs dans l'url pour afficher les erreurs ou le succes.-->
<?php if(isset($_GET["error"])){
	 		if(isset($_GET["pass"])){
					echo '<p id="error">'.strtoupper('Les mots de passe ne sont pas identiques!</p>');}
	 		if(isset($_GET["email"])){
					echo '<p id="error">'.strtoupper('Cette Email est deja enregistrer</p>');}
			if(isset($_GET["pseudo"])){
					echo '<p id="error">'.strtoupper('Ce pseudo est deja enregistre!</p>');}
			if(isset($_GET["total"])){
					echo '<p id="error">'.strtoupper('Tous les champs sont obligatoires!</p>');}
		} 
		if(isset($_GET["sucess"])){
		 			echo '<p id="success">'.strtoupper('Sucess: Inscription validee!</p>');	
		}?>			
<!-----/sorti---------------------------------->			
			<form method="post" action="index.php">
				<div class="row">
					<div class="col-md-12">
						<?php		
							if(!isset($_SESSION["connect"])){
						?>
							<table>
								<tr>
									<td class="pseudo">PSEUDO</td><td><input type="text" required name="pseudo" class="pseudo" placeholder="Votre pseudo..*"></td>
								</tr>
								<tr>
									<td class="email" >EMAIL</td><td><input type="email" required name="email" class="email"  placeholder="Votre email..*"></td>
								</tr>
								<tr>
									<td class="mdp" >PASSWORD</td><td><input type="password" required name="mdp" class="mdp" placeholder="Votre password..*" ></td>
								</tr>
								<tr>
									<td class="Cmdp">PASSWORD</td><td><input type="password" required name="Cmdp" class="Cmdp" placeholder="Confirmer votre password..*" ></td>
								</tr>
								<tr>
									<td colspan="2">
										<label for="avatar">Votre avatar***</label>
										<select name="avatar" id="avatar">
											<option value="">--Votre choix--</option>
											<option value="design/homme.png">Homme</option>
											<option value="design/femme.png">Femme</option>
										</select>
									</td>
								</tr>
							</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="buttons">
						<button id="but-ins" type="submit">Inscription!-></button>
					</div>
				</div>
			</form>			
<!--affichage du lien connexion ou déconnexion-->
			<p>Déja inscrit?</p> 
			<a id="lien" href="connexion.php">Connexion</a>
			<?php } else {?>
			<p id="info"> Bonjour <?= $_SESSION['pseudo'] ?></p><br/> <a id="lien"  href="deconnexion.php">Déconnexion</a>
			<?php } ?>
<!--/connexion ou déconnexion--------------------->
		</div>
	</body>
</html>