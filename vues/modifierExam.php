<?php
include_once('./modele/DAOExamen.class.php');
include_once('./modele/classes/Examen.class.php');
if(!ISSET($_SESSION)) session_start();
$_SESSION["lastView"] = "./?action=gerer&content=examen&id=".$_REQUEST['id']; //DOUTES...
?>
<html>
<head>
<?php include('./vues/subvues/head.php') ?>
</head>
<body>
<?php include('./vues/subvues/banner.php') ?>
<div class='divFormulaireBordered'>
<div class='form-group'>
<h3> Modifier un examen </h3><br />
<form action="./">
	<input type='hidden' name='action' value='gerer'></input>
	<!-- <?php echo "--------------".$_REQUEST["id"]."-----------------"; ?>-->
	<input type='hidden' name='id' value="<?=$_REQUEST['id']?>"></input> 
	<input type='hidden' name='content' value='exam'></input>
<?php
	$e = DAOExamen::find($_REQUEST['id']);
	if ($e){
		$examID=$e->getID();
		$titre = $e->getTitre();
		$ponderation = $e->getPonderation();
		?>
		<!--<input type='hidden' name='id' value='<?= $examID ?>'></input>-->
		<label for='titre'>Titre: </label> <br />
		<input type='text' id='titre' name='titre' class='form-control' value='<?= $titre ?>'> </input>
		<label for='ponderation'>Pond&eacute;ration: </label><br />
		<input type='text' id='ponderation' name='ponderation' class='form-control' value='<?= $ponderation ?>'></input>
		<?php
	} else {
		?>	
		<!--<input type='hidden' name='id' value="<?= $_REQUEST['id'] ?>"></input>-->
		<label for='titre'>Titre: </label> <br />
		<input type='text' id='titre' name='titre' class='form-control'> </input>
		<label for='ponderation'>pond&eacute;ration: </label><br />
		<input type='text' id='enonce' name='enonce' class='form-control'></input>
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