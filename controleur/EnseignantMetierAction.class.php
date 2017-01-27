<?php
require_once('./controleur/Action.interface.php');
class EnseignantMetierAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if ($_REQUEST["action"] == "soumettre_correction"){
			if (ISSET($_REQUEST["examid"]) and ISSET($_REQUEST["eleveid"])){
				include_once("./modele/DAOExamen.class.php");
				include_once("./modele/classes/Examen.class.php");
				$exam = DAOExamen::find($_REQUEST["examid"]);
				if ($exam->getEnseignantID() == $_SESSION["connecte"]->getID()){
					return (EnseignantMetierAction::soumettreCorrection());
				}
			}
		}
		header("Location: index.php");
	}
	public function soumettreCorrection(){
		$userID = $_SESSION["connecte"]->getID();
		{
			include_once("./modele/DAOExamenEleve.class.php");
			include_once("./modele/classes/ExamenEleve.class.php");
			include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
			include_once("./modele/classes/ExamenQuestionExamenEleve.class.php");
			include_once("./modele/DAOQuestionExamen.class.php");
			include_once("./modele/classes/Question.class.php");
			$examID = $_REQUEST["examid"];
			$eleveID = $_REQUEST["eleveid"];
			$exel = DAOExamenEleve::find($eleveID,$examID);
			$defaultAnswer = "[...]";
			foreach($_REQUEST as $key => $value){
				//notes
				if (strpos($key, 'note_') !== false){
					$questionID = str_replace("note_","",$key);
					echo $questionID."<br />";
					$x = DAOExamenQuestionExamenEleve::find($examID,$questionID,$exel);
					if ($value != ""){
						DAOExamenQuestionExamenEleve::noter($x,$value);
					}
					else {
						DAOExamenQuestionExamenEleve::noter($x,"0");
					}
				}
				//commentaires
				else if (strpos($key, 'commentaire_') !== false){
					$questionID = str_replace("commentaire_","",$key);
					echo $questionID."<br />";
					$x = DAOExamenQuestionExamenEleve::find($examID,$questionID,$exel);
					if ($value != ""){
						DAOExamenQuestionExamenEleve::commenter($x,$value);
					}
					else {
						DAOExamenQuestionExamenEleve::commenter($x,"Aucun commentaire");
					}
				}
			}
			$exel->setCommentaire($_REQUEST["exam_comment"]);
			echo $_REQUEST["exam_comment"]."<br />";
			DAOExamenEleve::commenter($exel);
			DAOExamenEleve::corriger($exel);
			//echo "two";
			header("Location: index.php");
		}
		//echo "three";
		header("Location: index.php");
	}
}
?>