<?php 
class ExamenQuestionExamenEleve{

	private $EQ_ExamID;
	private $EQ_QuestionID;
	private $EE_ExamID;
	private $EE_EleveID;
	private $note;
	private $commentaire;
	private $reponse;

	public function __construct($EQE_id, $EQQ_id, $EEEx_id, $EEEl_id){
		// Not going too hard on the beaver,
		// simple constructor, use mutators
		$this->EQ_ExamID		= $EQE_id;
		$this->EQ_QuestionID	= $EQQ_id;
		$this->EE_ExamID		= $EEEx_id;
		$this->EE_EleveID		= $EEEl_id;
	}

	public function setReponse($rep)		{$this->reponse = $rep;			}
	public function setCommentaire($com)	{$this->commentaire = $com;		}
	public function setNote($note)			{$this->note = $note;			}

	public function getEQ_ExamID()			{return $this->EQ_ExamID;		}
	public function getEQ_QuestionID()		{return $this->EQ_QuestionID;	}
	public function getEE_ExamID()			{return $this->EE_ExamID;		}
	public function getEE_EleveID()			{return $this->EE_EleveID;		}
	public function getNote()				{return $this->note;			}
	public function getCommentaire()		{return $this->commentaire;		}
	public function getReponse()			{return $this->reponse;			}

	public static function createFromObj($x){
		$a = new ExamenQuestionExamenEleve(
			$x->Examen_QuestionExamenid,
			$x->Examen_QuestionQuestionid,
			$x->Examen_EleveExamenid,
			$x->Examen_EleveEleveid
			);
		$a->setReponse($x->reponse);
		$a->setCommentaire($x->commentaire);
		$a->setNote(intval($x->note));
		return $a;
	}
}
?>