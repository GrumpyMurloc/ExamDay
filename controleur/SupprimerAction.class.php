<?php
require_once('./controleur/Action.interface.php');
class SupprimerAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connecte"]))
			return "login";

		if (ISSET($_REQUEST["content"]) and ISSET($_REQUEST["id"]))
		{
			$ID = $_REQUEST["id"];
			if ($_REQUEST["content"] == "examen"){
				require_once("./modele/DAOExamen.class.php");
				$x = DAOExamen::find($ID);
				if ($x and $x->getEnseignantID() == $_SESSION["connecte"]->getID()){
					DAOExamen::delete($x->getID());
				}
			}
			/*require_once("./modele/DAOQuestionExamen.class.php");
			require_once("./modele/DAOExamenEleve.class.php");
			require_once("./modele/DAOCodeExamen.class.php");
			require_once("./modele/DAOExamenQuestionExamenEleve.class.php");
			$x = DAOExamen::find($ID);
			if ($x and $x->getEnseignantID() == $_SESSION["connecte"]->getID()){
				// Suppression de questionExamen 
				$questions= DAOQuestionExamen::findByExamen($x->getID());					
				foreach($questions as $question){		
					DAOQuestionExamen::delete($question->getID(),$x->getID());
				}
				// Suppression d'examenEleve et examenQuestionExamenEleve 
				$examsEleve= DAOExamenEleve::findByExamen($x->getID());
				if($examsEleve){
					foreach ($examsEleve as $examEleve) {
						foreach($questions as $question){		
							DAOExamenQuestionExamenEleve::delete($x->getID(),$question->getID(), $examEleve);
						}
						DAOExamenEleve::delete($examEleve);
					}
				}
				DAOCodeExamen::deleteByExam($x->getID());
				DAOExamen::delete($x);
			}*/

			else if ($_REQUEST["content"] == "question"){
				require_once("./modele/DAOQuestion.class.php");
				$x = DAOQuestion::find($ID);
				if ($x and $x->getEnseignantID() == $_SESSION["connecte"]->getID()){
					include_once("./modele/DAOQuestionExamen.class.php");
					$exams= DAOQuestionExamen::findByQuestion($x->getID());
					foreach($exams as $exam){		
						DAOQuestionExamen::delete($x->getID(),$exam->getID());
					}
					DAOQuestion::delete($x);
				}
			}
			else if ($_REQUEST["content"] == "questionexamen"){
				require_once("./modele/DAOQuestionExamen.class.php");
				$IDexam = $_REQUEST["idexam"];
				$IDques = $_REQUEST["idques"];
				if ($x and $x->getEnseignantID == $_SESSION["connecte"]->getID()){	
					DAOQuestionExamen::delete($x->getID(),$exam->getID());
				}
			}
			else if ($_REQUEST["content"] == "compte"){
				require_once("./modele/DAOUtilisateur.class.php");
				$x = new Utilisateur();
				$x->setNum($_REQUEST["id"]);
				DAOUtilisateur::delete($x);
			}
		}
		header("Location: index.php?action=afficher&content=lastview");
	}
	}
?>