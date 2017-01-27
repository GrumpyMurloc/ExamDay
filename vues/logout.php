<?php
if (!ISSET($_SESSION))
	session_start();
if (ISSET($_SESSION["connecte"])){
	$user = $_SESSION["connecte"];
	if ($user->getType == "Etudiant")
		header("Location: ./?action=dashboard");
}
?>
<html>
<head>
<?php include_once("./vues/subvues/head.php");?>
</head>
<body>
<?php
include_once("./vues/subvues/banner.php");
?>
<div>
	<p> Vous avez &eacute;t&eacute; d&eacute;connect&eacute;.<br />
	<a href='./?action='>Retour &agrave; l'accueil.</a>
<footer>
<?php include_once("./vues/subvues/footer.php");?>
</footer>
</body>
</html>
<!-- -->
