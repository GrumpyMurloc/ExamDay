<html>
<head>
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
	$count = count($examens); ?>
	<h3 class="iframe-title"> 	
	<?php
	if ($count == 0)  echo(" Aucune copie corrig&eacute;e");
	else if ($count == 1) echo(" 1 copie corrig&eacute;e");
	else if ($count > 1) echo ($count." copies corrig&eacute;es");
	?>
	</h3>
	<div class='exam_list'>
	<?php 
	foreach($examens as $exam){
		$exels = DAOExamenEleve::findByExamen($exam->getID());
		foreach($exels as $exel){
			if ($exel->getCorrected()){
				if ($exel->getComplet()){ ?>
					<div>
						<?=$exam->getTitre()?>
						<a style="float:right" target='_top' href='.?action=afficher&content=correction&examid=<?=$exam->getID()?>&eleveid=<?=$exel->getEleveID()?>'>
							Voir la correction
						</a>
					</div>
	  	  <?php }
	  		}
		}
	}
?>
</div>
</body>
</html>