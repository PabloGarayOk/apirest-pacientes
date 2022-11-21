<?php
    require_once 'clases/respuestas.class.php';
    require_once 'clases/pacientes.class.php';

    $_respuestas = new Respuestas;
    $_pacientes = new Pacientes;

    if($_SERVER[REQUEST_METHOD] == "GET"){
        if(isset($_GET["id"])){ // Si solicitan los datos de un paciente
            $id = $_GET["id"];
            $datosPaciente = $_pacientes->getPaciente($id);
            echo json_encode($datosPaciente); // Convertimos el json    
        }else if(isset($_GET["page"])){ // Si enviaron la pagina
            $pagina = $_GET["page"];
            $listarPacientes = $_pacientes->getPacientes($pagina); // Obnenemos los datos de los pacientes
            echo json_encode($listarPacientes); // Convertimos el json en string
        }else{
            // Sino envian pagina se muestran todos los datos
            $listarPacientes = $_pacientes->getPacientes($pagina); // Obnenemos los datos de los pacientes
            echo json_encode($listarPacientes); // Convertimos el json en string
        }



    }elseif($_SERVER[REQUEST_METHOD] == "POST"){
        echo "Hola POST";
    }elseif($_SERVER[REQUEST_METHOD] == "PUT"){
        echo "Hola PUT";
    }elseif($_SERVER[REQUEST_METHOD] == "DELETE"){
        echo "Hola DELETE";
    }else{
        // En el caso de que envien un Metodo no permitido;
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405(); // Error 405 envia: "Metodo no permitido"
        // Enviamos la respuesta
        echo json_encode($datosArray);
    }