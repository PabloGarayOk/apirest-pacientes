<?php
    require_once 'clases/respuestas.class.php';
    require_once 'clases/pacientes.class.php';

    $_respuestas = new Respuestas;
    $_pacientes = new Pacientes;

    if($_SERVER['REQUEST_METHOD'] == "GET"){ // Metodo READ
        if(isset($_GET["id"])){ // Si solicitan los datos de un paciente
            $id = $_GET["id"];
            $datosPaciente = $_pacientes->getPaciente($id);
            header('Content-Type: application/json'); // Enviamos los headers
            echo json_encode($datosPaciente); // Convertimos el json
            http_response_code(200); // Enviamos los codigos de error
        }else if(isset($_GET["page"])){ // Si enviaron la pagina
            $pagina = $_GET["page"];
            $listarPacientes = $_pacientes->getPacientes($pagina); // Obnenemos los datos de los pacientes
            header('Contenr-Type: application/json'); // Enviamos los headers
            echo json_encode($listarPacientes); // Convertimos el json en string
            http_response_code(200); // Enviamos los codigos de error.
        }else if(isset($_GET["total"])){ // Si solicitan el total de registros
            $total = $_pacientes->getTotalPacientes(); // Obtenemos la cantidad de pacientes
            header('Content-Type: application/json'); // Enviamos los headers
            echo json_encode(array("total" => $total)); // Devolvemos solo el total como respuesta
            http_response_code(200); // Enviamos los códigos de error.
        }else{
            // Sino envian pagina se muestran todos los datos
            $pagina = 0;
            $listarPacientes = $_pacientes->getPacientes($pagina); // Obnenemos los datos de los pacientes
            header('Contenr-Type: application/json'); // Enviamos los headers
            echo json_encode($listarPacientes); // Convertimos el json en string
            http_response_code(200); // Enviamos los codigos de error.
        }

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        // Recibimos los datos que nos envian en el post
        // echo "Hola POST";
        $postBody = file_get_contents("php://input");
        // Enviamos los datos al manejador
        $datosArray = $_pacientes->post($postBody);
        // print_r($resp);
        // Le decimos al header que enviamos una respuesta json
        header('Content-Type: application/json'); 
        if(isset($datosArray["result"]["error_id"])){ // Si existe alguna respuesta/error de cualquier tipo
            $responseCode = $datosArray["result"]["error_id"]; // Almacenamos la respuesta/error
            http_response_code($responseCode); // Capturamos nuesta respuesta/error
        }else{
            // Si esta todo Ok la respuesta/error seria un 200
            http_response_code(200);
        }
        // Enviamos la respuesta
        echo json_encode($datosArray); // Usamos echo porque al momento de codificarlo como json lo estamos convirtiendo en un string

    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        // echo "Hola PUT";
        // Recibimos los datos que nos envian en el post
        // echo "Hola POST";
        $postBody = file_get_contents("php://input");
        // Enviamos los datos al manejador
        $datosArray = $_pacientes->put($postBody);
        // print_r($postBody);
        // Le decimos al header que enviamos una respuesta json
        header('Content-Type: application/json'); 
        if(isset($datosArray["result"]["error_id"])){ // Si existe alguna respuesta/error de cualquier tipo
            $responseCode = $datosArray["result"]["error_id"]; // Almacenamos la respuesta/error
            http_response_code($responseCode); // Capturamos nuesta respuesta/error
        }else{
            // Si esta todo Ok la respuesta/error seria un 200
            http_response_code(200);
        }
        // Enviamos la respuesta
        echo json_encode($datosArray); // Usamos echo porque al momento de codificarlo como json lo estamos convirtiendo en un string


    }elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){ // En este metodo rescatamos los datos via headers o via body
        // echo "Hola DELETE";
        // Recibimos los datos que nos envian por el header
        $headers = getallheaders();
        // print_r($headers);
        // Tomamos los datos del header y los almacenamos en el array $datosHeaders
        if(isset($headers['Paciente-Id']) && $headers['token']){
            $datosHeaders = [
                            "pacienteId" => $headers['Paciente-Id'],
                            "token" => $headers['token']
            ];
            $postDatos = json_encode($datosHeaders); // Convertimos a json el array para poder pasarselo al metodo delete
        }else{
            // Recibimos los datos que nos envian en el post
            $postDatos = file_get_contents("php://input");
        }
        // echo "Hola POST";
        // Enviamos los datos al manejador
        $datosArray = $_pacientes->delete($postDatos);
        // print_r($postDatos);
        // Le decimos al header que enviamos una respuesta json
        header('Content-Type: application/json'); 
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
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405(); // Error 405 envia: "Metodo no permitido"
        // Enviamos la respuesta
        echo json_encode($datosArray);
    }