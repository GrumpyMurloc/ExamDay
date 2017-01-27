<?php
	include_once("./modele/DAOQuestion.class.php");
	include_once("./modele/DAOQuestionExamen.class.php");
	include_once("./modele/classes/Utilisateur.class.php");
	if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["questionAjoutee"]))
		$_SESSION["pagination"]["questionAjoutee"]=0;
	$start = $_SESSION["pagination"]["questionAjoutee"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$examID = $_REQUEST["id"];
	$questions = DAOQuestionExamen::paginationExam($start,$length+1,$examID);
	$news = [];
	$currents = [];
	$QuestionExamResult =  DAOQuestionExamen::findByExamen($examID);
	foreach($questions as $potential)
		if (in_array($potential, $QuestionExamResult))
			$currents[] = $potential;
		else 
			$news[] = $potential;
	//using fake userID at the moment
	$count = count($questions);
	if($count){
	$waitThereIsMore = $count > $length;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length-1;
	else
		$realEnd = $realStart+$count-1;
?>
<h3> Questions pr&eacute;sentes dans l'examen: </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='question_list'>
	<div style='padding:20px'>
	<?php 
			echo (
				"Questions ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOQuestionExamen::countEntries($examID))."<br />");
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=questionAjoutee&direction=left&id=<?=$examID?>">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=questionAjoutee&direction=right&id=<?=$examID?>"><button>Suivant</button></a>
		<?php }
		else {
			echo(
				"<a href='.'><button disabled>Suivant</button></a>");
		} ?>
	<table class='question_table'>
		<tr>
			<td>
				<a href='.?action=ajouter&content=question'>Cr&eacute;er une nouvelle question...</a>
			</td>
		</tr>
		<tr>
			<td>Titre</td>
			<td>Poids</td>
		</tr>
<?php 
$i = 0;
foreach ($questions as $q) {
	$i = $i+1;
	?>
	<tr>
		<td><?php echo $q->getTitre() ?></td>
		<td>
			<form action="index.php">
				<input type='text' name="poids" value= <?php echo(DAOQuestionExamen::findPoids($q->getID(),$examID)) ?> name="poids"></input>
				<input type="hidden" name="action" value="gerer"></input>
				<input type="hidden" name="content" value="poids"></input>
				<input type="hidden" name="questionid" value='<?= $q->getID() ?>'></input>
				<input type="hidden" name="examid" value="<?=$examID?>"></input>
				<button type='submit'>Modifier le poids</button>
			</form>
		</td>	
		<td><a href='.?action=gerer&content=question&id=<?=$q->getID()?>'>G&eacute;rer</a></td>
		<td><a href='.?action=supprimer&content=question&id=<?=$q->getID()?>'>Supprimer</a></td>
	</tr>
<?php }
	}else{
		echo "<h3>Aucune question dans l'examen</h3>";
		echo "<a href='.?action=ajouter&content=question'>Cr&eacute;er un nouvelle	question</a>";
	} ?>
</table>
</div>
</div>
</div>