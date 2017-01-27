<?php
#script pour remplir la db sql
include_once('./modele/Database.class.php');

include_once('./modele/classes/Utilisateur.class.php'); 
include_once('./modele/DAOUtilisateur.class.php');

include_once('./modele/classes/Question.class.php'); 
include_once('./modele/DAOQuestion.class.php'); 

include_once('./modele/classes/Examen.class.php'); 
include_once('./modele/DAOExamen.class.php'); 

include_once('./modele/DAOQuestionExamen.class.php'); 

include_once('./modele/classes/ExamenEleve.class.php'); 
include_once('./modele/DAOExamenEleve.class.php'); 

include_once('./modele/classes/ExamenQuestionExamenEleve.class.php'); 
include_once('./modele/DAOExamenQuestionExamenEleve.class.php'); 

//crétaion enseignant 1
$user = new Utilisateur("1","Elena","Smagina","hashed","enseignant1","","enseignant");
DAOUtilisateur::create($user);

//crétaion etudiant 1
$user = new Utilisateur("2","Etienne","Demers","hashed","etudiant1","","etudiant");
DAOUtilisateur::create($user);

//crétaion enseignant 2
$user = new Utilisateur("3","Pierre","Coutu","hashed","enseignant2","","enseignant");
DAOUtilisateur::create($user);

//crétaion etudiant 2
$user = new Utilisateur("2","Nicolas","Leblanc","hashed","etudiant2","","etudiant");
DAOUtilisateur::create($user);

//création de questions
$question = new Question("1","1",
	"Donnez trois commandes SQL qui NE sont PAS de type auto-commit",
	"","reponse courte","SQL commandes non auto-commit","");
DAOQuestion::create($question);

$question = new Question("2","1",
	"Donnez trois commandes SQL qui sont pas de type auto-commit",
	"","reponse courte","SQL commandes auto-commit","");
DAOQuestion::create($question);

$question = new Question("3","1",
	"Expliquez la différence entre la DB et une instance de celle-ci",
	"","reponse courte","SQL DB/instance","");
DAOQuestion::create($question);

$question = new Question("4","1",
	"Que signifie l'acronyme 'SQL'?",
	"","reponse courte","SQL acronyme","Strandard Query Langage");
DAOQuestion::create($question);

$question = new Question("5","3",
	"Que fait la classe Banque dans le programme vu en classe?",
	"","reponse courte","intro POO Banque1","Crée un objet Banque et fait un dépôt de 500$.");
DAOQuestion::create($question);

$question = new Question("6","3",
	"Quels sont le paramètre oubligatoirs pour appeler le constructeur de la classe Banque?",
	"","reponse courte","intro POO Banque2","Le nom du titulaire du compte et le solde de départ.");
DAOQuestion::create($question);

$question = new Question("7","1",
	"question access 1",
	"","reponse courte","Access tables","");
DAOQuestion::create($question);

$question = new Question("8","1",
	"question access 2",
	"","reponse courte","Access Clés étrangères","");
DAOQuestion::create($question);

$question = new Question("9","1",
	"question SQL 1",
	"","reponse courte","SQL Clés primaires","");
DAOQuestion::create($question);

//création d'examen
$exam = new Examen("1","1","25","Access-1");
DAOExamen::create($exam);

$exam = new Examen("2","1","25","Access-2");
DAOExamen::create($exam);


$exam = new Examen("3","1","25","SQL-1");
DAOExamen::create($exam);


$exam = new Examen("4","1","25","SQL-2");
DAOExamen::create($exam);


$exam = new Examen("5","3","35","Intro POO-1");
DAOExamen::create($exam);


$exam = new Examen("6","3","40","Intro POO-2");
DAOExamen::create($exam);

//création d'examenQuestion
DAOQuestionExamen::create(1,4,25);
DAOQuestionExamen::create(2,4,25);
DAOQuestionExamen::create(3,4,25);
DAOQuestionExamen::create(4,4,25);

DAOQuestionExamen::create(7,1,25);
DAOQuestionExamen::create(8,2,25);
DAOQuestionExamen::create(9,3,25);

DAOQuestionExamen::create(5,6,25);
DAOQuestionExamen::create(6,6,25);

//création de examenEleve
$examEleve = new ExamenEleve("1","2","PAS OP-TI-MAL!",1,1);
DAOExamenEleve::create($examEleve);
DAOExamenEleve::corriger($examEleve);
$examEleve = new ExamenEleve("2","2","Bon travail, BRAVO!",1,1);
DAOExamenEleve::create($examEleve);
DAOExamenEleve::corriger($examEleve);
$examEleve = new ExamenEleve("3","2","Continuez!",1,1);
DAOExamenEleve::create($examEleve);
DAOExamenEleve::corriger($examEleve);

$examEleve = new ExamenEleve("5","4","",1,1);
DAOExamenEleve::create($examEleve);
DAOExamenEleve::corriger($examEleve);
$examEleve = new ExamenEleve("6","4","",1,0);
DAOExamenEleve::create($examEleve);
DAOExamenEleve::corriger($examEleve);

//création des EQEE
$eqee = new ExamenQuestionExamenEleve("1","7","1","2");
DAOExamenQuestionExamenEleve::create($eqee);
DAOExamenQuestionExamenEleve::repondre($eqee,"reponse exam access1");
DAOExamenQuestionExamenEleve::noter($eqee,0);

$eqee = new ExamenQuestionExamenEleve("2","8","2","2");
DAOExamenQuestionExamenEleve::create($eqee);
DAOExamenQuestionExamenEleve::repondre($eqee,"reponse exam access2");
DAOExamenQuestionExamenEleve::noter($eqee,25);

$eqee = new ExamenQuestionExamenEleve("3","9","3","2");
DAOExamenQuestionExamenEleve::create($eqee);
DAOExamenQuestionExamenEleve::repondre($eqee,"reponse exam SQL1");
DAOExamenQuestionExamenEleve::noter($eqee,25);

$eqee = new ExamenQuestionExamenEleve("6","5","5","4");
DAOExamenQuestionExamenEleve::create($eqee);
DAOExamenQuestionExamenEleve::repondre($eqee,"reponse exam POO1");
DAOExamenQuestionExamenEleve::noter($eqee,20);

$eqee = new ExamenQuestionExamenEleve("6","6","6","4");
DAOExamenQuestionExamenEleve::create($eqee);
DAOExamenQuestionExamenEleve::repondre($eqee,"reponse exam POO2");
DAOExamenQuestionExamenEleve::noter($eqee,15);
?>
