<?php
require_once('./controleur/Action.interface.php');
class LoginAction implements Action {
	public function execute(){
		// start session
		if (!ISSET($_SESSION)) session_start();
		// check if user already logged
			// if so, get him to his dashboard
		if (ISSET($_SESSION["connecte"]))
			return (new DefaultAction())->execute();
		// check if form was submitted
		if (!ISSET($_REQUEST["username"])) return "login";
		//if form isn't valid
		if (!$this->valide())
		{
			// create error message, redisplay the form
			$_REQUEST["global_message"] = "Veuillez remplir tous les champs du formulaire";	
			return "login";
		}
		require_once('./modele/DAOUtilisateur.class.php');
		$user = DAOUtilisateur::findByUsername(trim($_REQUEST["username"]));
		if ($user == null)
			{
				$_REQUEST["field_messages"]["username"] = "Utilisateur inexistant.";	
				return "login";
			}
		else if ($user->getPass() != md5(trim($_REQUEST["password"])))
			{
				$_REQUEST["field_messages"]["password"] = "Mot de passe incorrect.";	
				return "login";
			}
		$_SESSION["connecte"] = $user;
		include_once("./controleur/DefaultAction.class.php");
		header("Location: index.php");
	}
	public function valide()
	{
		$result = true;
		if (trim($_REQUEST['username']) == "")
		{
			$_REQUEST["field_messages"]["username"] = "Donnez votre nom d'utilisateur";
			$result = false;
		}	
		if (trim($_REQUEST['password']) == "")
		{
			$_REQUEST["field_messages"]["password"] = "Mot de passe obligatoire";
			$result = false;
		}	
		return $result;
	}
}
?>