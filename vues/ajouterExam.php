<?php
include_once('./modele/DAOExamen.class.php');
include_once('./modele/classes/Examen.class.php');
if(!ISSET($_SESSION)) session_start();
$user = $_SESSION["connecte"];
$userid = $user->getID();
?>
<html>
<head>
<?php include('./vues/subvues/head.php') ?>
</head>
<body>
<?php include('./vues/subvues/banner.php') ?>
<div class='divFormulaireBordered'>
<div class='form-group'>
<h3> Cr&eacute;er un examen </h3><br />
<form action='./' class=>
	<input type='hidden' name='action' value='ajouter'></input>
	<input type='hidden' name='content' value='examen'></input>
	<input type='hidden' name='enseignantid' value='<?=$userid ?>'></input>
	<label for='titre'>Titre: </label> <br />
	<input type='text' id='titre' name='titre' class='form-control'> </input> <br />
	<label for='pond'>Pond&eacute;ration: </label><br />
	<input type='text' id='pond' name='ponderation' class='form-control'></input>
	<div class='buttonCenterer'>
		<button TYPE="submit" class='btn btn-primary'> Envoyer </button>
	</div>
</form>
</div>
</div>
</body>
</html>

