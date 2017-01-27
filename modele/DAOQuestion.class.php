<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/Question.class.php'); 
//include_once('./classes/Enseignant.class.php'); 

class DAOQuestion
{	

	public static function getEmpty(){
		return new Question();
	}

	public static function create($x) {
		$request = (
			"INSERT INTO Question (EnseignantID, enonce, choix, type, titre, reponse)
			VALUES (:x,:y,:z,:a,:b,:c)");
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=> $x->getEnseignantID(),
				":y"=> $x->getEnonce(),
				":z"=> $x->getChoix(),
				":a"=> $x->getQuestionType(),
				":b"=> $x->getTitre(),
				":c"=> $x->getReponse()
				));
			$pstmt->closeCursor();
			$db = null;
			return true;
		}
		catch(PDOException $e)
		{
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function pagination($start, $length, $compteID){
		$request =(
			"SELECT * from question 
			WHERE enseignantID= :x  
			ORDER BY 1 LIMIT $start , $length");
		$qs = [];
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x" => $compteID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new Question();
				$p->loadFromObj($row);
				$qs[] = $p;
		    }
		    $pstmt->closeCursor();
			$db = null;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
		return $qs;
	}

	public static function countEntries($enseignantID){
		// pass -1 for all entries
		try {
			if ($enseignantID!=-1)
				$requete = (
					'SELECT COUNT(ID) somme 
					FROM Question 
					WHERE enseignantID=:x');
			else
				$requete = (
					'SELECT COUNT(ID) somme 
					FROM Question');
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			if ($enseignantID!=-1){
				$pstmt->execute(array(":x"=>$enseignantID));
			}
			else {
				$pstmt->execute();
			} 
			$somme = $pstmt->fetchColumn();
			$pstmt->closeCursor();
			$db = null;
			return $somme;
		} catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return -1;
		}	
	}

	public static function findAll()
	{
		try {
			$liste = [];
			$requete = 'SELECT * FROM Question';
			$cnx = Database::getInstance();
			
			$res = $cnx->query($requete);
		    foreach($res as $row) {
				$p = new Question();
				$p->loadFromArray($row);
				$liste[] = $p;
		    }
			$res->closeCursor();
		    $cnx = null;
			return $liste;
		} catch (PDOException $e) {
			$res->closeCursor();
		    $cnx = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}	

	public static function find($id)
	{
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare("SELECT * FROM Question WHERE ID = :x");
			$pstmt->execute(array(':x' => $id));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result)
			{
				$p = new Question();
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
		$request = "UPDATE Question 
		SET enseignantID = :x, enonce = :y,
		choix = :z, type = :a, titre = :b,
		reponse = :c
		WHERE ID = :d";
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=> $x->getEnseignantID(),
				":y"=> $x->getEnonce(),
				":z"=> $x->getChoix(),
				":a"=> $x->getquestionType(),
				":b"=> $x->getTitre(),
				":c"=> $x->getReponse(),
				":d"=> $x->getID()
				));
			$pstmt->closeCursor();
		    $db = null;
		}
		catch(PDOException $e)
		{
			$pstmt->closeCursor();
		    $db = null;
			throw $e;
		}
	}
	public static function delete($x) {
		try
		{
			$db = Database::getInstance();
			// ExamenQuestionExamenEleve
			$request = (
				"DELETE FROM exam_question_exam_eleve 
				WHERE examen_questionExamenID = :x");
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$x->getID()));
			// ExamenQuestion
			$request = "DELETE FROM examen_question WHERE examenID = :x";
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$x->getID()));
			// Question
			$request = "DELETE FROM Question WHERE ID = :x";
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$x->getID()));
		}
		catch(PDOException $e)
		{
			throw $e;
		}
	}
}
?>