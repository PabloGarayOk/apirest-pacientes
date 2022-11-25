<?php
    require_once 'conexion/Conexion.php';
    require_once 'respuestas.class.php';

    class Pacientes extends Conexion{
        private $table = "pacientes";
        private $pacienteId;
        private $dni = "";
        private $nombre = "";
        private $apellido = "";
        private $genero = "";
        private $fechaNacimento = "0000-00-00";
        private $direccion = "";
        private $tel = "";
        private $email = "";

        // getPacientes - Obtener todos los pacientes
        public function getPacientes($pagina){
            $inicio = 0;
            $cantidad = 3; // Registros por pagina
            if($pagina > 1){
                $inicio = ($cantidad * ($pagina - 1)); // Seteamos desde que registro se muestra segun la pagina solicitada
                // $cantidad = ($cantidad * $pagina); // No es necesario, la cant. de registros a mostrar siempre es la misma
            }
            $query = "SELECT Paciente_Id, DNI, Nombre, Apellido, Tel, Email FROM {$this->table} LIMIT $inicio, $cantidad";
            //$query = "SELECT Paciente_Id, DNI, Nombre, Apellido, Tel, Email FROM pacientes LIMIT $inicio, $cantidad";
            // print_r($query);
            $datos = parent::obtenerDatos($query); // Usamos la funcion obtenerDatos de los usuarios y los almacenamos como array en $datos
            return $datos;
        } // End function getPacientes

        // getPaciente - Obtener 1 paciente
        public function getPaciente($pacienteId){
            $query = "SELECT * FROM {$this->table} WHERE Paciente_Id = $pacienteId"; // Ver de hacer con consultas preparadas
            $datos = parent::obtenerDatos($query);
            return $datos;
            // return parent::obtenerDatos($query);
        } // End function getPaciente

        // Recibimos los datos del POST
        public function post($json){
            $_respuestas = new Respuestas; // Instanciamos las respuestas
            $datos = json_decode($json, true); // Convertimos en array el string que nos envian por post
            // Verificamos que se hallan enviado los datos necesarios (obligatorios) que solicitamos
            // Los nombres de campos clave de este array no es necesesario que coindidan como estan escritos en la BBDD todavia.
            if(!isset($datos['dni']) || !isset($datos['nombre']) || !isset($datos['email'])){
                return $_respuestas->error_400();
            }else{
                // Almacenamos los datos necesarios (obligatorios) enviados
                $this->dni = $datos['dni'];
                $this->nombre = $datos['nombre'];
                $this->email = $datos['email'];
                // Almacenamos los datos no obligatorios si es que fueron enviados
                if(isset($datos['apellido'])){$this->apellido = $datos['apellido'];}
                if(isset($datos['genero'])){$this->genero = $datos['genero'];}
                if(isset($datos['fechanacimiento'])){$this->fechaNacimiento = $datos['fechanacimiento'];}
                if(isset($datos['direccion'])){$this->direccion = $datos['direccion'];}
                if(isset($datos['tel'])){$this->tel = $datos['tel'];}
                
                // Ejecuto la funcion insertar paciente
                $resp = $this->insertarPaciente();
                // Si se inserta el paciente damos la respuesta
                if($resp){
                    // Asignamos/igualamos a $respuestaId la propiedad "response" de la clase $_respuestas para agregar el valor del id insertado
                    $respuestaId = $_respuestas->response;
                    // En el array que tiene almacenado le agregamos el key "pacienteId" con el valor del Id del nuevo usuario registrado
					$respuestaId['result'] = array(
                                                "pacienteId" => $resp
                                                );
                    return $respuestaId;
                }else{
                    return $_respuestas->error_500();
                }
            }

        } // End function post

        // Creamos la funcion Insertar paciente
        private function insertarPaciente(){
            //$query = "INSERT INTO {$this->table} (DNI, Nombre, Apellido, Genero, FechaNacimiento, Direccion, Tel, Email) VALUES ('{$this->dni}', '{$this->nombre}', '{$this->apellido}', '{$this->genero}', '{$this->fechaNacimiento}', '{$this->direccion}', '{$this->tel}', '{$this->email}')";
            $query = "INSERT INTO $this->table (DNI, Nombre, Apellido, Genero, FechaNacimiento, Direccion, Tel, Email) VALUES ('$this->dni', '$this->nombre', '$this->apellido', '$this->genero', '$this->fechaNacimiento', '$this->direccion', '$this->tel', '$this->email')";
            // print_r($query);
            $resp = parent::nonQueryId($query);
            if($resp){
				// Si se hace el insert devolvemos el id del paciente insertado
				return $resp;
			}else{
				return 0;
			}
            
            // VALUES ('" . $this->dni . "', '" . $this->nombre . "', '" . $this->apellido . "', '" . $this->genero . "', '" . $this->fechaNacimiento . "', '" . $this->direccion . "', '" . $this->tel . "', '" . $this->email . "')";
        
        } // End function insertarPaciente

        // Recibimos los datos del PUT
        public function put($json){
            $_respuestas = new Respuestas; // Instanciamos las respuestas
            $datos = json_decode($json, true); // Convertimos en array el string que nos envian por post
            // Verificamos que se hallan enviado los datos necesarios (obligatorios) que solicitamos
            // Los nombres de campos clave de este array no es necesesario que coindidan como estan escritos en la BBDD todavia.
            if(!isset($datos['pacienteId'])){
                return $_respuestas->error_400();
            }else{
                // Almacenamos los datos necesarios (obligatorios) enviados
                $this->pacienteId = $datos['pacienteId'];
                // Almacenamos los datos no obligatorios si es que fueron enviados
                if(isset($datos['dni'])){$this->dni = $datos['dni'];}
                if(isset($datos['nombre'])){$this->nombre = $datos['nombre'];}
                if(isset($datos['apellido'])){$this->apellido = $datos['apellido'];}
                if(isset($datos['genero'])){$this->genero = $datos['genero'];}
                if(isset($datos['fechanacimiento'])){$this->fechaNacimiento = $datos['fechanacimiento'];}
                if(isset($datos['direccion'])){$this->direccion = $datos['direccion'];}
                if(isset($datos['tel'])){$this->tel = $datos['tel'];}
                if(isset($datos['email'])){$this->email = $datos['email'];}
                
                // Ejecuto la funcion insertar paciente
                $resp = $this->editarPaciente();
                // Si se inserta el paciente damos la respuesta
                if($resp){
                    // Asignamos/igualamos a $respuestaAffect la propiedad "response" de la clase $_respuestas para agregar el valor del id insertado
                    $respuestaAffect = $_respuestas->response;
                    // En el array que tiene almacenado le agregamos el key "Filas afectadas" con el valor del Id del nuevo usuario registrado
					$respuestaAffect['result'] = array(
                                                "PacienteId" => $this->pacienteId,
                                                "Filas afectadas" => $resp
                                                );
                    return $respuestaAffect;
                }else{
                    return $_respuestas->error_500();
                }
            }

        } // End function put

        // Creamos la funcion Editar paciente
        private function editarPaciente(){
            //$query = "UPDATE pacientes SET DNI = 57152699, Nombre = 'Cinco', Apellido = 'Garay Pro', Genero = 'Fem', FechaNacimiento = '2018-08-09', Direccion = '27 de Abril 936', Tel = '3512242233', Email = 'cinco@gmail.com' WHERE Paciente_Id = '$this->pacienteId'";
            // $query = "UPDATE " . $this->table . " SET DNI = " . $this->dni . ", Nombre = '" . $this->nombre . "', Apellido = '" . $this->apellido . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Direccion = '" . $this->direccion . "', Tel = '" . $this->tel . "', Email = '" . $this->email . "' WHERE Paciente_Id = '" . $this->pacienteId . "'";
            // $query = "UPDATE {$this->table} SET DNI = {$this->dni}, Nombre = '{$this->nombre}', Apellido = '{$this->apellido}', Genero = '{$this->genero}', FechaNacimiento = {$this->fechaNacimiento}, Direccion = '{$this->direccion}', Tel = {$this->tel}, Email = '{$this->email}' WHERE Paciente_Id = {$this->pacienteId}";
            $query = "UPDATE $this->table SET DNI = '$this->dni', Nombre = '$this->nombre', Apellido = '$this->apellido', Genero = '$this->genero', FechaNacimiento = '$this->fechaNacimiento', Direccion = '$this->direccion', Tel = '$this->tel', Email = '$this->email' WHERE Paciente_Id = '$this->pacienteId'";
            // print_r($query);
            $resp = parent::nonQuery($query);
            if($resp >=1 ){
				// Si se hace el insert devolvemos el id del paciente insertado
				return $resp;
			}else{
				return 0;
			}

        } // End function editarPaciente
    
    } // End class Pacientes