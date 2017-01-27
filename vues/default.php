<html>
<head>
	<?php include('./vues/subvues/head.php'); ?>
</head>
<body>
	<?php include('./vues/subvues/banner.php'); ?>
	<div class='divFormulaireBordered'>
		<h3> Accueil </h3><br />
		<p style='text-align:center'> ExamDay est un site permettant à des enseignants de cr&eacute;er des examens
		 et d'&eacute;valuer leurs &eacute;l&egrave;ves.
		</p>
		<div class='form-group buttonCenterer'>
			<a href='./?action=ajouter&content=compte'>
				<button type='submit' class='btn btn-primary'>
					Cliquez ici pour cr&eacute;er un compte
				</button>
			</a>
			<a href='./?action=login'>
				<button type='submit' class='btn btn-primary'>
					Cliquez ici pour vous connecter
				</button>
			</a>
		</div>
	</div>
<?php include('./vues/subvues/footer.php'); ?>
</body>
</html>