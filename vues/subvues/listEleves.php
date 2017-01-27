<html>
<head>
	<?php include_once("./vues/subvues/head.php"); ?>
</head>
<body>
	<?php 
	include_once('./modele/DAOExamen.class.php');
	include_once('./modele/DAOExamenEleve.class.php');
	include_once('./modele/DAOUtilisateur.class.php');
	include_once('./modele/classes/Examen.class.php');

	if (!ISSET($_SESSION))
		session_start();
	$userID = $_SESSION["connecte"]->getID();
	$exams = DAOExamen::findAll($userID);
	$eleves= []; 
	foreach ($exams as $exam) { 
		$exels = DAOExamenEleve::findByExamen($exam->getID());
		foreach ($exels as $exel){
			$temp = DAOUtilisateur::find($exel->getEleveID());
			if (!in_array($temp, $eleves)){
				$eleves[]=$temp;	
			}
		}
	}
	$count = count($eleves);
	?>
	<h3 class='iframe_title'> 
		<?php
			if ($count == 0)  echo(" Aucun &eacute;l&egrave;ve ");
			else if ($count == 1) echo(" 1 &eacute;l&egrave;ve :  ");
			else if ($count > 1) echo ($count." &eacute;l&egrave;ves :  ");
		?>
	</h3>
	<div>
		<div class='Eleve_list'>
			<div>
			<?php foreach($eleves as $eleve){  ?> 
				<div>
					<p><?php echo "#".$eleve->getID()."&emsp;".strtoupper($eleve->getNom())." ".$eleve->getPrenom()?>
						<a style="float:right" target='_top' href='.?action=afficher&content=resultat&eleveid=<?=$eleve->getID()?>'>
							Afficher r&eacute;sultat
						</a>
					</p>
				</div>
		<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>