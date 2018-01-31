<?php

$requires = "";
$requires[] = 'app/view/ScreenMenu.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class THome extends ScreenMenu {
	private $conteudo;
	
	public function getInformacoes() {
	    $return = '
            <script>$("#body").css('."'background', 'url(".'"'."imagens/background2.png".'"'.") no-repeat center center'".');
                $("#body").css('."'background-size', '100% 100%');".'
            </script>
            <p class="welcome">Bienvenidos</p>
        <div class="menuHome">';
	    for ($i = 0 ; $i < $this->getUser()->getPermissions()->count() ; $i++) {
	        $permission = $this->getUser()->getPermissions()->offsetGet($i);
	        if ($permission instanceof Permission) {
	            if ($permission->getIsMenu()) {
	                $return .= '<a onclick="carregarPagina('."'#informacoes','index.php?site=".$permission->getLink()."'".')"><img src="imagens/'.$permission->getLink().'.png"></a>
';
	            }
	        }
	    }
	    $return .= '</div>';
	    return $return;
	}
	
}