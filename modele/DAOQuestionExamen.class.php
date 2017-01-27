<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/Question.class.php'); 
include_once('./modele/classes/Examen.class.php'); 
//include_once('./classes/Enseignant.class.php'); 

class DAOQuestionExamen
{	
	public static function create($questionID,$examenID,$poids) {
		$request = (
			"INSERT INTO examen_question (Examenid, Questionid, poids)
			VALUES  (:x,:y,:z)");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x"=> $examenID,
				":y"=> $questionID,
				":z"=> $poids
				));
			$pstmt->closeCursor();
			$db = null;
		} catch(PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}
	public static function paginationExam($start, $length, $ID){
		return DAOQuestionExamen::paginationExamen($start, $length, $ID);
	}
	
	public static function countEntries($examID){
	// pass -1 for all entries
		try {
			if ($examID == -1)
				$requete = (
					'SELECT COUNT(questionID) somme 
					FROM examen_question');
			else
				$requete = (
					'SELECT COUNT(questionID) somme 
					FROM examen_question
					WHERE examenID =:x');
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			if ($examID==-1){
				$pstmt->execute();
			}
			else {
				$pstmt->execute(array(":x"=>$examID));
			} 
			$somme = $pstmt->fetchColumn();
			$pstmt->closeCursor();
			$db = null;
			return $somme;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    $pstmt->closeCursor();
			$db = null;
		    return -1;
		}	
	}	
	
	

	public static function paginationExamen($start, $length, $ID){
		$request =("SELECT * from question where id in(
			SELECT questionID from examen_question 
			WHERE examenID= :x ORDER BY 1)
			ORDER BY 1
			LIMIT ".$start.",".$length);
		$qs = [];
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":x" => $ID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new Question();
				$p->loadFromObj($row);
				$qs[] = $p;
		    }
		    $pstmt->closeCursor();
			$db = null;

		} catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
		return $qs;
	}

	public static function findByExamen($examID=-1)
	{
		try {
			$liste = [];
			$requete = "SELECT * from question 
			where id in (SELECT questionid FROM examen_question where examenid = :x)";
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(":x"=>$examID));
		    foreach($pstmt as $row) {
				$p = new Question();
				$p->loadFromArray($row);
				$liste[] = $p;
		    }
			$pstmt->closeCursor();
		    $db = null;
			return $liste;
		} catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}	
	public static function findByQuestion($questionID)
	{
		try {
			$liste = [];
			$requete = 'SELECT * from examen
			 where id in (
			 	SELECT examenid 
			 	FROM examen_question 
			 	where questionid = :x)';
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(":x"=>$questionID));
		    foreach($pstmt as $row) {
				$p = new Examen();
				$p->loadFromArray($row);
				$liste[] = $p;
		    }
			$pstmt->closeCursor();
		    $db = null;
			return $liste;
		} catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		} 
	}

	public static function findPoids($questionID,$examenID)
	{
		try {
			$db = Database::getInstance();
			$requete = (
				"SELECT poids FROM examen_question 
				WHERE questionID = :x 
				AND examenID = :y");
			$pstmt = $db->prepare($requete);
			$pstmt->execute(
				array(':x' => $questionID,':y'=> $examenID));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result)
			{
				return $result->poids;
			}
			return null;
		} catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return -1;
		}	
		
	}
	
	public static function update($questionID, $examenID, $poids)
	{
		$request =("UPDATE examen_question SET poids= :x 
		WHERE (examenID= :y AND questionID= :z)");
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(':x'=>$poids,':y'=>$examenID,':z'=>$questionID));
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
	public static function delete($questionID, $examenID) {
		try
		{
			$db = Database::getInstance();
			$request = (
				"DELETE FROM examen_question 
				WHERE questionID = :x 
				AND examenID = :y");
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$questionID,":y"=>$examenID));
			$request = (
				"DELETE FROM exam_question_exam_eleve 
				WHERE examen_questionQuestionID = :x 
				AND examen_questionExamenID = :y");
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$questionID,":y"=>$examenID));
			$pstmt ->closeCursor();
			$db = null;
		}
		catch(PDOException $e)
		{
			$pstmt ->closeCursor();
			$db = null;
			throw $e;
		}
	}	
}
?>