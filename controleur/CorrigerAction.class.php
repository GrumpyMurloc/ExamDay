<?php
require_once('./controleur/Action.interface.php');
class CorrigerAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		if (ISSET($_REQUEST["examid"]) and ISSET($_REQUEST["eleveid"])){
			include_once("./modele/DAOExamen.class.php");
			include_once("./modele/classes/Examen.class.php");
			$exam = DAOExamen::find($_REQUEST["examid"]);
			if ($exam and $exam->getEnseignantID()==$userID){
				return "corrigerExamen";
			}
			else {
				//invalid request : missing field 'content'
				header("Location: index.php");
			}
		} 
		else {
			//invalid request : missing field 'content'
			header("Location: index.php");
		}
	}
}
?>