<?php 
	if (!ISSET($_SESSION)) session_start();
	$_SESSION["lastView"] = "DashboardEtudiant";
	$user = $_SESSION["connecte"];
	$userID = $_SESSION["connecte"]->getID();
?>
<html>
<head>
	<?php include_once('./vues/subvues/head.php');?>
</head>
<body>
	<?php include_once('./vues/subvues/banner.php');
		include_once('./vues/subvues/entrerCode.php');
		include_once('./vues/subvues/resultatsSession.php');
		$useTableWidth = "100%";
		include_once('./vues/subvues/listExamsAccessibles.php');
		include_once('./vues/subvues/listExamsCompletes.php');
		include_once('./vues/subvues/footer.php');
	?>
</body>
</html>
