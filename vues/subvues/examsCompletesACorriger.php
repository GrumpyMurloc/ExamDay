<html>
<head>
	<?php include_once("./vues/subvues/head.php"); ?>
</head>
<body>
<?php 
include_once('./modele/DAOExamen.class.php');
include_once('./modele/classes/Examen.class.php');
include_once('./modele/DAOExamenEleve.class.php');
include_once('./modele//classes/ExamenEleve.class.php');

if (!ISSET($_SESSION))
		session_start();
$length = 10;
if (!ISSET($_SESSION["pagination"]["examen"]))
	$_SESSION["pagination"]["examen"]=0;
$start = $_SESSION["pagination"]["examen"];
$realStart = $start+1;
$userID = $_SESSION["connecte"]->getID();
$examens = DAOExamen::findAll($userID);
$examStrings = [];  ?>
<?php
foreach($examens as $exam){
	$exels = DAOExamenEleve::findByExamen($exam->getID());
	foreach($exels as $exel){
		if (!$exel->getCorrected()){
			if ($exel->getComplet()){ 
				$examStrings[]=(
					"".$exam->getTitre().
					"<a style='float:right' target='_top' href='.
					?action=corriger&content=examen&examid=".
					$exam->getID()."&eleveid=".
					$exel->getEleveID()."'>Corriger</a>");
			}
		}
	}
}
$count = count($examStrings) ?>
<h3>
	<?php 	
		if ($count == 0)  echo(" Aucune copie &agrave; corriger");
		else if ($count == 1) echo(" 1 copie &agrave; corriger");
		else if ($count > 1) echo ($count." copies &agrave; corriger");
	?>
</h3>
<div class='exam_list'>
<?php 
foreach($examStrings as $examStr){
?>
	<div>
		<?=$examStr?>
	</div>
<?php } ?>
</div>
</body>
</html>