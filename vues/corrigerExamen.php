<?php
include_once('./modele/DAOExamenEleve.class.php');
include_once('./modele/DAOQuestionExamen.class.php');
include_once('./modele/classes/Examen.class.php');
include_once('./modele/DAOExamen.class.php');
if(!ISSET($_SESSION)) session_start();
$userID = $_SESSION["connecte"]->getID();
$examID = $_REQUEST["examid"];
$exam = DAOExamen::find($examID);
$eleveID = $_REQUEST["eleveid"];
$exel = DAOExamenEleve::find($eleveID,$examID);
?>
<html>
<head>
<?php include('./vues/subvues/head.php') ?>
</head>
<body>
	<?php include('./vues/subvues/banner.php') ?>
	<div class=''>
		<div class='form-group'>
			<h2> Examen </h2>
			<h3>
				<span class="exam_title">
					<?=$exam->getTitre()?>
				</span>
			</h3><br />
			<form action='./' class="passer_exam">
				<input type='hidden' name='action'  value='soumettre_correction'></input>
				<input type='hidden' name='examid'  value='<?=$examID ?>'></input>
				<input type='hidden' name='eleveid' value='<?=$eleveID ?>'></input>
				<?php
				$questions = DAOQuestionExamen::findByExamen($examID);
				foreach ($questions as $q) {
					//global $questionID;
					$questionID = $q->getID();
					include('./vues/subvues/corrigerQuestion.php');
				}
				//now the overal comment section ?>
				<label for='commentaire_exam'>
					Commentaire sur l'examen:
				</label><br />
				<textarea id='exam_comment'	name='exam_comment' class='form-control'>
				</textarea><br />
				<button TYPE="submit" class='btn btn-primary'>
				Sauvegarder
				</button>
			</form>
		</div>
	</div>
	<?php include_once("./vues/subvues/footer.php"); ?>
</body>
</html>

