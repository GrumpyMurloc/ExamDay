<?php
require_once('./controleur/Action.interface.php');
class EtudiantMetierAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if ($_REQUEST["action"] == "soumettre_examen"){
			echo "wut";
			return (EtudiantMetierAction::soumettreExamen());
		}
		else if ($_REQUEST["action"] == "passer_examen"){
			if (ISSET($_REQUEST["examid"])){
				$userID = $_SESSION["connecte"]->getID();
				include_once("./modele/DAOExamenEleve.class.php");
				include_once("./modele/DAOExamen.class.php");
				include_once("./modele/classes/Examen.class.php");
				include_once("./modele/classes/ExamenEleve.class.php");
				include_once("./modele/classes/ExamenQuestionExamenEleve.class.php");
				include_once("./modele/DAOQuestionExamen.class.php");
				include_once("./modele/classes/Question.class.php");
				include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
				$examID = $_REQUEST["examid"];
				$exel = DAOExamenEleve::find($userID,$examID);
				$exam = DAOExamen::find($examID);
				if ($exel and !$exel->getComplet() and $exam->getDisponible())
					foreach(DAOQuestionExamen::findByExamen($examID) as $question){
						$questionID = $question->getID();
						$x = DAOExamenQuestionExamenEleve::getNew(
							$examID,$questionID, $exel);
						DAOExamenQuestionExamenEleve::create($x);
					}
					return "passerExamen";
			}
		}
		//header("Location: index.php");
	}



	public function soumettreExamen(){
		$userID = $_SESSION["connecte"]->getID();
		if (ISSET($_REQUEST["examid"])){
			//update EQEE, complete exam and then redirect
			include_once("./modele/DAOExamenEleve.class.php");
			include_once("./modele/classes/ExamenEleve.class.php");
			include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
			include_once("./modele/classes/ExamenQuestionExamenEleve.class.php");
			include_once("./modele/DAOQuestionExamen.class.php");
			include_once("./modele/classes/Question.class.php");
			$examID = $_REQUEST["examid"];
			$exel = DAOExamenEleve::find($userID,$examID);
			$defaultAnswer = "[...]";
			foreach($_REQUEST as $key => $reponse){
				echo $key."<br />";
				echo $reponse."<br />";
				if (strpos($key, 'reponse_') !== false){
					$questionID = str_replace("reponse_","",$key);
					echo $questionID."<br />";
					$x = DAOExamenQuestionExamenEleve::find($examID,$questionID,$exel);
					if ($reponse != ""){
						DAOExamenQuestionExamenEleve::repondre($x,$reponse);
					}
					else{
						DAOExamenQuestionExamenEleve::repondre($x,$defaultAnswer);
					}
				}
			}
			//all questions answered
			DAOExamenEleve::completer($exel);
			//echo "two";
			header("Location: index.php");
		}
		//echo "three";
		header("Location: index.php");
	}
}
?>