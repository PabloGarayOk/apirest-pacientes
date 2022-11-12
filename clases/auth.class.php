<?php
    require_once 'conexion/Conexion.php';
    require_once 'respuestas.class.php';

    class Auth extends Conexion{
        public function login($json){
            $_respuestas = new Respuestas;
            $datos = json_decode($json,true); // Convertimos el json a un array
            if(!isset($datos['user']) || !isset($datos['pass'])){ // Verificamos si nos envian el usuario y el password
                
                # Nota para el lector:
                /*
                Al enviar los datos en el body de nuestro Api Tester preferido notese de completar con comillas dobles "" para que funcione correctamente.
                    Ejemplo:
                        {
                            "user": "agostinapro@gmail.com",
                            "pass": "123456"
                        }   
                */

                // Si no estan los campos
                return $_respuestas->error_400();
            }else{
                // Si esta todo bien recogemos los datos que nos enviaron
                $usuario = $datos['user'];
                $password = $datos['pass'];
                // Verificamos si existe el usuario
                $datos = $this->obtenerDatosUsuario($usuario);
                if($datos){
                    // Si existe el usuario
                    return $_respuestas->error_200("Vamos a crear el token para el usuario: {$usuario}");
                }else{
                    // Si NO existe el usuario
                    return $_respuestas->error_200("Error en usuario");
                }
            }
        } // End function login

        // Obtenemos los datos del usuario
        private function obtenerDatosUsuario($emailUsuario){
            $query = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Email = '$emailUsuario'"; //Buscamos nuestro usuario
            // Ver de realizar esto con consultas preparadas!!!
            $datos = parent::obtenerDatos($query); // Usamos la funcion obtenerDatos de nuesto usuario y lo almacenamos como array en $datos
            // Si existe en la posicion cero de la array un valor para UsuarioId devolvemos todo el array $datos.
            if(isset($datos[0]["UsuarioId"])){
                return $datos;
            }else{
                return 0; // Sino devolvemos cero/false.
            }

        } //End function obtenerDatosUsuario

    } // End class Auth