<?php

    class Conexion{
        private $server;
        private $user;
        private $password;
        private $database;
        private $port;
        private $charset;
        private $conexion_db;

        function __construct(){
            $listaDatos = $this->datosConexion();
            foreach ($listaDatos as $key => $value){
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
                $this->charset = $value['charset'];
            }
            
            $this->conexion_db = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
            if($this->conexion_db->connect_errno){
                echo "Error en la conexion";
                die();
            }
            return $this->conexion_db;            
        } // End __construct

        // Obtener datos del archivo conexion
        private function datosConexion(){
            $direccion = dirname(__FILE__); // Obtenemos la direccion de este archivo
            $jsonData = file_get_contents($direccion . "/config"); // Obtenemos y almacenamos los datos de conexion de nuestro archivo
            return json_decode($jsonData, true); // Convertimos en array asociativo los datos
        } // End datosConexion

        // Convertir a utf8
        private function convertirUTF8($array){
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        } // End convertirUTF8
        
        // Obtener Datos mysqli
        public function obtenerDatos($strsql){
            $results = $this->conexion_db->query($strsql);
            // $resultArray = [];
            foreach($results as $key){
                $resultArray[] = $key;
            }
            return $this->convertirUTF8($resultArray);
        }// End obtenerDatos

        // Non Query
        public function nonQuery($strsql){
            $results = $this->conexion_db->query($strsql);
            return $this->conexion_db->affected_rows;
        } // End nonQuery

        // Query Non Query Id para el metodo Insert
        public function nonQueryId($strsql){
            $results = $this->conexion_db->query($strsql);
            $filas = $this->conexion_db->affected_rows;
            if($filas > 0){
                return $this->conexion_db->insert_id;
            }else{
                return $filas . " no insertamos nada.";
            }
        }// End nonQueryId

        // Encriptar md5
        protected function encriptar($string){
            return md5($string);
        } // End Encriptar md5        
        
        // Verificacion de password
        protected function verificarPass($string, $datos){
            $contador = 0;
            $comprobrar = false;
            if(password_verify($string, $datos[0]['Password'])){
                $comprobar = true;
            }
            return $comprobar;
        } // End function verificarPass

    } // End class Conexion