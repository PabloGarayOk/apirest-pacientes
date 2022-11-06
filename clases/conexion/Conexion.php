<?php

    // require_once('config/config.php');
    // // Abrir conexion a la base de datos

    // function connect($db)
    // {
    //     try {
    //         $conn = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);

    //         // Set the PDO error mode to exception
    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //         return $conn;
    //     } catch (PDOException $exception) {
    //         exit($exception->getMessage());
    //     }
    // }

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
            
            try {
                // Con un array en config.php
                // $this->conexion_db = new PDO("mysql:host={$db['host']};dbname={$db['database']}", $db['username'], $db['password']);
                // Con constantes en config.php
                // $this->conexion_db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE."; charset=".DB_CHARSET."", DB_USUARIO, DB_CONTRA);
                // Con json en config
                $this->conexion_db = new PDO("mysql:host=".$this->server."; dbname=".$this->database."; charset=".$this->charset, $this->user, $this->password);
				$this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// Set the PDO error mode to exception
            }catch (PDOException $e) {
                exit($e->getMessage());
                echo "la l&iacute;nea de error es: " . $e->getLine();
            }
            return $this->conexion_db;
            
            /*
            $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->db, $this->port);
            if($this->conexion->connect_errno){
                echo "Error en la conexion";
                die();
            }
            */
        }

        private function datosConexion(){
            $direccion = dirname(__FILE__);
            $jsonData = file_get_contents($direccion . "/config");
            return json_decode($jsonData, true);
        }

        private function convertirUTF8($array){
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }

        /*
        // Obtener Datos mysqli
        public function obtenerDatos($strsql){
            $results = $this->conexion_db->query($strsql);
            $resultArray = [];
            foreach($results as $key){
                $resultArray[] = $key;
            }
            return $this->convertirUTF8($resultArray);
        }// End obtenerDatos
        */

        // Obtener Datos PDO
        public function obtenerDatos($strsql){
            $results = $this->conexion_db->query($strsql);
            //$resultArray = [];
            $resulset=$results->fetchAll(PDO::FETCH_ASSOC);
            return $this->convertirUTF8($resulset);
        } // End obtenerDatos

        // Non Query
        public function nonQuery($strsql){
            $results = $this->conexion_db->query($strsql);
            return $results = $this->conexion_db->affected_rows;
        } // End nonQuery

        // Query filas afectadas
        public function queryId($strsql){
            $results = $this->conexion_db->query($strsql);
            $filas = $this->conexion_db->affected_rows;
            if($filas > 0){
                return $this->conexion_db->insert_id;
            }else{
                return $filas . " no insertamos nada.";
            }
        }

        // https://youtu.be/qGEWyjVWVj8?t=499

    } // End class Conexion