<?php
require_once('./controleur/Action.interface.php');
class AjouterCompteAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if ($_REQUEST["content"] == "compte" ){
			if(!ISSET($_REQUEST["type"]))
				return "ajouterUtilisateur";
			if (! ($this->valideCompte()) ){
				$_REQUEST["global_message"] = (
					"Veuillez remplir tous les champs du formulaire correctement"
					);
				return "ajouterUtilisateur";
			} else {
				require_once('./modele/classes/Utilisateur.class.php');
				require_once('./modele/DAOUtilisateur.class.php');
				$user = new Utilisateur(
					"",
					trim($_REQUEST["nom"]),
					trim($_REQUEST["prenom"]),
					trim($_REQUEST["password"]),
					trim($_REQUEST["username"]),
					"",
					trim($_REQUEST["type"])
					);
				DAOUtilisateur::create($user);
				$user = null; // getting rid of plaintext password
				header("Location: index.php?action=login");
			}
		} else {
			return "a";
		}
	}
	public function valideCompte()
	{
		require_once('./modele/DAOUtilisateur.class.php');
		$result = true;
		if (!ISSET($_REQUEST['username'])
			or !ISSET($_REQUEST['password'])
			or !ISSET($_REQUEST['confirm'])
			or !ISSET($_REQUEST['nom'])
			or !ISSET($_REQUEST['prenom']))
				$result = false;

		if (ISSET($_REQUEST['username']) and 
			DAOUtilisateur::findByUsername($_REQUEST['username']) != null){
			$_REQUEST["field_messages"]["username"] = "L'identifiant existe d&eacute;ja";
			$result= false;
		}
		if (ISSET($_REQUEST['username']) and trim($_REQUEST['username']) == "")
		{
			$_REQUEST["field_messages"]["username"] = "Entr&eacute; votre identifiant";
			$result = false;
		}	
		if (ISSET($_REQUEST['nom']) and trim($_REQUEST['nom']) == "")
		{
			$_REQUEST["field_messages"]["nom"] = "Entr&eacute; votre nom";
			$result = false;
		}	
		if (ISSET($_REQUEST['prenom']) and trim($_REQUEST['prenom']) == "")
		{
			$_REQUEST["field_messages"]["prenom"] = "Entr&eacute; votre pr&eacute;nom";
			$result = false;
		}
		if (ISSET($_REQUEST['password']) and trim($_REQUEST['password']) == "")
		{
			$_REQUEST["field_messages"]["password"] = "Mot de passe obligatoire";
			$result = false;
		}	
		if (ISSET($_REQUEST['confirm']) and trim($_REQUEST['confirm']) == "")
		{
			$_REQUEST["field_messages"]["confirm"] = "Confirmez le mot de passe";
			$result = false;
		}
		if (ISSET($_REQUEST['password']) and (ISSET($_REQUEST['confirm']))
		 and trim($_REQUEST['confirm']) != trim($_REQUEST["password"]))
		{
			$_REQUEST["field_messages"]["confirm"] = "Les mots de passe ne correspondent pas";
			$result = false;
		}	
		return $result;
	}
}