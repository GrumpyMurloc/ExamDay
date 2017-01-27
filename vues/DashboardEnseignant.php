<?php 
	if (!ISSET($_SESSION)) 
		session_start();
	$_SESSION["lastView"] = "./";
	$user = $_SESSION["connecte"];
	$userID = $_SESSION["connecte"]->getID();
?>
<html>
<head>
	<?php include_once('./vues/subvues/head.php');?>
</head>
<body>
	<?php include_once('./vues/subvues/banner.php');
	?>
	<div>
		<iframe class='iframes_dshbrd' frameborder="0" 
			src="./?action=afficher&content=examens_a_corriger">
			<a href="./?action=afficher&content=examens_a_corriger">
				Voir les examens &agrave; corriger
			</a>
		</iframe>
		<iframe class='iframes_dshbrd' frameborder="0"
			src="./?action=afficher&content=eleves">
			<a href="./?action=afficher&content=eleves">
				Voir les &eacute;l&egrave;ves
			</a>
		</iframe>
	</div>
	<div>
	<?php 
	//include_once('./vues/subvues/listExamsCompletesACorriger.php');	
	$useTableWidth="100%";
	include_once('./vues/subvues/listExams.php');
	$useTableWidth="100%";
	include_once('./vues/subvues/listQuestions.php'); ?>
	<?php include('./vues/subvues/footer.php'); ?>
	</div>
</body>
</html>