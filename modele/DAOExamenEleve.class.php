	<?php
include_once('./modele/Database.class.php'); 
include_once('./modele/classes/ExamenEleve.class.php'); 

class DAOExamenEleve
{	
	public static function getEmpty(){
		return new ExamenEleve();
	}

	public static function create($x) {
		$request = (
			"INSERT INTO Examen_eleve
			(examenID, eleveID,	commentaire, complet)
			VALUES (:w,:x,:y,:z)");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(
				":w"=>$x->getExamID(),
				":x"=>$x->getEleveID(),
				":y"=>$x->getCommentaire(),
				":z"=>$x->getComplet()
				));
			$pstmt->closeCursor();
			$db = null;
		}
		catch(PDOException $e){
			echo "error PDOException DAOExamenEleve::create<br />";
			$pstmt->closeCursor();
			$db = null;
			return -1;	
		}
	}

	public static function pagination($start, $length, $compteID){
		$request =(
			"SELECT * from examen_eleve 
			WHERE eleveID = :x 
			ORDER BY 1 LIMIT ".$start.",".$length);
		$qs = [];
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x" => $compteID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new ExamenEleve();
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

	public static function paginationAccessibles($start, $length, $compteID){
		$request =(
			"SELECT * from examen_eleve 
			WHERE eleveID= :x AND complet = 0 
			ORDER BY 1 LIMIT ".$start.",".$length);
		//echo $query."<br />";
		$qs = [];
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x" => $compteID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new ExamenEleve();
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

	public static function paginationCompletes($start, $length, $compteID){
		$request =(
			"SELECT * from examen_eleve 
			WHERE eleveID=:x 
			AND complet = 1 
			ORDER BY 1 LIMIT ".$start.",".$length);
		//echo $query."<br />";
		$qs = [];
		try{
			$db = Database::getInstance();
			$pstmt = $db->prepare($request);
			$pstmt->execute(array(":x" => $compteID));
			while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){ 
				$p = new ExamenEleve();
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

	public static function countEntries($compteID, $status=-1){
		try {
			if ($status==0)
				$requete = (
					'SELECT COUNT(examenID) somme 
					FROM EXAMEN_ELEVE 
					WHERE complet=0 
					AND eleveID=:x');
			else if ($status==1)
				$requete = (
					'SELECT COUNT(examenID) somme 
					FROM EXAMEN_ELEVE 
					WHERE complet=1 
					AND eleveID=:x');
			else
				$requete = (
					'SELECT COUNT(examenID) somme 
					FROM EXAMEN_ELEVE 
					WHERE eleveID=:x');			
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(":x"=>$compteID));
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

	public static function findByUser($userID)
	{ 
		$liste = [];
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare('SELECT * FROM examen_eleve WHERE eleveID=:x');
			$pstmt->execute(array(':x' => $userID));
		    while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){
		    	//echo "wut <br />";
				$p = new ExamenEleve();
				$p->loadFromObj($row);
				$liste[] = $p;
		    }
			$pstmt->closeCursor();
		    $db = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    $pstmt->closeCursor();
			$db = null;
		}	
	    return $liste;
	}

	public static function findByExamen($examenID)
	{ 
		$liste = [];
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare('SELECT * FROM examen_eleve WHERE examenID=:x');
			$pstmt->execute(array(':x' => $examenID));
		    while ($row = $pstmt->fetch(PDO::FETCH_OBJ)){
		    	//echo "wut <br />";
				$p = new ExamenEleve();
				$p->loadFromObj($row);
				$liste[] = $p;
		    }
			$pstmt->closeCursor();
		    $db = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    $pstmt->closeCursor();
			$db = null;
		}	
		return $liste;
	}	
	
	public static function find($eleveID, $examID){
		try { 
			$db = Database::getInstance();
			$pstmt = $db->prepare(
				"SELECT * FROM examen_eleve 
				WHERE eleveID = :x 
				AND examenID=:y");
			$pstmt->execute(array(
				':x' => $eleveID,
				':y' => $examID));
			$result = $pstmt->fetch(PDO::FETCH_OBJ);
			$pstmt->closeCursor();
			$db = null;
			if ($result){
			$p = new ExamenEleve();
				$p->loadFromObj($result);
				return $p;
			}
		}
		catch (PDOException $e){ 
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
		return null;
	}

	public static function completer($x){
		$requete = (
			"UPDATE examen_eleve 
			SET complet = 1
			WHERE examenID = :x AND eleveID = :y");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(
				":x"=>$x->getExamID(),
				":y"=>$x->getEleveID()));
			$pstmt->closeCursor();
			$db = null;
			return null;
		} 
		catch(PDOException $e){
			echo "error PDOException DAOExamEleve::completer<br />";
			return -1;
		}
	}
	
	public static function commenter($x){
		$requete = (
			"UPDATE examen_eleve 
			SET commentaire = :x 
			WHERE examenID = :y
			AND eleveID = :z");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(
				":x" => $x->getCommentaire(),
				":y" => $x->getExamID(),
				":z" => $x->getEleveID()));
			$pstmt->closeCursor();
			$db = null;
			return null;
		} 
		catch(PDOException $e){
			throw $e;
			$pstmt->closeCursor();
			$db = null;		}
	}

	public static function corriger($x){
		$requete = (
			"UPDATE examen_eleve 
			SET corrected = 1
			WHERE examenID = :x 
			AND eleveID = :y");
		try {
			$db = Database::getInstance();
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(
				":x" => $x->getExamID(),
				":y" => $x->getEleveID()));
			$pstmt->closeCursor();
			$db = null;
		} 
		catch(PDOException $e){
			$pstmt->closeCursor();
			$db = null;
			throw $e;
		}
	}

	public static function delete($x) {
		try
		{
			$db = Database::getInstance();
			$requete = (
				"DELETE FROM examen_eleve 
				WHERE examenID = :x 
				AND eleveID = :y");
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(
				":x" => $x->getExamID(),
				":y" => $x->getEleveID()));
			$requete = (
				"DELETE FROM exam_question_exam_eleve 
				WHERE examen_eleveExamenID=:x 
				AND examen_eleveEleveID=:y");
			$pstmt = $db->prepare($requete);
			$pstmt->execute(array(
				":x" => $x->getExamID(),
				":y" => $x->getEleveID()));
			$pstmt->closeCursor();
			$db = null;			
		}
		catch(PDOException $e)
		{
			throw $e;
			$pstmt->closeCursor();
			$db = null;
		}
	}
}
?>