<?php
require_once('./controleur/Action.interface.php');
include_once("./modele/DAOExamen.class.php");
include_once("./modele/classes/Examen.class.php");
class OuvrirAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		$content =$_REQUEST["content"];
		$exam = DAOExamen::find($_REQUEST["examid"]);
		if ($exam->getEnseignantID()==$userID){
			if ($content == "true"){
				DAOExamen::ouvrir($exam);
				header("Location: ".$_SESSION["lastView"]);
				return null;
			}
			else if ($content == "false"){
				DAOExamen::fermer($exam);								
				header("Location: ".$_SESSION["lastView"]);
				return null;
			}	
		}
		// message erreur
		header("Location: ./test");
	}
}
?>