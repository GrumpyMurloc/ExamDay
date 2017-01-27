<?php
	include_once("./modele/DAOQuestion.class.php");
	include_once("./modele/classes/Utilisateur.class.php");
	if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["questionAjoutable"]))
		$_SESSION["pagination"]["questionAjoutable"]=0;
	$start = $_SESSION["pagination"]["questionAjoutable"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$questionsAjoutables = DAOQuestion::pagination($start,$length+1,$userID);
	$questionExamResult =  DAOQuestionExamen::findByExamen($examID);
	$count = count($questionsAjoutables);
	if($count){ 
	$waitThereIsMore = $count > $length;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length-1;
	else
		$realEnd = $realStart+$count-1;
?>
<h3> Questions pouvant &ecirc;tre ajout&eacute;es &agrave; l'examen: </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='question_list'>
	<div style='padding:20px'>
	<?php 
		echo (
				"Questions ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOQuestion::countEntries($userID)-DAOQuestionExamen::countEntries($examID))."<br />");
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=questionAjoutable&direction=left&id=<?=$examID?>">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=questionAjoutable&direction=right&id=<?=$examID?>"><button>Suivant</button></a>
		<?php }
		else {
			echo(
				"<a href='.'><button disabled>Suivant</button></a>");
		} ?>
	<table class='question_table'>
		<br /><a href='.?action=ajouter&content=question'>Cr&eacute;er une nouvelle question...</a>
<?php 
$i = 0;
foreach ($questionsAjoutables as $q) { 
	$i = $i+1;
	$color = ($i%2==1)?"#BBBBBB":"#B0B0B0";
	?>

		<tr style='background-color:<?= $color ?>'>
			<td><?php echo $q->getTitre(); ?></td>
			<td><?php echo $q->getQuestionType(); ?></td>
			<td><?php echo $q->getEnonce(); ?></td>
		</tr>
		<tr style='background-color:<?= $color ?>'>
			<form action='.'>
				<input type="hidden" name="action" value="ajouter"></input>
				<input type="hidden" name="content" value="questionexamen"></input>
				<input type="hidden" name="examid" value="<?= $_REQUEST["id"] ?>"></input>
				<input type="hidden" name="questionid" value="<?= $q->getID() ?>"></input>
				<input type="hidden" name="id" value='<?=$examID?>'></input>
				<td>
					<a href='.?action=gerer&content=question&id=<?=$q->getID()?>'>
						G&eacute;rer
					</a>
				</td>
				<?php if (in_array($q, $questionExamResult)){ 
					echo "<td></td><td>D&eacute;j&agrave; ajout&eacute;</td>";
				} else { ?>
					<!-- ajoutable -->
					<td>
						<!-- <a href='.?action=ajouter&content=questionexamen&examid=<?=$_REQUEST["id"]?>&questionID=<?=$q->getID()?>'>
							Ajouter
						</a> -->
						<input type='text' placeholder="Poids dans l'examen" name="poids"></input>
					</td>
					<td>
						<button type='submit'> Ajouter </button>
					</td>
			</form>
		</tr>
<?php }
	}
	} else {
		echo "<h3>Aucune question &eacute; ajouter</h3>";
		echo "<a href='.?action=ajouter&content=question'>Cr&eacute;er un nouvelle	question</a>";
	}?>
</table>
</div>
</div>
</div>