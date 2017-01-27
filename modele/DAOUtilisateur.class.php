<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/Utilisateur.class.php'); 

class DAOUtilisateur
{	
	public static function getEmpty(){
		return new Utilisateur();
	}
	public static function create($x) {

		$request = "INSERT INTO compte (nom, prenom, password, username, type)
				VALUES (:x, :y, :z, :a, :b)";
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=> $x->getNom(),
				":y"=> $x->getPrenom(),
				":z"=> md5($x->getPass()),
				":a"=> $x->getUser(),
				":b"=> $x->getUserType()
				));
			$pstmt->closeCursor();
		    $db = null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
		$x = null;
	}
	public static function findAll()
	{
		try {
			$liste = [];	
			$requete = 'SELECT * FROM compte';
			$db = Database::getInstance();		
			$res = $db->query($requete);
		    foreach($res as $row) {
				$p = new Utilisateur();
				$p->loadFromArray($row);
				$liste[] = $p;
		    }
			$res->closeCursor();
		    $db = null;
			return $liste;
		} catch (PDOException $e) {
			$res->closeCursor();
		    $db = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}	

	public static function find($id)
	{
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare("SELECT * FROM compte WHERE ID = :x");
			$pstmt->execute(array(':x' => $id));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result)
			{
				$p = new Utilisateur();
				$p->loadFromObj($result);
				return $p;
			} 
			return null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
	}

	public static function findByUsername($usr)
	{
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare("SELECT * FROM compte WHERE USERNAME = :x");
			$pstmt->execute(array(':x' => $usr));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);	
			$pstmt->closeCursor();	
			$db = null;
			if ($result)
			{
				$p = new Utilisateur();
				$p->loadFromObj($result);
				return $p;
			}	
			return null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
	}
		
	public static function update($x) {
		$request = "UPDATE compte SET 
		nom = :x, prenom = :y, username = :z, type = :a
		WHERE ID = :b";
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=>$x->getNom(),
				":y"=>$x->getPrenom(),
				":z"=>$x->getUser(),
				":a"=>$x->getUserType(),
				":b"=>$x->getID()
				));
			DAOUtilisateur::updatePass($x);
			$pstmt->closeCursor();
		    $db = null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
	}
	public static function updatePass($x) {
		$request = "UPDATE compte SET password = :x
		WHERE ID = :y";
		try { 
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>md5($x->getPass()),":y"=>$x->getID()));
			$pstmt->closeCursor();
		    $db = null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
	}
	public static function delete($x) {

		if ($x->getUserType() == "enseignant"){
			try {
				include_once("./modele/DAOExamen.class.php");
				include_once("./modele/DAOQuestion.class.php");
				//deleting exams
				foreach(DAOExamen::findAll($x->getID()) as $exam) 
					DAOExamen::delete($exam);
				//deleting questions
				foreach(DAOQuestion::findAll($x->getID()) as $question) 
					DAOExamen::delete($question);
				//deleting user
				$db = Database::getInstance();
				$request = "DELETE FROM compte WHERE ID = :x";
				$pstmt = $db->prepare($request);
				$pstmt->execute(array(":x"=>$x->getID()));
			}
			catch(PDOException $e)
			{
				throw $e;
			}
		}
		else { 
			try {
				include_once("./modele/DAOExamenEleve.class.php");
				include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
				//deleting examenquestionsexameneleve
				foreach(DAOExamenQuestionExamenEleve::findByEleve($x->getID()) as $question) 
					DAOExamen::delete($question);
				//deleting questions
				foreach(DAOExamenEleve::findByUser($x->getID()) as $exam) 
					DAOExamen::delete($exam);
				//deleting user
				$db = Database::getInstance();
				$request = "DELETE FROM compte WHERE ID = :x";
				$pstmt = $db->prepare($request);
				$pstmt->execute(array(":x"=>$x->getID()));
			}
			catch(PDOException $e)
			{
				throw $e;
			}
		}
	}
}
?>