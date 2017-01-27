<?php
include_once("./modele/classes/ExamenQuestionExamenEleve.class.php");
include_once("./modele/classes/ExamenEleve.class.php");
include_once("./modele/classes/Examen.class.php");
include_once("./modele/classes/Question.class.php");
include_once('./modele/Database.class.php');

class DAOExamenQuestionExamenEleve{

	public static function getNew($examID, $questionID, $ExamenEleve){
		return new ExamenQuestionExamenEleve(
			$examID,
			$questionID,
			$ExamenEleve->getExamenID(),
			$ExamenEleve->getEleveID());
	}
	public static function create($x) {
		$request = (
			"INSERT INTO exam_question_exam_eleve
			(examen_questionExamenID, 
			examen_questionQuestionID,
			examen_eleveExamenID,
			examen_eleveEleveID)
			VALUES (:w,:x,:y,:z)");
		try
		{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(
				array(
					':w' => $x->getEQ_ExamID(),
					':x' => $x->getEQ_QuestionID(),
					':y' => $x->getEE_ExamID(),
					':z' => $x->getEE_EleveID()));
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

	public static function delete($examID,$questionID,$ExamenEleve) {
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare(
			"DELETE FROM exam_question_exam_eleve
			WHERE (
				Examen_QuestionExamenID		= :w AND 
				Examen_QuestionQuestionID	= :x AND 
				Examen_EleveExamenID		= :y AND 
				Examen_EleveEleveID 		= :z 
				)"
		);
			$pstmt->execute(array(
				':w' => $examID, 
				':x' => $questionID,
				':y' => $ExamenEleve->getExamID(),
				':z' => $ExamenEleve->getEleveID()));
			$pstmt->closeCursor();
			$db = null;
		}	
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function findForEleve($eleveID){
		try{ 
			$db = Database::getInstance();
			$liste = [];
			$request = (
				"SELECT * FROM exam_question_exam_eleve
				WHERE examen_eleveEleveID=:x");
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$eleveID));
			while ($result = $pstmt->fetch(PDO::FETCH_OBJ)){
				$p = ExamenQuestionExamenEleve::createFromObj($result);
				$liste[] = $p;
			}
			$pstmt->closeCursor();
			$db = null;
		}
		catch (PDOException $e) {
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
		return $liste;
	}

	public static function find($examID, $questionID, $ExamenEleve)
	{
		try{ 
			$db = Database::getInstance();
			$pstmt = $db->prepare(
				"SELECT * FROM exam_question_exam_eleve
				WHERE (
					Examen_QuestionExamenID		= :w AND 
					Examen_QuestionQuestionID	= :x AND 
					Examen_EleveExamenID		= :y AND 
					Examen_EleveEleveID 		= :z 
					)"
			);
			$pstmt->execute(array(
				':w' => $examID, 
				':x' => $questionID,
				':y' => $ExamenEleve->getExamID(),
				':z' => $ExamenEleve->getEleveID()
				)
			);
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result){
				$p = ExamenQuestionExamenEleve::createFromObj($result);
				$pstmt->closeCursor();
				return $p;
			}
			return null;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}
	
	public static function repondre($x,$reponse){
		try { 
			$db = Database::getInstance();
			$pstmt = $db->prepare(
				"UPDATE Exam_question_exam_eleve 
				SET reponse = :r 
				WHERE 
					Examen_QuestionExamenID		= :w AND
					Examen_QuestionQuestionID	= :x AND
					Examen_EleveExamenID		= :y AND
					Examen_EleveEleveID 		= :z "
			);
			$pstmt->execute(array(
				':r' => $reponse,
				':w' => $x->getEQ_ExamID(),
				':x' => $x->getEQ_QuestionID(),
				':y' => $x->getEE_ExamID(),
				':z' => $x->getEE_EleveID()	));
			$pstmt->closeCursor();
			$db = null;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function commenter($x,$commentaire){
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare(
				"UPDATE Exam_question_exam_eleve
				SET commentaire = :r 
				WHERE (
					Examen_QuestionExamenID		= :w AND
					Examen_QuestionQuestionID	= :x AND
					Examen_EleveExamenID		= :y AND
					Examen_EleveEleveID 		= :z 
					)"
			);
			$pstmt->execute(array(
				':w' => $x->getEQ_ExamID(),
				':x' => $x->getEQ_QuestionID(),
				':y' => $x->getEE_ExamID(),
				':z' => $x->getEE_EleveID(),
				':r' => $commentaire ));
			$pstmt->closeCursor();
			return null;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function noter($x,$note){
		try { 
			$db = Database::getInstance();
			$pstmt = $db->prepare(
				"UPDATE Exam_question_exam_eleve
				SET note = :n 
				WHERE (
					Examen_QuestionExamenID		= :w AND
					Examen_QuestionQuestionID	= :x AND
					Examen_EleveExamenID		= :y AND
					Examen_EleveEleveID 		= :z 
					)"
			);
			$pstmt->execute(array(
				':w' => $x->getEQ_ExamID(),
				':x' => $x->getEQ_QuestionID(),
				':y' => $x->getEE_ExamID(),
				':z' => $x->getEE_EleveID(),
				':n' => $note ));
			$pstmt->closeCursor();
			return null;
		}
		catch (PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}
}
?>