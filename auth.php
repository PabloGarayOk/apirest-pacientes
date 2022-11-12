<?php
    require_once 'clases/auth.class.php';
    require_once 'clases/respuestas.class.php';

    $_auth = new Auth;
    $_respuestas = new Respuestas;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $postBody = file_get_contents("php://input");
        // echo "Hola auth\n";
        $datosArray = $_auth->login($postBody); // Damos una respuesta a los datos enviados de login
        print_r(json_encode($datosArray));
        
    }else{
        echo "Metodo no permitido";
    }
?>