<?php
class ObjectException extends Exception {
	
	public function __construct($mensagem) {
		parent::__construct($mensagem);
	}
}