<?php
class LoginException extends Exception {
	function __construct($mensagem) {
		
		parent::__construct($mensagem);
	}
}