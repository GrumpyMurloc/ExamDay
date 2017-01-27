<?php
require_once('./controleur/Action.interface.php');
class EtudiantAjouterAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		//-------------------------------------------
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
				if (strpos($key, 'reponse_') !== false){
					$questionID = str_replace($key,"reponse_");
					$x = DAOExamenQuestionExamenEleve::find($examID,$questionID,$exel);
					if ($reponse){
						DAOExamenQuestionExamenEleve::repondre($x,$reponse);
					}
					else{
						DAOExamenQuestionExamenEleve::repondre($x,$defaultAnswer);
					}
				}
			}
			//all questions answered
			DAOExamenEleve::completer($exel);
			header("Location: index.php");
			}
		}
		// if didn't return something so far, this will
		require_once("./controleur/DefaultAction.class.php");
		$a = new DefaultAction();
		return ($a->execute());
	}
}
?>