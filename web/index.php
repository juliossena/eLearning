<?php
/* error_reporting(E_WARNING);
 ini_set(�display_errors�, 1 );   */

require_once '../app/controller/ControlIndex.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

//seguran�a: Retirar inser��es de c�digo para mysql
foreach($_REQUEST as $indice => $value) {
//    $_REQUEST[$indice] = addslashes($_REQUEST[$indice]);
//    $_REQUEST[$indice] = htmlspecialchars($_REQUEST[$indice]);
}

$control = new ControlIndex();

try {
    $control->defineRota();
} catch (LoginException $ex) {
    echo "Falha no login";
}



