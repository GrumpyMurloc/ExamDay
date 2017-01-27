<?php 
//$questionID = passé implicitement par la vue appellante
//$examID = $_REQUEST["examid"];
include_once("./modele/DAOQuestion.class.php");
include_once("./modele/DAOQuestionExamen.class.php");
include_once("./modele/DAOExamenEleve.class.php");
include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
$question = DAOQuestion::find($questionID);
$ExamenEleve= DAOExamenEleve::find($eleveID, $examID);
$poids = DAOQuestionExamen::findPoids($questionID,$examID);
$corrige = DAOExamenQuestionExamenEleve::find($examID, $questionID, $ExamenEleve);
?>
<!--
TEMP questionID = <?=$questionID?><br />
TEMP examID = <?=$examID?>
-->
<div class='render_examen_question'>
	<div style="float:right"><?=$corrige->getNote()?>/<?=$poids?></div>
	<div><h3> Titre de la question</h3></div>
	<h4>&Eacute;nonc&eacute; de la question:</h4><br />
	<p><?=$question->getEnonce()?></p><br />
	<h6>R&eacute;ponse &agrave; la question:</h6><br />
	<p><?=$corrige->getReponse()?></p></p><br />
	<!-- <h6>Commentaire sur la question:</h6><br /> -->
	<p style='color:darkgreen'><i><?=$corrige->getCommentaire()?></i></p>
</div>