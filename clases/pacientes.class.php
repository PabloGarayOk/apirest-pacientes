<?php
    require_once 'conexion/Conexion.php';
    require_once 'respuestas.class.php';

    class Pacientes extends Conexion{
        private $table = "pacientes";

        // getPacientes - Obtener todos los pacientes
        public function getPacientes($pagina = 1){
            $inicio = 0;
            $cantidad = 3;
            if($pagina > 1){
                $inicio = ($cantidad * ($pagina - 1)) + 1;
                $cantidad = $cantidad * $pagina;
            }
            $query = "SELECT Paciente_Id, DNI, Nombre, Apellido, Tel, Email FROM {$this->table} LIMIT $inicio, $cantidad";
            //$query = "SELECT Paciente_Id, DNI, Nombre, Apellido, Tel, Email FROM pacientes LIMIT $inicio, $cantidad";
            // print_r($query);
            $datos = parent::obtenerDatos($query); // Usamos la funcion obtenerDatos de los usuarios y los almacenamos como array en $datos
            return $datos;
        } // End function getPacientes

        // getPaciente - Obtener 1 paciente
        public function getPaciente($pacienteId){
            $query = "SELECT Nombre FORM {$this->table} WHERE Genero= 'Fem'"; // Ver de hacer con consultas preparadas
            $datos = parent::obtenerDatos($query);
            return $datos;
            // return parent::obtenerDatos($query);
        } // End function getPaciente

    
    } // Enc class Pacientes