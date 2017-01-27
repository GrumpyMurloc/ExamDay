<?php 
//$questionID = passé implicitement par la vue appellante
$examID = $_REQUEST["examid"];
include_once("./modele/DAOQuestion.class.php");
include_once("./modele/DAOQuestionExamen.class.php");
$question = DAOQuestion::find($questionID);
$poids = DAOQuestionExamen::findPoids($questionID,$examID);
?>
<!--
TEMP questionID = <?=$questionID?><br />
TEMP examID = <?=$examID?>
-->
<div class='render_examen_question'>
	<div style="float:right">Question sur <?=$poids?> points</div>
	<div><h3> Titre de la question</h3></div>
	<h4>&Eacute;nonc&eacute; de la question:</h4><br />
	<p><?=$question->getEnonce()?></p><br />
	<label for='reponse_<?=$questionID?>'>R&eacute;ponse:</label><br />
	<textarea id='reponse_<?=$questionID?>' 
		name='reponse_<?=$questionID?>' class='form-control'></textarea>
</div>