<div class='jumbotron pageTitle'>
	<div class="topmenu">
<?php
	if (!ISSET($_SESSION)) session_start();
	if (ISSET($_SESSION["connecte"]))
	{
		require_once('./modele/classes/Utilisateur.class.php');
		echo $_SESSION["connecte"]->getPrenom().
		" ".$_SESSION["connecte"]->getNom()."<br />"; ?>
		<a href="?action=">Accueil</a><br />
		<a href="?action=logout">Se déconnecter</a>

	<?php }	else { ?>

		D&eacute;connect&eacute;<br />
		<a href="?action=login">Se connecter</a><br />
		<a href="?action=ajouter&content=compte">Cr&eacute;er un compte</a>

	<?php } ?>

	</div>
	<a href='index.php' style='color:black'><h2>ExamDay</h2></a>
</div>
