<?php
    require_once 'conexion/conexion.php';
    require_once 'respuestas.class.php';

    class Auth extends Conexion{
        public function login($json){
            $_respuestas = new Respuestas;
            $datos = json_decode($json,true); // Convertimos el json a un array
            if(!isset($datos['user']) || !isset($datos['pass'])){ // Verificamos si nos envian el usuario y el password
                // Si no estan los campos
                return $_respuestas->error_400();
            }else{
                // Si esta todo bien recogemos los datos que nos enviaron
                $usuario = htmlentities(addslashes($datos['user']));
                $password = htmlentities(addslashes($datos['pass']));
                // Verificamos si existe el usuario
                $datos = $this->obtenerDatosUsuario($usuario);
                if($datos){
                    // Si existe el usuario
                    if($comprobarPass = parent::verificarPass($password, $datos)){
                        // Verificamos si el usuario esta Activo
                        if($datos[0]['Estado']){
                            // Si el usuario esta ACTIVO creamos el Token
                            $creaToken = $this->insertarToken($datos[0]["UsuarioId"]);
                            if($creaToken){
                                // return $_respuestas->error_200("Token creado");
                                $responseBis = $_respuestas->response; // Aplicamos los atibutos de 'response' a '$responseBis'
                                // Le agregamos al array de '$responseBis' el elmento 'token' con el valor del token creado
                                $responseBis["result"] = array(
                                                                "token" => $creaToken
                                );
                                return $responseBis; // Retronamos el token
                            }else{
                                // Si no se pudo guardar el token
                                return $_respuestas->error_500("Error interno, no se ha podido guardar el token");
                            }
                            
                        }else{
                            // Si el usuario esta INACTIVO
                            return $_respuestas->error_200("Usuario Inactivo");
                        }                        
                    }else{
                        // Si esta MAL el password
                        return $_respuestas->error_200("Password incorrecto");
                    }                    
                }else{
                    // Si NO existe el usuario
                    return $_respuestas->error_200("El usuario '{$usuario}' no se encuentra en la base de datos");
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

        // Creamos el token
        private function insertarToken($usuarioId){
            $bool = true; // Para pasarle como segundo parametro a la funcion 'openssl_random_pseudo_bytes' y solo acepta variables y no string
            $token = bin2hex(openssl_random_pseudo_bytes(16, $bool)); // Generamos el token (16 es el numero de bytes que queremos que genere)
            $estado = true; 
			date_default_timezone_set('America/Argentina/Buenos_Aires'); // Seteamos la zona horaria
			$fecha = date("Y-m-d H:i:s"); // Guardamos la fecha actual
			$query = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha) VALUES ('$usuarioId', '$token', '$estado', '$fecha')";
            // Verificamos si se inserto el token
            $verificar = parent::nonQuery($query);
            if($verificar){
                return $token;
            }else{
                return false;
            }
        }

    } // End class Auth