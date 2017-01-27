<?php
include_once('./modele/DAOQuestion.class.php');
include_once('./modele/classes/Question.class.php');
if(!ISSET($_SESSION)) session_start();
?>
<html>
<head>
<?php include('./vues/subvues/head.php') ?>
</head>
<body>
<?php include('./vues/subvues/banner.php') ?>
<div class='divFormulaireBordered'>
<div class='form-group'>
<h3> Cr&eacute;er une question </h3><br />
<form action='./' class=>
<input type='hidden' name='action' value='ajouter'></input>
<input type='hidden' name='content' value='question'></input>

	<label for='titre'>Titre: </label> <br />
	<input type='text' id='titre' name='titre' class='form-control'> </input>
	<label for='enonce'>&Eacute;nonc&eacute;: </label><br />
	<input type='text' id='enonce' name='enonce' class='form-control'></input>
	<input type='hidden' name='type' value='Reponse courte'></input>
	<input type='hidden' name='choix' value='Aucun'></input>
	<label for='reponse'>R&eacute;ponse: </label><br />
	<input type='text' id='reponse' name='reponse' class='form-control'></input>
	<div class='buttonCenterer'>
		<button TYPE="submit" class='btn btn-primary'> Envoyer </button>
	</div>
</form>
</div>
</div>
<footer>
<?php include_once("./vues/subvues/footer.php");?>
</footer>
</body>
</html>