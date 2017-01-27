<?php
require_once('./controleur/Action.interface.php');
class EnseignantAjouterAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		$userID = $_SESSION["connecte"]->getID();
		//-------------------------------------------
		if ($_REQUEST["content"] == "examen" or $_REQUEST["content"] == "exam" ){
			if(isset($_REQUEST["ponderation"]) && isset($_REQUEST["titre"])){
				require_once('./modele/DAOExamen.class.php');
				require_once('./modele/classes/Examen.class.php');
				$userID = $_SESSION["connecte"]->getID();
				$examen= new Examen(
					"",
					$userID,
					$_REQUEST["ponderation"],
					$_REQUEST["titre"]
					);
				DAOExamen::create($examen);
				$examID = DAOExamen::findLastExamID($userID)[0];
				header("Location: ./index.php?action=gerer&content=examen&id=".$examID);
			}
			return "ajouterExam";
		}
		else if ($_REQUEST["content"] == "examenquestion" or $_REQUEST["content"] == "questionexamen"){
			if(ISSET($_REQUEST["poids"]) and ISSET($_REQUEST["examid"]) and ISSET($_REQUEST["questionid"])){
				$questionID = $_REQUEST["questionid"];
				$examID = $_REQUEST["examid"];
				$poids = $_REQUEST["poids"];
				require_once("./modele/DAOExamen.class.php");
				require_once("./modele/DAOQuestion.class.php");
				require_once("./modele/DAOQuestionExamen.class.php");
				$question = DAOQuestion::find($questionID);
				$exam = DAOExamen::find($examID);
				if ($question->getEnseignantID() == $userID and $exam->getEnseignantID() == $userID){
					if (EnseignantAjouterAction::check_poids($poids)){
						$poids_float = floatval($poids);
						$examID = $exam->getID();
						DAOQuestionExamen::create($question->getID(),$examID,$poids_float);
						header("Location: ./index.php?action=gerer&content=examen&id=".$examID);
						//return $_SESSION["lastView"];
					}
				}
			}
		}
		else if ($_REQUEST["content"] == "question"){
			if(ISSET($_REQUEST["titre"]) and ISSET($_REQUEST["enonce"])
				and ISSET($_REQUEST["type"]) and ISSET($_REQUEST["choix"])
				and ISSET($_REQUEST["reponse"]))
			{
				require_once('./modele/DAOQuestion.class.php');
				require_once('./modele/classes/Question.class.php');
				$question= new Question(
					"",
					$_SESSION["connecte"]->getID(),
					$_REQUEST["enonce"],
					$_REQUEST["choix"],
					$_REQUEST["type"],
					$_REQUEST["titre"],
					$_REQUEST["reponse"]
					);
				DAOQuestion::create($question);
				echo $_SESSION["lastView"];
				header("Location: index.php?action=afficher&content=lastview");
			}
			return "ajouterQuestion";
		}
		else if ($_REQUEST["content"] == "code_examen"){
			if (ISSET($_REQUEST["nbr"]) and ISSET($_REQUEST["examid"]))
				if (EnseignantAjouterAction::check_nbr($_REQUEST["nbr"])){
					include_once("./modele/DAOCodeExamen.class.php");
					$codes = [];
					$i = 0;
					$n = (int) $_REQUEST["nbr"];
					while ($i<$n){
						$codes[] = DAOCodeExamen::getNewCode($_REQUEST["examid"]);
						$i = $i+1;
					}
					$_SESSION["generatedCodes"] = $codes;
					return "genererCodes";
				}
		}
		// if didn't return something so far, this will
		require_once("./controleur/DefaultAction.class.php");
		$a = new DefaultAction();
		return ($a->execute());
	}

	public function check_nbr($nbr){
		try {
			return (((int) $nbr)>0);
		}
		catch (Exception $e){
			return false;
		}
	}

	public function check_poids($poids){
		try{
			return (((float) $poids)>=0.0);
		}
		catch (Exception $e){
			return false;
		}
	}
	
	public function valideQuestion()
	{
		if(!ISSET($_REQUEST['enonce'])
			or !ISSET($_REQUEST['choix'])
			or !ISSET($_REQUEST['type'])
			or !ISSET($_REQUEST['titre'])
			or !ISSET($_REQUEST['reponse'])){
				$result= false;
		}
		$result = true;
		if (ISSET($_REQUEST['enonce']) and trim($_REQUEST['enonce']) == "")
		{
			$_REQUEST["field_messages"]["enonce"] = "Entr&eacute; l'&eacute;nonc&eacute; de la question";
			$result = false;
		}	
		if (ISSET($_REQUEST['choix'])and trim($_REQUEST['choix']) == "")
		{
			$_REQUEST["field_messages"]["choix"] = "Entr&eacute; les choix de la question";
			$result = false;
		}	
		if (ISSET($_REQUEST['type'])and trim($_REQUEST['type']) == "")
		{
			$_REQUEST["field_messages"]["type"] = "Entr&eacute; le type de la question";
			$result = false;
		}
		if (ISSET($_REQUEST['titre'])and trim($_REQUEST['titre']) == "")
		{
			$_REQUEST["field_messages"]["titre"] = "La question a besoin d'un titre";
			$result = false;
		}	
		if (ISSET($_REQUEST['reponse']) and trim($_REQUEST['reponse']) == "")
		{
			$_REQUEST["field_messages"]["reponse"] = "Entr&eacute; une r&eacute;ponse";
			$result = false;
		}
		return $result;
	}

	public function valideExam()
	{
		if(!ISSET($_REQUEST['examPonderation'])
			or !ISSET($_REQUEST['examTitre'])){
				$result= false;
		}
		$result = true;
		if (ISSET($_REQUEST['examPonderation']) and trim($_REQUEST['examPonderation']) == "")
		{
			$_REQUEST["field_messages"]["examPonderation"] = "Entr&eacute; la pond&eacute;ration de l'examen";
			$result = false;
		}	
		if (ISSET($_REQUEST['examTitre'])and trim($_REQUEST['examTitre']) == "")
		{
			$_REQUEST["field_messages"]["nom"] = "Entr&eacute; le titre de l'examen";
			$result = false;
		}	
		return $result;
	}

	public function valideQuestionExam()
	{
		$result = true;
		if (ISSET($_REQUEST['username']) and trim($_REQUEST['username']) == "")
		{
			$_REQUEST["field_messages"]["username"] = "Entr&eacute; votre identifiant";
			$result = false;
		}	
		if (ISSET($_REQUEST['nom'])and trim($_REQUEST['nom']) == "")
		{
			$_REQUEST["field_messages"]["nom"] = "Entr&eacute; votre nom";
			$result = false;
		}	
		if (ISSET($_REQUEST['prenom'])and trim($_REQUEST['prenom']) == "")
		{
			$_REQUEST["field_messages"]["prenom"] = "Entr&eacute; votre pr&eacute;nom";
			$result = false;
		}
		if (ISSET($_REQUEST['password'])and trim($_REQUEST['password']) == "")
		{
			$_REQUEST["field_messages"]["password"] = "Mot de passe obligatoire";
			$result = false;
		}	
		if (ISSET($_REQUEST['confirm']) and trim($_REQUEST['confirm']) == "")
		{
			$_REQUEST["field_messages"]["confirm"] = "Confirm&eacute; le mot de passe";
			$result = false;
		}
		/*if (trim($_REQUEST['password']) == trim($_REQUEST['confirm']))
		{
			$_REQUEST["field_messages"]["confirm"] = "Le mot de passe est diff&eacute;rent";
			$result = false;
		}*/	
		return $result;
	}
}
?>