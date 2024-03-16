<?php
    require_once 'token.class.php';

    $_token = new Token();
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('Y-m-d H:i:s');    
    echo $_token->actualizarToken($fecha);
?>