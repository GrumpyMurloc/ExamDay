<?php
include_once("./modele/DAOExamen.class.php");
include_once("./modele/DAOExamenEleve.class.php");
include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
include_once("./modele/DAOQuestion.class.php");
include_once("./modele/DAOQuestionExamen.class.php");
include_once("./modele/DAOUtilisateur.class.php");
include_once("./modele/classes/Examen.class.php");
include_once("./modele/classes/ExamenEleve.class.php");
include_once("./modele/classes/ExamenQuestionExamenEleve.class.php");
include_once("./modele/classes/Utilisateur.class.php");

if (!ISSET($_SESSION)) session_start();
$userID = $_SESSION["connecte"]->getID();
// FLAG from main view, can specify which student to use if need be
if (!ISSET($_REQUEST["eleveid"])){
	$eleveID = $userID;
	// teacher should not be able to see student's other results for other classes
	$restricted_to_self = false;
}
else{
	$eleveID = $_REQUEST["eleveid"];
	$restricted_to_self = true;
}
//echo "Test1";
$eleve = DAOUtilisateur::find($eleveID);
$exels = DAOExamenEleve::findByUser($eleveID);
//print_r($exels);
$profs = [];
$profs["ListOfIndexes"] = [];
foreach($exels as $exel){
	//echo "some exel <br />";
	if ($exel->getComplet() and $exel->getCorrected()){
		$exam = DAOExamen::find($exel->getExamID());
		//echo "<br />".$exel->getExamID();
		$eid = $exam->getID();
		$prof = DAOUtilisateur::find($exam->getEnseignantID());
		$pid = $prof->getID();
		if ($restricted_to_self && $pid==$userID or !$restricted_to_self){
			if (!ISSET($profs[$pid])){
				$profs[$pid] = [];
				$profs["ListOfIndexes"][] = $pid;
				$profs[$pid]["SommePonderation"] = 0.0;
				$profs[$pid]["PointsObtenus"] = 0.0;
				$profs[$pid]["ProfObject"] = $prof;
				$profs[$pid]["NoteFinale"] = 0.0;
			}
			$profs[$pid]["ListOfIndexes"][] = $eid;
			$profs[$pid][$eid] = [];
			// now this is unique to the exam itself, and sorted by teacher.
			$profs[$pid][$eid]["ExamenObject"] = $exam;
			$profs[$pid][$eid]["ExamenEleveObject"] = $exel;
			$profs[$pid][$eid]["Ponderation"] = floatval($exam->getPonderation());
			$profs[$pid]["SommePonderation"] += floatval($profs[$pid][$eid]["Ponderation"]);
			$profs[$pid][$eid]["Somme"] = 0.0;
			$profs[$pid][$eid]["Total"] = 0.0;
			$profs[$pid][$eid]["Resultat"] = 0.0;
			$questions = DAOQuestionExamen::findByExamen($exam->getID());

			foreach($questions as $question){
				//echo "some question <br />";
				$qid = $question->getID();
				$profs[$pid][$eid][$qid] = [];
				$profs[$pid][$eid][$qid]["QuestionObject"] = $question;
				//this isn't a very good way to use the database
				//for it uses too many requests, but well, time's ticking
				$profs[$pid][$eid][$qid]["Poids"] = (
					DAOQuestionExamen::findPoids($qid,$eid));
				$profs[$pid][$eid]["Total"] += intval($profs[$pid][$eid][$qid]["Poids"]);
				// we only need the note for this view
				//---------------------
				/*$profs[$pid][$eid][$qid]["Note"]  = (
					DAOExamenQuestionExamenEleve::find($qid,$eid,$exel)->getNote());*/
				$profs[$pid][$eid][$qid]["Note"] = 0.0;
				$temp = DAOExamenQuestionExamenEleve::find($eid,$qid,$exel);
				if ($temp){
					$profs[$pid][$eid][$qid]["Note"] = $temp->getNote();
				}
				$profs[$pid][$eid]["Somme"] += $profs[$pid][$eid][$qid]["Note"];
			}

			// somme and total now filled with questions' data
			if ($profs[$pid][$eid]["Total"] > 0){
				// a single poids=0 question is a bonus question
				$profs[$pid][$eid]["Resultat"] = (
					$profs[$pid][$eid]["Somme"] / $profs[$pid][$eid]["Total"] );
			}
			$profs[$pid]["PointsObtenus"] += floatval(
				$profs[$pid][$eid]["Resultat"] * $profs[$pid][$eid]["Ponderation"]);
			// now we can find the correct and current result for the whole semester:
			if ($profs[$pid]["SommePonderation"] > 0){
				$profs[$pid]["NoteFinale"] = floatval(
					$profs[$pid]["PointsObtenus"] / $profs[$pid]["SommePonderation"]);
			}
		}
	}
}
// Finaly ready to display this stuff!
?>
<div class="resultats_session">
	<?php 
	if (count($profs["ListOfIndexes"])>0){ 
		if(!$restricted_to_self)
			echo "<h2> R&eacute;sultats </h2>";
		else
			echo "<h2> R&eacute;sultats de ".strtoupper($eleve->getPrenom()." ".$eleve->getNom())."</h2>";
	}
	foreach($profs["ListOfIndexes"] as $i){
		$prof 		= $profs[$i]["ProfObject"];
		$noteFinale = $profs[$i]["NoteFinale"];
		$points 	= $profs[$i]["PointsObtenus"];
		$sommePonde = $profs[$i]["SommePonderation"];
		?>
		<div class="resultats_prof_infos">
			<h3><?=strtoupper($prof->getPrenom())?> 
				<?=strtoupper($prof->getNom())?></h3>
			<h4>Note pr&eacute;vue : 
				<?=round(100*$noteFinale,2)?> % 
				(<?=round($points,2)?>/<?=round($sommePonde,2)?>)</h4>
			<?php foreach($profs[$i]["ListOfIndexes"] as $j){
				$exam = $profs[$i][$j]["ExamenObject"];
				$examID = $exam->getID();
				$exel = $profs[$i][$j]["ExamenEleveObject"];
				$somme = $profs[$i][$j]["Somme"];
				$total = $profs[$i][$j]["Total"];
				$ponderation = $profs[$i][$j]["Ponderation"];
				$resultat = $profs[$i][$j]["Resultat"];
			?>
			<div class='resultats_exam_infos'>
				<div class='exam_title'>
					<div style='float:right'>Compte pour <?=$ponderation?>/<?=$sommePonde?> de la session</div>
					<div>
						<a href="index.php?action=afficher&content=correction&examid=<?=$examID?>&eleveid=<?=$eleveID?>">
							<?=$exam->getTitre()?>
						</a>
					</div> 
				</div>
				<?php if ($total>0) {?>
					<p> <?=$somme?> / <?=$total?> -> <?=round(100*$resultat,2)?> %</p>
				<?php } else { ?>
					<p> Formatif </p>
				<?php }
				if ($exel->getCommentaire()){ ?>
					<p class="resultats_comment"> <?=$exel->getCommentaire()?></p>
				<?php } ?>
			</div>
			<?php 
			}
		 ?>
		</div>
<?php } ?>
</div>