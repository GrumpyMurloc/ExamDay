<?php 
class Code{
	private $code;
	private $examID;
	private $fresh;
	public function __construct($hash,$examID){
		$this->code = $hash;
		$this->examID = $examID;
		$this->fresh = true;
	}
	public function getCode()		{return $this->code;}
	public function getExamID()		{return $this->examID;}
	public function getFresh()		{return $this->fresh;}
}