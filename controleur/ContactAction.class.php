<?php
require_once('./controleur/Action.interface.php');
class ContactAction implements Action {
	public function execute(){
		return "contact";
	}
}
?>