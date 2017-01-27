<?php 
include_once('./modele/DAOExamenEleve.class.php');
include_once('./modele/classes/ExamenEleve.class.php');
include_once('./modele/classes/Examen.class.php');
if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["examAccessibles"]))
		$_SESSION["pagination"]["examAccessibles"]=0;
	$start = $_SESSION["pagination"]["examAccessibles"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$examAccessibles = DAOExamenEleve::paginationAccessibles($start,$length+1,$userID);
	$count = count($examAccessibles);
	$waitThereIsMore = $count > $length;
	if($count){
	if ($count==0) $realStart = 0;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length;
	else
		$realEnd = $realStart+$count-1;
	?>
<h3> Examens accessibles </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='exam_list'>
	<?php 
		echo (	"Examen ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOExamenEleve::countEntries($userID,0))."<br />");
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examAccessibles&direction=left">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examAccessibles&direction=right"><button>Suivant</button></a>
		<?php } else { ?>
			<a href='.'><button disabled>Suivant</button></a>
  <?php } ?>
	<table class='exam_table'>
		<?php foreach ($examAccessibles as $examAcc) { ?>
		<tr>
			<td>
				<?php 
				$examID=$examAcc->getExamID(); 
				$examObj = DAOExamen::find($examID);
				$titre = $examObj->getTitre();
				echo $titre;
				?>
			</td>
			<td> 
				<?php 
				if ($examObj->getDisponible())
					echo "<a href='.?action=passer_examen&examid=".$examID."'>Passer l'examen</a>";	
				else
					echo "Examen actuellement ferm&eacute;";
				?>
			</td>
		</tr>
	<?php } 
	}else{
		echo "<h3>Aucun examen accessible</h3>";
	}?>
	</table>
	</div>
	</div>