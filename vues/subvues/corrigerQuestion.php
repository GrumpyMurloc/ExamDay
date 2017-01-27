<?php 
//$questionID = passé implicitement par la vue appellante
$examID = $_REQUEST["examid"];
include_once("./modele/DAOQuestion.class.php");
include_once("./modele/DAOQuestionExamen.class.php");
include_once("./modele/DAOExamenQuestionExamenEleve.class.php");
$question = DAOQuestion::find($questionID);
$poids = DAOQuestionExamen::findPoids($questionID,$examID);
$reponse = DAOExamenQuestionExamenEleve::find($examID,$questionID,$exel);
?>
<div class='render_examen_question'>
	<div><h3> Titre de la question</h3></div>
	<h4>&Eacute;nonc&eacute;:</h4><br />
	<p><?=$question->getEnonce()?></p><br />
	<h4>R&eacute;ponse donn&eacute;e:</h4><br />
	<p><?=$reponse->getReponse()?></p><br />
	<label for='note_<?=$questionID?>'>
		Note sur <?=$poids?> points:
	</label><br />
	<input type='text' id='note_<?=$questionID?>' 
		name='note_<?=$questionID?>' class='form-control'></input>
	<label for='commentaire_<?=$questionID?>'>Commentaire:</label><br />
	<textarea id='commentaire_<?=$questionID?>' 
		name='commentaire_<?=$questionID?>' class='form-control'></textarea>
</div>