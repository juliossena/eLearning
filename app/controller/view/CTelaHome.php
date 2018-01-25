<?php

$requiresCTH[] = 'app/view/home/THome.php';
$requiresCTH[] = 'app/models/users/Users.php';

for ($i = 0 ; $i < count($requiresCTH) ; $i ++) {
    while (!file_exists($requiresCTH[$i])) {
        $requiresCTH[$i] = '../' . $requiresCTH[$i];
    }
    require_once $requiresCTH[$i];
}

class CTelaHome extends CTela {
	private $user;
	private $screen;
	
	public function __construct(Users $user) {
	    $this->user = $user;
	}
	
	public function getScreen() {
		$this->screen = new THome($this->user);
		return $this->screen;
	}
}