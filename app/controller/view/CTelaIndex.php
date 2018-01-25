<?php

$requiresCTI[] = 'app/view/home/THome.php';
$requiresCTI[] = 'app/models/login/Usuario.php';

for ($i = 0 ; $i < count($requiresCTI) ; $i ++) {
    while (!file_exists($requiresCTI[$i])) {
        $requiresCTI[$i] = '../' . $requiresCTI[$i];
    }
    require_once $requiresCTI[$i];
}

class CTelaIndex extends CTela {
	private $user;
	
	public function __construct(Users $user) {
	    $this->user = $user;
	}
	
    public function getScreen() {
        $tela = new THome($this->user);
        
        return $tela;
    }

}