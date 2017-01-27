<html>
<head>
<?php include_once("./vues/subvues/head.php");?>
</head>
<body>
<?php
include_once("./vues/subvues/banner.php");
?>
<div class="divFormulaireBordered">
	<h3 id="titreDispatch"><b>Connexion</b></h3>
<!-- LoginPage.php?action=login&status=failed -->
<?php 
	if (ISSET($_REQUEST["global_message"]))
		echo("<span class='errorMessage'>".$_REQUEST["global_message"]."</span>");
?>
	<form id='formulaireLogin' action="index.php" method='POST'>
		<div class="form-group">
			<label for="inputUser">Identifiant</label>
			<?php if (ISSET($_REQUEST["field_messages"]["username"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["username"].
				"</span>"); ?>
			<input type="text" class="form-control" id="inputUser" 
			placeholder="Nom d'utilisateur" name="username" />
			<label for="inputPassword">Mot de passe</label>
			<?php if (ISSET($_REQUEST["field_messages"]["password"]))
				echo("<br /><span class='errorMessage'>".
				$_REQUEST["field_messages"]["password"].
				"</span>"); ?>
			<input type="password" class="form-control" id="inputPassword" 
			placeholder="Mot de passe" name="password" />
		</div>
		<div class="buttonCenterer">
			<button type="submit" class="btn btn-primary" name="action"
			 value="login">Se connecter</button>
		</div>
	</form>
</div>
<footer>
<?php include_once("./vues/subvues/footer.php");?>
</footer>
</body>
</html>
<!-- -->
