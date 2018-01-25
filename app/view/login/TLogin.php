<?php

$requires = "";
$requires[] = 'app/view/Screen.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class TLogin extends Screen {
	
	private $msgUsuarioInvalido;
	
	public function setMsgUsuarioInvalido($msgUsuarioInvalido) {
		$this->msgUsuarioInvalido = $msgUsuarioInvalido;
	}
	
	public function getCorpo() {
		return '<div id="login">
       		<form id="logar" method="POST" action="index.php">
    			<img class="logo" src="imagens/logo.png"><br>
                <h1>Login</h1>
    			<input name="email" type="text" placeholder="E-mail"><br>
    			<input name="pass" type="password" placeholder="Senha"><br>
                <p id="esqueciSenha" class="link">Olvide mi contraseña</p>
    			<button type="submit">Logar</button>
    			<div id="detalhes">'.$this->msgUsuarioInvalido.'</div>
    		</form>
    			
       	</div>';
	}
}