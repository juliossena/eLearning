<?php

require_once '../app/view/login/TLogin.php';
require_once '../app/controller/view/CTela.php';


class CTelaLogin extends CTela {
	
    public function getScreen() {
		$tela = new TLogin();
		
		return $tela;
	}

}