<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/classes/Utilisateur.class.php');
class DefaultAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (ISSET($_SESSION["connecte"])){
			//user is connected, dispatch him
			if ($_SESSION["connecte"]->getUserType() == 'enseignant')
				return "DashboardEnseignant";
			else if ($_SESSION["connecte"]->getUserType() == 'etudiant')
				return "DashboardEtudiant";
		}
		else return "default";
	}
}
?>