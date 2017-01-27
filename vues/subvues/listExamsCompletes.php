<?php 
include_once('./modele/DAOExamenEleve.class.php');
include_once('./modele/classes/ExamenEleve.class.php');
include_once('./modele/classes/Examen.class.php');
if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["examCompletes"]))
		$_SESSION["pagination"]["examCompletes"]=0;
	$start = $_SESSION["pagination"]["examCompletes"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$examCompletes = DAOExamenEleve::paginationCompletes($start,$length+1,$userID);
	$count = count($examCompletes);
	$waitThereIsMore = $count > $length;
	if($count){
	if ($count==0) $realStart = 0;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length-1;
	else
		$realEnd = $realStart+$count-1;
	?>
<h3> Examens compl&eacute;t&eacute;s </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='exam_list'>
	<?php 
		echo (	"Examen ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOExamenEleve::countEntries($userID,1))."<br />");
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examCompletes&direction=left">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examCompletes&direction=right"><button>Suivant</button></a>
		<?php } else { ?>
			<a href='.'><button disabled>Suivant</button></a>
  <?php } ?>
	<table class='exam_table'>
		<?php foreach ($examCompletes as $examComp) { ?>
		<tr>
			<td>
				<?php 
				$examID=$examComp->getExamID(); 
				$examObj = DAOExamen::find($examID);
				$titre = $examObj->getTitre();
				echo $titre 
				?>
			</td>
			<td> 
				<?php 
				if ($examComp->getCorrected()){?>
					<a href='.?action=afficher&content=correction&examid=<?=$examID?>&eleveid=<?=$userID?>'>Voir la correction</a>
				<?php 
				}else{
					echo "En attente de correction";
				}
				?>
			</td>
		</tr>
	<?php } 
	}else{
		echo "<h3>Aucun examen compl&ecirc;t&eacute</h3>";
		}?>
	</table>
	</div>
	</div>