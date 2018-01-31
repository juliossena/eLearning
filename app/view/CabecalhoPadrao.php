<?php 

$requires = "";
$requires[] = 'app/view/Cabecalho.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class CabecalhoPadrao extends Cabecalho {
	public function getCabecalho() {
		return '
                	<title>CERTEI!!!</title>
                	<meta name="viewport" content="width=device-width">
                    <link rel="stylesheet" href="js/bootstrap.min.css">
                	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
                	<script type="text/javascript" src="js/script.js"></script>
                    <script type="text/javascript" src="js/comandos.js"></script>
                    <script type="text/javascript" src="js/lateralMenu.js"></script>
                	<link rel="stylesheet" type="text/css" href="css/style.css"/>
                    
				';
	}
}
?>
