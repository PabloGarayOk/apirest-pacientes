<?php
    require_once 'clases/auth.class.php';
    require_once 'clases/respuestas.class.php';

    $_auth = new Auth;
    $_respuestas = new Respuestas;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // Parte 1 - Recibir datos
        $postBody = file_get_contents("php://input");
        // echo "Hola auth\n";
        // Parte 2 - Enviar datos al manejador
        $datosArray = $_auth->login($postBody); // Damos una respuesta a los datos enviados de login
        // Parte 3 - Devolver una respuesta
        // print_r(json_encode($datosArray)); // Para depurar usamos esto
        header('Content-Type: application/json'); // Le decimos al header que enviamos una respuesta json
        if(isset($datosArray["result"]["error_id"])){ // Si existe alguna respuesta/error de cualquier tipo
            $responseCode = $datosArray["result"]["error_id"]; // Almacenamos la respuesta/error
            http_response_code($responseCode); // Capturamos nuesta respuesta/error
        }else{
            // Si esta todo Ok la respuesta/error seria un 200
            http_response_code(200);
        }
        // Enviamos la respuesta
        echo json_encode($datosArray); // Usamos echo porque al momento de codificarlo como json lo estamos convirtiendo en un string

        
    }else{
        // En el caso de que envien un Metodo no permitido;
        // echo "Metodo no permitido"; // Primera depuracion
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405(); // Error 405 envia: "Metodo no permitido"
        // Enviamos la respuesta
        echo json_encode($datosArray);
    }
?>