<?php
    
    require_once ('clases/conexion/Conexion.php');

    $conexion = new Conexion();

    $query = "SELECT * FROM pacientes";

    echo "<pre>";
    print_r($conexion->obtenerDatos($query));
    echo "</pre>";