<?php
    class Respuestas{
        private $response = [
                            "status" => "ok ",
                            "result" => array();
        ];
        
        // Function error_200
        public function error_200($valor = "Datos incorrectos"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "200",
                                        "error_msg" => $valor
            );
            return $response;
        } // End function error_200
        
        // Function error_400
        public function error_400(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "400",
                                        "error_msg" => "Datos enviados impoletos o con formato incorrecto"
            );
            return $response;
        } // End function error_400

        // Function error_405
        public function error_405(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "405",
                                        "error_msg" => "Metodo no permitido"
            );
            return $response;
        } // End function error_405
    
    
    } // End class Respuestas