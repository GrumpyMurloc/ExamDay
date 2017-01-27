<?php
	include_once("./modele/DAOQuestion.class.php");
	include_once("./modele/classes/Utilisateur.class.php");
	if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["question"]))
		$_SESSION["pagination"]["question"]=0;
	$start = $_SESSION["pagination"]["question"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$questions = DAOQuestion::pagination($start,$length+1,$userID);
	//using fake userID at the moment
	$count = count($questions);
	if($count){ 
	$waitThereIsMore = $count > $length;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length-1;
	else
		$realEnd = $realStart+$count-1;
?>
<h3> Questions </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='question_list'>
	<div style='padding:20px'>
	<?php 
//		if ($realStart+1 == $realEnd)
			echo ("Questions ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOQuestion::countEntries($userID))."<br />");
		/*else
			echo (
				"Questions ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOQuestion::countEntries($userID)+1)."<br />");*/
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=question&direction=left">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=question&direction=right"><button>Suivant</button></a>
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
<?php foreach ($questions as $q) { ?>
	<tr style='background-color:#ccc'>
		<td><?=$q->getTitre()?></td>
		<td><?=$q->getQuestionType()?></td>
		<td><a href='.?action=gerer&content=question&id=<?=$q->getID()?>'>G&eacute;rer</a></td>
		<td><a href='.?action=supprimer&content=question&id=<?=$q->getID()?>'>Supprimer</a></td>
	</tr>
	<tr style='background-color:#ccc'>
		<td><?=substr($q->getEnonce(),0,32)?></td><td></td><td></td><td></td>
	</tr>
	<tr></tr>
<?php }
	} else {
		echo "<h3>Aucune question</h3>";
		echo "<a href='.?action=ajouter&content=question'>Cr&eacute;er un nouvelle	question</a>";
	}?>
</table>
</div>
</div>
</div>

