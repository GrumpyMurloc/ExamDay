<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/Examen.class.php'); 

class DAOExamen
{	
	
	public static function getEmpty(){
		return new Examen();
	}

	public static function create($x) {
		$request = (
			"INSERT INTO Examen (EnseignantID, ponderation,titre) 
			VALUES (:x,:y,:z)");
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=> $x->getEnseignantID(),
				":y"=> $x->getPonderation(),
				":z"=> $x->getTitre()
				));
			$pstmt->closeCursor();
			$db = null;
		}
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function pagination($start, $length, $compteID){
		$request =(
			"SELECT * from examen 
			WHERE enseignantID= :x  
			ORDER BY 1 LIMIT $start , $length");
		// had a big problem here with start and length being 
		// passed incorrectly to prepare or something.
		// also switched to FETCH_OBJ and loadFromObj()...
		$qs = [];
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x" => $compteID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				//echo "x";
				$p = new Examen();
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
					FROM EXAMEN 
					WHERE enseignantID=:x');
			else
				$requete = (
					'SELECT COUNT(ID) somme 
					FROM EXAMEN');
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
		    print "Error!: " . $e->getMessage() . "<br/>";
		    $pstmt->closeCursor();
			$db = null;
		}	
	}
	public static function findLastExamID($userID)
	{
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare('SELECT ID FROM examen WHERE enseignantID=:x ORDER BY 1 DESC LIMIT 1');
			$pstmt->execute(array(':x' => $userID));
			$result = $pstmt->fetch();
			$pstmt->closeCursor();
			$db = null;
			return $result;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function findAll($userID=-1){
		$liste = [];
		try {
			if ($userID == -1)
				$requete = 'SELECT * FROM examen';
			else 
				$requete = 'SELECT * FROM examen WHERE enseignantID=:x';
			//$qedao = 'SELECT * from question where id in (SELECT questionid from QuestionExamen where examenid = :x);';
			//$qedao = 'SELECT * from examen where id in (SELECT examenid from QuestionExamen where questionid = :x);'  ;
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			if ($userID == -1)
				$pstmt->execute();
			else
				$pstmt->execute(array(":x"=>$userID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new Examen();
				$p->loadFromObj($row);
				$liste[] = $p;
		    }
			$pstmt->closeCursor();
		    $db = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		}	
		return $liste;
	}
	public static function find($id) {
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare("SELECT * FROM examen WHERE ID = :x");
			//requête paramétrée par un paramètre x.
			$pstmt->execute(array(':x' => $id));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result){
				$p = new Examen();
				$p->loadFromObj($result);
				return $p;
			}
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}
	public static function update($x) {
		$request = (
			"UPDATE examen 
			SET ponderation = :x, titre= :y 
			WHERE ID = :z");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=>$x->getPonderation(),
				":y"=>$x->getTitre(),
				":z"=>$x->getID()));
			$pstmt->closeCursor();
			$db = null;
		}
		catch(PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function ouvrir($x) {
		$request = (
			"UPDATE examen SET disponible=1
			WHERE ID = :x");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$x->getID()));
			$pstmt->closeCursor();
			$db = null;
		}
		catch(PDOException $e) {
			throw $e;
		}
	}

	public static function fermer($x) {
		$request = (
			"UPDATE examen SET disponible=0 
			WHERE ID = :x");
		try	{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$x->getID()));
			$pstmt->closeCursor();
			$db = null;
		}
		catch(PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function delete($examID){
		try{
			$db= Database::getInstance();
			// ExamenQuestionExamenEleve
			$pstmt_4 = $db->prepare("DELETE FROM exam_question_exam_eleve WHERE Examen_QuestionExamenID = :x");
			$pstmt_4->execute(array(':x' => $examID));
			// ExamenEleve
			$pstmt_2 = $db->prepare("DELETE FROM examen_eleve WHERE examenID = :x");
			$pstmt_2->execute(array(':x' => $examID));
			// ExamenQuestion
			$pstmt_3 = $db->prepare("DELETE FROM examen_question WHERE examenID = :x");
			$pstmt_3->execute(array(':x' => $examID));
			// CodeExamen
			$pstmt_5 = $db->prepare("DELETE FROM code_examen WHERE examenID = :x");
			$pstmt_5->execute(array(':x' => $examID));
			// Examen
			$pstmt_1 = $db->prepare("DELETE FROM examen WHERE ID = :x");
			$pstmt_1->execute(array(':x' => $examID));
			$pstmt_1->closeCursor();
			$pstmt_2->closeCursor();
			$pstmt_3->closeCursor();
			$pstmt_4->closeCursor();
			$pstmt_5->closeCursor();

			$db = null;
		}	
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}
}
?>