<?php
require_once('./controleur/Action.interface.php');
class PaginationAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)){
			session_start();
		}
		if (ISSET($_REQUEST["pagesize"]) and
			ISSET($_REQUEST["direction"]) and
			ISSET($_REQUEST["content"])
			){
			// need those informations
			$size 		= (int) $_REQUEST["pagesize"];
			$content 	= $_REQUEST["content"];
			$direction 	= 0;
			if ($_REQUEST["direction"]=="left")
				$direction 	= -1;
			else if ($_REQUEST["direction"]=="right")
				$direction 	=  1;
			if (!ISSET($_SESSION["pagination"][$content]))
				$_SESSION["pagination"][$content] = 0;
			$prev_index = $_SESSION["pagination"][$content];
			$new_index = 0;
			if ($content == "question"){
				require_once('./modele/DAOQuestion.class.php');
				$new_index = $prev_index + $size * $direction;
				$userID = $_SESSION["connecte"]->getID();
				// border cases
				if ($new_index<0)
					$new_index = 0;
				else if ($new_index>DAOQuestion::countEntries($userID))
					$new_index = $prev_index;
			}
			else if ($content == "examen"){
				require_once('./modele/DAOExamen.class.php');
				$new_index = $prev_index + $size * $direction;
				$userID = $_SESSION["connecte"]->getID();
				// border cases
				if ($new_index<0)
					$new_index = 0;
				else if ($new_index>DAOExamen::countEntries($userID))
					$new_index = $prev_index;
			}
			else if ($content == "questionAjoutee"){
				require_once('./modele/DAOQuestionExamen.class.php');
				$new_index = $prev_index + $size * $direction;
				$userID = $_SESSION["connecte"]->getID();
				$examID = $_REQUEST["id"];
				// border cases
				if ($new_index<0)
					$new_index = 0;
				else if ($new_index>DAOQuestionExamen::countEntries($examID))
					$new_index = $prev_index;
			}
			else if ($content == "questionAjoutable"){
				require_once('./modele/DAOQuestionExamen.class.php');
				require_once('./modele/DAOQuestion.class.php');
				$new_index = $prev_index + $size * $direction;
				$userID = $_SESSION["connecte"]->getID();
				$examID = $_REQUEST["id"];
				// border cases
				if ($new_index<0) $new_index = 0;
				else if ($new_index> DAOQuestion::countEntries($userID)-DAOQuestionExamen::countEntries($examID)){
					$new_index = $prev_index;
					echo DAOQuestionExamen::countEntries($examID);
				}
			}
			$_SESSION["pagination"][$content] = $new_index;
			if (ISSET($_SESSION["lastView"])){ 
				header("Location: index.php?action=afficher&content=lastview");
			}
			else {
				return "default";
			}
		}
	}
}