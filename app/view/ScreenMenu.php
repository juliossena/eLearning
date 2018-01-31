<?php

$requiresSM[] = 'app/view/Screen.php';
$requiresSM[] = 'app/models/Rotas.php';

for ($i = 0 ; $i < count($requiresSM) ; $i ++) {
    while (!file_exists($requiresSM[$i])) {
        $requiresSM[$i] = '../' . $requiresSM[$i];
    }
    require_once $requiresSM[$i];
}

abstract class ScreenMenu extends Screen {
	private $usuario;
	
	public function __construct(Users $usuario) {
		$this->usuario = $usuario;
	}
	
	public function getUser() {
	    return $this->usuario;
	}
	
	private function getMenu(Users $user) {
	    
		$return = '
				<input type="checkbox" id="check">
				<input type="checkbox" id="checkNovaPagina">
				<div id="novaPagina"><div id="dadosNovaPagina"></div></div><label for="checkNovaPagina" id="fecharNovaPagina" for="checkNovaPagina">X</label>
				<label for="check"><i class="fa fa-bars" aria-hidden="true" id = "icone"></i></label>
				<div class="barra">
					<nav>
                        <a href="?site='.Rotas::$LOGOFF.'"><div class="imgUsuario"><img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$user->getEmail().'"><p>'.$user->getName().'</p></div></a>';
		for ($i = 0 ; $i < $user->getPermissions()->count() ; $i++) {
		    $permission = $user->getPermissions()->offsetGet($i);
		    if ($permission instanceof Permission) {
		        if ($permission->getIsMenu()) {
		            $return .= '<a onclick="carregarPagina('."'#informacoes','index.php?site=".$permission->getLink()."'".')"><div class="btnMenu"><img src="imagens/'.$permission->getLink().'.png"><p class="textMenu">'.$permission->getMenu().'</p></div></a>
';
		        }
		    }
		}
						
						
		$return .= '
            <a href="?site='.Rotas::$LOGOFF.'"><div class="btnMenu"><img src="imagens/sair.png"><p>Salir</p></div></a>
            </nav>
				</div>
				<label id="botaoAbrir" for="check"><img src="imagens/seta.png"></label>
				<div id="fundo"></div>';
		
		return $return;
	}
	public function getCorpo() {
		return $this->getMenu($this->usuario).'
		<nav id="informacoes">
			'.$this->getInformacoes().'
		</nav>';
	}
	
	public abstract function getInformacoes();
}