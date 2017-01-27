<?php 
include_once("./modele/classes/Code.class.php");
include_once("./modele/DAOExamen.class.php");
if(!ISSET($_SESSION)) session_start();
$examID = $_REQUEST["examid"];
$exam = DAOExamen::find($examID);
?>
<html>
<head>
	<?php include_once("./vues/subvues/head.php"); ?>
</head>
<body>
	<div>
		<?php include_once("./vues/subvues/banner.php"); ?>
		<h2>G&eacute;n&eacute;ration de code d'acc&egrave;s</h2>
		<h3>Examen
			<a href='index.php?action=gerer&content=examen&id=<?=$examID?>'>
				<span class='exam_title'>
					<?=$exam->getTitre()?>
				</span>
			</a>
		</h3>
		<form>
			<input type='hidden' name="action" value='ajouter' />
			<input type='hidden' name="content" value='code_examen' />
			<input type='hidden' name='examid' value="<?=$examID?>" />
			<label for='nbr'> Nombre de codes &agrave; g&eacute;n&eacute;rer </label><br />
			<input type='text' id='nbr' name='nbr' value='1' />
			<input type='submit' value='G&eacute;n&eacute;rer' />
		</form>
	</div>
	<?php if (ISSET($_SESSION["generatedCodes"])) {
		?> <div>
		<p>Codes d'acc&egrave;s &agrave; usages uniques pour l'examen 
			<span class='exam_title'>
				<?=$exam->getTitre()?>
			</span>
		</p>
		<p>
			Veuillez copier ces codes quelque part,
			 puis les distribuer &agrave; vos &eacute;l&egrave;ves
		</p><br /> 
		<?php 
		foreach($_SESSION["generatedCodes"] as $c){
			echo $c->getCode()."<br />";
		}
		echo "</div>";	
	}
	UNSET($_SESSION["generatedCodes"]);
	include_once("./vues/subvues/footer.php"); ?>
</body>
</html>