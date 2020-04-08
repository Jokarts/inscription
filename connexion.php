<?php
session_start();
include'fonctions/bdd.php';
$bdd=bdd();
if(isset($_SESSION['connect'])){
	header('location: compte.php');
}
if(!empty($_POST["email"]) && !empty($_POST['mdp'])){
	//variables
	
	$email = $_POST["email"];
	$password = $_POST["mdp"];
	$error =1;

	//crypter le password avec les memes grains de sel 
	$password = "g5p8".sha1($password."8p5g")."a9z1e4r2t6";

	$requete = $bdd->prepare('select * from users where email = ?');
	$requete->execute(array($email));

	while($user = $requete->fetch()){		
		if($password == $user['password']){
			$error = 0;
			$_SESSION['connect'] = 1;
			$_SESSION['SameSite'] = "secure";
			$_SESSION['pseudo']  = $user['pseudo'];
			$_SESSION['email']  = $user['email'];
			$_SESSION['avatar']  = $user['avatar'];
			$_SESSION['id'] = intval($user["id"]);
			
			
			
			if(isset($_POST['connect'])){				
			    setcookie('log',$user['secret'],time()+365*24*3600, '/', null, false,true);
				header('location: compte.php?success=1');
			}			
			
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title>connexion</title>
		<link rel="icon" href="design/browser.ico" />
		<link rel="stylesheet" type="text/css" href="design/style.css">
	</head>
	<body>
		<?php include'menu.php' ?>
		<div class="container">
			<div class="row">
					<div class="col-md-12">
						<h1>connexion</h1>
						<a href="index.php">Inscription</a>
				</div>
			</div>
			<form method="post" action="connexion.php">
				<div class="row">
					<div class="col-md-12">
						<table>
							<tr>
								<td>EMAIL</td><td><input type="email" name="email" placeholder="Votre email..*" ></td>
							</tr>
							<tr>
								<td>PASSWORD</td><td><input type="password" name="mdp" placeholder="Votre password..*" ></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="buttons">
						<button type="submit">connexion!-></button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
