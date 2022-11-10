<?php
    
    require_once ('clases/conexion/Conexion.php');

    $conexion = new Conexion();

    //$query = "SELECT * FROM pacientes";

    $query = "INSERT INTO pacientes (DNI1) VALUES (20208205)";

    print_r($conexion->nonQuery($query));
    echo "\n";
    echo "<pre>";
    print_r($conexion->nonQueryId($query));
    //print_r($conexion->obtenerDatos($query));
    echo "</pre>";