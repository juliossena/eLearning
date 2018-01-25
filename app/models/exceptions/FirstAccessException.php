<?php 
class FirstAccessException extends Exception {
	function __construct($mensagem) {
		parent::__construct($mensagem);
	}
}
?>