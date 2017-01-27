<?php
include_once('./modele/DAOExamen.class.php');
include_once('./modele/classes/Examen.class.php');
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

<?php if(ISSET($_REQUEST["type"]) and $_REQUEST["type"]=="enseignant")
	echo '<h3> Cr&eacute;er un compte Enseignant </h3><br />';
else if(ISSET($_REQUEST["type"]) and $_REQUEST["type"]=="etudiant")
	echo '<h3> Cr&eacute;er un compte &Eacute;tudiant</h3><br />';
else 
	echo '<h3> Cr&eacute;er un compte </h3><br />';
?>
<form action='./' class=>
<input type='hidden' name='action' value='ajouter'></input>
<input type='hidden' name='content' value='compte'></input>

<?php if(!ISSET($_REQUEST["type"])){?>
	<div class='buttonCenterer'>
		<button TYPE='input' name='type' value='etudiant' 
		class='btn btn-primary'> Je suis un &eacute;tudiant </button>
		<button TYPE='input' name='type' value='enseignant' 
		class='btn btn-primary'> Je suis un enseignant </button>
	</div>
<?php }
else{?>
	<input type='hidden' name=send value="true"> </input>
	<input type='hidden' name='type' value='<?=$_REQUEST["type"]?>'</input>
	<label for='username'>Identifiant: </label> <br />
	<?php if (ISSET($_REQUEST["field_messages"]["username"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["username"].
				"</span>"); ?>
	<input type='text' id='username' name='username' class='form-control'> </input>
	<label for='Nom'>Nom: </label> <br />
	<?php if (ISSET($_REQUEST["field_messages"]["nom"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["nom"].
				"</span>"); ?>
	<input type='text' id='nom' name='nom' class='form-control'> </input>
	<label for='prenom'>Pr&eacute;nom: </label><br />
	<?php if (ISSET($_REQUEST["field_messages"]["prenom"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["prenom"].
				"</span>"); ?>
	<input type='text' id='prenom' name='prenom' class='form-control'></input>
	<label for='pass'>Mot de passe: </label><br />
	<?php if (ISSET($_REQUEST["field_messages"]["password"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["password"].
				"</span>"); ?>
	<input type='password' id='password' name='password' class='form-control'></input>
	<label for='confirm'>Confirmer le mot de passe: </label><br />
	<?php if (ISSET($_REQUEST["field_messages"]["confirm"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["confirm"].
				"</span>"); ?>
	<?php if (ISSET($_REQUEST["field_messages"]["match"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["match"].
				"</span>"); ?>
	<input type='password' id='confirm' name='confirm' class='form-control'></input>
	<div class='buttonCenterer'>
		<button TYPE="submit" class='btn btn-primary'> Envoyer </button>
	</div>
<?php } ?>
</form>
</div>
</div>
<footer>
<?php include_once("./vues/subvues/footer.php");?>
</footer>
</body>
</html>

