<?php
require_once('./controleur/Action.interface.php');
class EtudiantAjouterAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		//-------------------------------------------
		if ($_REQUEST["content"] == "examen_eleve"){
			if (ISSET($_REQUEST["code"])){
				include_once("./modele/DAOCodeExamen.class.php");
				$c = DAOCodeExamen::find($_REQUEST["code"]);
				if ($c){
					include_once("./modele/DAOExamenEleve.class.php");
					$examID = $c->getExamID();
					$exel = DAOExamenEleve::getEmpty();
					$exel->setExamID($examID);
					$exel->setEleveID($userID);
					DAOExamenEleve::create($exel);
					header("Location: index.php");
				}
			}
		}
		// if didn't return something so far, this will
		require_once("./controleur/DefaultAction.class.php");
		$a = new DefaultAction();
		return ($a->execute());
	}
}
?>