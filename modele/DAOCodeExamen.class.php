<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/Code.class.php'); 

class DAOCodeExamen
{	
	public static function getNewCode($examID){
		$n = DAOCodeExamen::countEntriesForExam($examID);
		$c = new Code( MD5($examID."_".$n),$examID);
		DAOCodeExamen::create($c);
		return $c;
	}

	public static function create($x) {
		$request = (
			"INSERT INTO code_examen (code, examenid, fresh) 
			VALUES (:x,:y,:z)");
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			return $pstmt->execute(array(
				":x" => $x->getCode(),
				":y" => $x->getExamID(),
				":z" => $x->getFresh()
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

	public static function countEntriesForExam($examID){
		// pass -1 for all entries
		try {			
			$requete = (
				'SELECT COUNT(code) somme 
				FROM code_examen 
				WHERE examenID=:x');
			$cnx = Database::getInstance();
			$pstmt = $cnx->prepare($requete);
			$pstmt->execute(array(":x"=>$examID)); 
			$somme = $pstmt->fetchColumn();
			$pstmt->closeCursor();
			$db = null;
			return $somme;
		} 
		catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage() . "<br />";
		    $pstmt->closeCursor();
			$db = null;
			return -1;
		}	
	}

	public static function exists($code){
		try{
			$requete = (
				'SELECT COUNT(code) bool_answer
				FROM code_examen
				WHERE code=:x');
			$cnx = Database::getInstance();
			$result = $cnx->prepare($requete);
			$result->execute(array(":x"=>$code)); 
			$exists = $result->fetchColumn() == 1;
			$pstmt->closeCursor();
			$db = null;
			return $exists;
		}
		catch (PDOException $e){
			echo "Error!: " . $e->getMessage() . "<br />";
			$pstmt->closeCursor();
			$db = null;
		}
	}
	public static function find($code){
		try{
			$db = Database::getInstance();
			$requete = (
				'SELECT *
				FROM code_examen
				WHERE code = :x');
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(':x'=>$code));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null; 
			if ($result){
				$c = new Code($result->code, $result->Examenid);
				return $c;
			}
			else {
				return null;
			}
		}
		catch (PDOException $e){
			echo "Error!: " . $e->getMessage() . "<br />";
			$pstmt->closeCursor();
			$db = null;
		}
	}

	public static function findAll($userID){
		$liste = [];
		try {
			$requete = 'SELECT * FROM code_examen WHERE examenID in 
			(select ID from examen where enseignantID =:x)';
			$db = Database::getInstance();	
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(':x'=>$userID));
		    while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){
				$c = new Code();
				$c->loadFromArray($row);
				$liste[] = $c;
		    }
		    $pstmt->closeCursor();
			$db = null;
		}
		catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    $pstmt->closeCursor();
			$db = null;
		}	
	    return $liste;
	}

	public static function findByExam($examID){
		try { 
		$db = Database::getInstance();
		$pstmt = $db->prepare(
			"SELECT * FROM code_examen 
			WHERE examID = :x");
		$pstmt->execute(array(':x' => $examID));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		$pstmt->closeCursor();
		$db = null;
		if ($result){
		$p = new Code();
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

	public static function useCode($code) {
		$request = "UPDATE code_examen SET fresh=0 WHERE code = :x";
		//echo $request;
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=>$code));
			$pstmt->closeCursor();
			$db = null;
			return true;
		}
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function delete($x) {
		$request = "DELETE FROM code_examen WHERE code =:x";
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x"=> $x->getCode()));
			$pstmt->closeCursor();
			$db = null;
			return true;
		}
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}	
}
?>