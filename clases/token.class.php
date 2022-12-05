<?php
    require_once 'conexion/conexion.php';

    class Token extends Conexion{
        private $tabla = "usuarios_token";

        // Actalizar token
        public function actualizarToken($fecha){
            $query = "UPDATE $this->tabla SET Estado = '0' WHERE Fecha < '$fecha' AND Estado = '1'";
            $verificar = parent::nonQuery($query);
            if($verificar > 0){
                return 1;
            }else{
                return 0;
            }
        } // End actualizarToken

    } // End class token