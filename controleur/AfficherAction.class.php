<?php
require_once('./controleur/Action.interface.php');
class AfficherAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		if (ISSET($_REQUEST["content"])){
			$content = $_REQUEST["content"];
			if ($content == "lastview" and ISSET($_SESSION["lastView"])) {
				//echo $_SESSION["lastView"];
				$s = "Location: ".$_SESSION["lastView"];
				header($s);
			}
			else if ($content=="codegeneration" and ISSET($_REQUEST["examid"])){ 
				return "genererCodes";
			}
			else if ($content=="passer_examen"){
				if (ISSET($_REQUEST["examenid"])){
					if ($_SESSION["connecte"] ->getUserType=='etudiant'){
						include_once("./modele/DAOExamenEleve.class.php");
						include_once("./modele/classes/ExamenEleve.class.php");
						include_once("./modele/DAOExamen.class.php");
						include_once("./modele/classes/Examen.class.php");
						$examID = $_REQUEST["examid"];
						$exel = DAOExamenEleve::find($userID,$examID);
						$exam= DAOExamen::find($examID);
						if($exel!=null and $exam->getDisponible() and !$exel->getComplet()){
							return "passerExamen";					
						}
					}
				}
			}
			else if ($content=="correction"){
				if (ISSET($_REQUEST["examid"])){
					// etudiant
					if ($_SESSION["connecte"] ->getUserType()=='etudiant'){
						include_once("./modele/DAOExamenEleve.class.php");
						include_once("./modele/classes/ExamenEleve.class.php");
						$examID = $_REQUEST["examid"];
						$exel = DAOExamenEleve::find($userID,$examID);
						if($exel!=null and $exel->getCorrected()){
							return "voirCorrection";					
						}
					}
					// enseignant
					else { 
						if(ISSET($_REQUEST["eleveid"])){ 
							include_once("./modele/DAOExamen.class.php");
							include_once("./modele/classes/Examen.class.php");
							$exam = DAOExamen::find($_REQUEST["examid"]); 
							if ($exam->getEnseignantID()==$_SESSION["connecte"]->getID()){
								include_once("./modele/DAOExamenEleve.class.php");
								include_once("./modele/classes/ExamenEleve.class.php");
								$eleveID = $_REQUEST["eleveid"];
								$examID = $_REQUEST["examid"];
								$exel = DAOExamenEleve::find($eleveID,$examID);
								if ($exel and $exel->getCorrected()){
									return "voirCorrection";
								}
							}
						}
					}
				}
			}
			else if ($content=="resultat"){
				if(ISSET($_REQUEST["eleveid"])){										
					include_once("./modele/DAOExamenEleve.class.php");
					include_once("./modele/classes/ExamenEleve.class.php");
					$eleve= DAOExamenEleve::findByUser($_REQUEST["eleveid"]);
					if($eleve){
						return "/resultatEleve";
					}
				}
			}
			else if ($content=="examens_a_corriger"){
				return "subvues/examsCompletesACorriger";
			}
			else if ($content=="examens_deja_corriges"){
				return "subvues/examsCorriges";
			}
			else if ($content=="eleves"){
				return "subvues/listEleves";
			}
		}
		//if didn't reach any return, then a validation failed
		else {
			header("Location: ./");
		}
	}
}
?>