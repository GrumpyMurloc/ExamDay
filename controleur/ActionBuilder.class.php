
<?php
require_once('./controleur/AfficherAction.class.php');
require_once('./controleur/EtudiantAjouterAction.class.php');
require_once('./controleur/EtudiantMetierAction.class.php');
require_once('./controleur/EnseignantMetierAction.class.php');
require_once('./controleur/EnseignantAjouterAction.class.php');
require_once('./controleur/AjouterCompteAction.class.php');
require_once('./controleur/DefaultAction.class.php');
require_once('./controleur/GererAction.class.php');
require_once('./controleur/CorrigerAction.class.php');
require_once('./controleur/LoginAction.class.php');
require_once('./controleur/LogoutAction.class.php');
require_once('./controleur/PaginationAction.class.php');
require_once('./controleur/SupprimerAction.class.php');
require_once('./controleur/OuvrirAction.class.php');
require_once('./controleur/ContactAction.class.php');
class ActionBuilder{
	public static function getAction($nom){
		/*	most actions aren't allowed to a non-connected users
		 	therefore, we split into two switch-case
		 	One for logged-in users, one for non-logged-in users */
		if (!ISSET($_SESSION)) session_start();
		if (ISSET($_SESSION["connecte"])){
			// then user is logged in, no need to verify it ever again
			if ($_SESSION["connecte"]->getUserType() == "enseignant"){
				switch ($nom)
				{
					case "contact":
						return new ContactAction();
					break;
					case "logout" :
						return new LogoutAction();
					break; 
					case "ouvrir" :
						return new OuvrirAction();
					break; 
					case "afficher" :
						return new AfficherAction();
					break;
					case "corriger" :
						return new CorrigerAction();
					break; 
					case "ajouter" :
						return new EnseignantAjouterAction();
					break;
					case "soumettre_correction":
						return new EnseignantMetierAction();
					break;
					case "supprimer" :
						return new SupprimerAction();
					break; 
					case "turnpage" :
						return new PaginationAction();
					break;
					case "gerer" :
						return new GererAction();
					break;
					default :
						return new DefaultAction();
				}
			}
			else if ($_SESSION["connecte"]->getUserType() == "etudiant"){
				switch ($nom)
				{
					case "contact":
						return new ContactAction();
					break;
					case "logout" :
						return new LogoutAction();
					break; 
					case "afficher" :
						return new AfficherAction();
					break; 
					case "ajouter" :
						return new EtudiantAjouterAction();
					break; 
					case "soumettre_examen":
						return new EtudiantMetierAction();
					break;
					case "passer_examen":
						return new EtudiantMetierAction();
					break;
					/* //until proven otherwise, student cannot delete anything.
					case "supprimer" :
						return new SupprimerAction();
					break; */
					case "turnpage" :
						return new PaginationAction();
					break;
					case "gerer" :
						return new GererAction();
					break;
					default :
						return new DefaultAction();
				}
			}
		} else {
			//user is not logged in
			switch ($nom)
			{
				case "contact":
					return new ContactAction();
				break;
				case "login" :
					return new LoginAction();
				break;  
				case "ajouter" :
					return new AjouterCompteAction();
				break; 
				default :
					return new DefaultAction();
			}
		}
	}
}
?>
