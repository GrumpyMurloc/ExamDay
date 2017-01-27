<?php
require_once('./controleur/Action.interface.php');
class GererAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (ISSET($_REQUEST["content"]))
		{
			// -------------- EXAMS ---------------
			if ($_REQUEST["content"] == "examen" 
				or $_REQUEST["content"] == "exam"){
				if (ISSET($_REQUEST["id"])){
					require_once("./modele/DAOExamen.class.php");
					$exam = DAOExamen::find($_REQUEST["id"]);
					if ($exam and $exam->getEnseignantID() == $_SESSION["connecte"]->getID()){
						if (ISSET($_REQUEST["modify"])) return "modifierExam";
						else if (ISSET($_REQUEST["titre"]) and ISSET($_REQUEST["ponderation"])){
							$exam->setTitre($_REQUEST["titre"]);
							$exam->setPonderation($_REQUEST["ponderation"]);
							DAOExamen::update($exam);
						}
						return "gererExam";
					} else {
						//invalid request : not proper user
						header("Location: index.php");
					}
				} else {
					//invalid request : missing 'id' field 
					header("Location: index.php");
				}
			}
			// -------------- QUESTIONS --------------- 
			else if ($_REQUEST["content"] == "question"){
				if (ISSET($_REQUEST["id"])){
					require_once("./modele/DAOQuestion.class.php");
					require_once("./modele/classes/Question.class.php");
					$question = DAOQuestion::find($_REQUEST["id"]);
					if ($question and $question->getEnseignantID() == $_SESSION["connecte"]->getID()){
						
						if( 	ISSET($_REQUEST["titre"]) 
							and ISSET($_REQUEST["enonce"])
							and ISSET($_REQUEST["type"]) 
							and ISSET($_REQUEST["choix"])
							and ISSET($_REQUEST["reponse"])){

							$question->setTitre(trim($_REQUEST["titre"]));
							$question->setEnonce(trim($_REQUEST["enonce"]));
							$question->setQuestionType(trim($_REQUEST["type"]));
							$question->setChoix(trim($_REQUEST["choix"]));
							$question->setReponse(trim($_REQUEST["reponse"]));
							DAOQuestion::update($question);
							
							if (ISSET($_SESSION["lastView"])){
								header("Location: index.php?action=afficher&content=lastview");
							} else {
								header("Location: index.php");
							}
						} else {
							return "gererQuestion";
						}
					} else {
						// invalid request : not proper user
						header("Location: index.php");
					}
				} else {
					// invalid request : missing 'id' field
					header("Location: index.php");
				}
			}// -------------- QUESTIONEXAMEN ---------------
			else if ($_REQUEST["content"] == "questionexamen"){ 
			}// -------------- QUESTIONEXAMEN --------------- 
			else if ($_REQUEST["content"] == "compte"){
			}
			else if ($_REQUEST["content"] == "poids"){
				// we need all those fields
				if (ISSET($_REQUEST["questionid"]) 
					and ISSET($_REQUEST["examid"])
					and ISSET($_REQUEST["poids"])){
						require_once("./modele/DAOQuestionExamen.class.php");
						require_once("./modele/DAOExamen.class.php");
						require_once("./modele/classes/Examen.class.php");
						//exam must belong to user making request
						if (DAOExamen::find($_REQUEST["examid"])->getEnseignantID() == $_SESSION["connecte"]->getID()){
							DAOQuestionExamen::update(
								$_REQUEST["questionid"],
								$_REQUEST["examid"],
								$_REQUEST["poids"]);
							header("Location: ./?action=gerer&content=exam&id=".$_REQUEST["examid"]);
						}
						
					}
					/*
				if (ISSET($_SESSION["lastView"])){
					header("Location: index.php?action=afficher&content=lastview");
				}*/
			}
			else {
				//invalid request : content type unrecognized
				header("Location: index.php");
			}
		} else {
			//invalid request : missing field 'content'
			header("Location: index.php");
		}
	}
}
?>