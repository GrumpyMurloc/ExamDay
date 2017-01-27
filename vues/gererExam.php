<?php 
include_once("./modele/DAOExamen.class.php");
include_once("./modele/DAOQuestion.class.php");
include_once("./modele/DAOQuestionExamen.class.php");
include_once("./modele/classes/Examen.class.php");
include_once("./modele/classes/Question.class.php");
if (!ISSET($_SESSION)) session_start();
$_SESSION["lastView"] = "./index.php?action=gerer&content=examen&id=".$_REQUEST["id"];
$exam = DAOExamen::find($_REQUEST["id"]);
?>

<html>
<head>
<?php include_once("./vues/subvues/head.php"); ?>
</head>
<body>
	<?php include_once("./vues/subvues/banner.php"); ?>
		<div style='float:right;position:relative;text-align:right'>
			<?php
			if($exam->getDisponible()){
			?>
				<a href='.?action=ouvrir&content=false&examid=<?=$exam->getID()?>'>
					<button style='font-size:16px'>
						Fermer examen
					</button>
				</a>
			<?php
			} else{ ?>
				<a href='.?action=ouvrir&content=true&examid=<?=$exam->getID()?>'>
					<button style='font-size:16px'>
						Ouvrir examen
					</button>
				</a>
			<?php }	?>
			<br /><br />
			<a href='.?action=gerer&content=exam&id=<?=$exam->getID()?>&modify=true'>
				<button style='font-size:16px'>
					Modifier cet examen
				</button>
			</a><br /><br />
			<a href='.?action=afficher&content=codegeneration&examid=<?=$exam->getID()?>'>
				<button style='font-size:16px'>
					Obtenir des codes d'acc&egrave;s
				</button>
			</a>
		</div>
		<div>
			<h3>
				Gestion d'examen <br /> 
				<span class='exam_title'>
					<?=$exam->getTitre()?>
				</span><br />
				<?php if($exam->getDisponible()){ ?>
					<span class='exam_disponible' style="font-size:80%;">
					L'examen est ouvert
					</span>
				<?php }else{ ?>
					<span class='exam_disponible' style="font-size:80%;">
					L'examen est ferm&eacute;
					</span>
				<?php } ?>
				<br />
				<span class='exam_ponderation' style="font-size:80%;">
					Pond&eacute;ration: <?=$exam->getPonderation()?> points
				</span><br />
			</h3>
		</div>
	<div><br /></div>
	<?php 
		$useTableWidth="100%";
		include_once('./vues/subvues/listQuestionsAjoutees.php');
		include_once('./vues/subvues/listQuestionsAjoutables.php');
		include_once("./vues/subvues/footer.php");
	?>
</body>
</html>
