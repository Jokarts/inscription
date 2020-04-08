<ul class="menuHead">
	<li><h4>Redirection Vers les pages</h4></li>	
	<li><a href="index.php">Acceuil</a></li>
	<li><a href="connexion.php">Connexion</a></li>
	<li><a href="compte.php">Compte</a></li>	
<?php		
	if(isset($_SESSION["connect"])) :
	?>
	<li><a href="fonctions/deconnexion.php">se déconnecter</a></li>
	<?php 
	else :
	?>
	<li><a href="connexion.php">se connecter</a></li>
	<?php 
	endif;
?>
</ul>