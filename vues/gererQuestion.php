<?php
include_once('./modele/DAOQuestion.class.php');
include_once('./modele/classes/Question.class.php');
if(!ISSET($_SESSION)) session_start();
$_SESSION["lastView"] = "gererQuestion";
?>
<html>
<head>
<?php include('./vues/subvues/head.php') ?>
</head>
<body>
<?php include('./vues/subvues/banner.php') ?>
<div class='divFormulaireBordered'>
<div class='form-group'>
<h3> G&eacute;rer une question </h3><br />
<form action='./' class=>
<input type='hidden' name='id' value="<?=$_REQUEST['id']?>"></input>
<input type='hidden' name='action' value='gerer'></input>
<input type='hidden' name='content' value='question'></input>
<?php
	$q = DAOQuestion::find($_REQUEST['id']);
	if ($q){
		$questionID=$q->getID();
		$titre = $q->getTitre();
		$enonce = $q->getEnonce();
		$type = $q->getQuestionType();
		$choix = $q->getchoix();
		$reponse = $q->getReponse();
		?>
		<input type='hidden' name='id' value='<?= $questionID ?>'></input>
		<label for='titre'>Titre: </label> <br />
		<input type='text' id='titre' name='titre' class='form-control' value='<?= $titre ?>'> </input>
		<label for='enonce'>&Eacute;nonc&eacute;: </label><br />
		<input type='text' id='enonce' name='enonce' class='form-control' value='<?= $enonce ?>'></input>
		<input type='hidden' name='type' value='Reponse courte'></input>
		<input type='hidden' name='choix' value='Aucun'></input>
		<label for='reponse'>R&eacute;ponse: </label><br />
		<input type='text' id='reponse' name='reponse' class='form-control' value='<?= $reponse ?>'></input>
		<?php
	} else {
		?>	
		<input type='hidden' name='id' value="<?=$_REQUEST['id']?>"></input>
		<label for='titre'>Titre: </label> <br />
		<input type='text' id='titre' name='titre' class='form-control'> </input>
		<label for='enonce'>&Eacute;nonc&eacute;: </label><br />
		<input type='text' id='enonce' name='enonce' class='form-control'></input>
		<input type='hidden' name='type' value='Reponse courte'></input>
		<input type='hidden' name='choix' value='Aucun'></input>
		<label for='reponse'>R&eacute;ponse: </label><br />
		<input type='text' id='reponse' name='reponse' class='form-control'></input>
		<?php
	} 
	?>
	<div class='buttonCenterer'>
		<button TYPE="submit" class='btn btn-primary'> Modifier </button>
	</div>
</form>
</div>
</div>
<footer>
<?php include_once("./vues/subvues/footer.php");?>
</footer>
</body>
</html>