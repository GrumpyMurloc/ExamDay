<?php 
include_once('./modele/DAOExamen.class.php');
include_once('./modele/classes/Examen.class.php');

if (!ISSET($_SESSION))
		session_start();
	$length = 10;
	if (!ISSET($_SESSION["pagination"]["examen"]))
		$_SESSION["pagination"]["examen"]=0;
	$start = $_SESSION["pagination"]["examen"];
	$realStart = $start+1;
	$userID = $_SESSION["connecte"]->getID();
	$examens = DAOExamen::pagination($start,$length+1,$userID);
	$count = count($examens);
	if($count){ 
	$waitThereIsMore = $count > $length;
	if ($waitThereIsMore)
		$realEnd = $realStart+$length-1;
	else
		$realEnd = $realStart+$count-1;
	?>
<h3> Examens </h3>
<div style='width:<?=$useTableWidth?>'>
<div class='exam_list'>
	<div style='padding:20px'>
	<?php 
		//echo $count;
		echo ("Examen ".$realStart." &agrave; ".$realEnd." sur ".
				(DAOExamen::countEntries($userID))."<br />");
		if ($realStart>1) {?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examen&direction=left">
			<button>Précédent</button></a>
		<?php } else {
			echo(
				"<a href='.'><button disabled>Précédent</button></a>");
		} 
		if ($waitThereIsMore) { ?>
			<a href="?action=turnpage&pagesize=<?= $length ?>&content=examen&direction=right"><button>Suivant</button></a>
		<?php }
		else {
			echo(
				"<a href='.'><button disabled>Suivant</button></a>");
		} ?>
	<table class='exam_table'>
		<tr>
			<td>
				<a href='.?action=ajouter&content=examen'>Cr&eacute;er un nouvel 	examen...</a>
			</td>
		</tr>
<?php foreach ($examens as $exam) { ?>
	<tr>
		<td><?php echo $exam->getTitre() ?></td>
		<td><a href='.?action=gerer&content=examen&id=<?=$exam->getID()?>'>Gérer</a></td>
		<td><a href='.?action=afficher&content=codegeneration&examid=<?=$exam->getID()?>'>Obtenir des codes d'acc&egrave;s</a></td>
		<td><?php echo($exam->getPonderation())?> pts</td>
		<td><?php if($exam->getDisponible()){ ?>
			<span class='exam_disponible'>
				disponible
			</span>
		<?php }else{ ?>
			<span class='exam_disponible'>
				non disponible
			</span>
		<?php } ?>
		</td>
		<td><a href='.?action=supprimer&content=examen&id=<?=$exam->getID()?>'>Supprimer</a></td>
	</tr>
<?php } 
	}
	else {
		echo "<h3>Aucun examen</h3>";
		echo "<a href='.?action=ajouter&content=examen'>Cr&eacute;er un nouvel 	examen</a>";
	}
?>
</table>
</div>
</div>
</div>