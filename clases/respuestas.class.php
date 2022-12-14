<?php
    class Respuestas{
        public $response = [
                            "status" => "ok",
                            "result" => array()
        ];
        
        // Function error_200
        public function error_200($valor = "Datos incorrectos"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "200",
                                        "error_msg" => $valor
            );
            return $this->response;
        } // End function error_200
        
        // Function error_400
        public function error_400(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "400",
                                        "error_msg" => "Datos enviados incompletos o con formato incorrecto"
            );
            return $this->response;
        } // End function error_400

        // Function error_401
        public function error_401(string $valor = "No autorizado"){
			$this->response['status'] = "error";
			$this->response['result'] = array(
										"error_id" => "401",
										"error_msg" => $valor
										);
			return $this->response;
		} // End function error_401

        // Function error_405
        public function error_405(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "405",
                                        "error_msg" => "Metodo no permitido"
            );
            return $this->response;
        } // End function error_405

        // Function error_500
        public function error_500($valor = "Error interno del servidor"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                                        "error_id" => "500",
                                        "error_msg" => $valor
            );
            return $this->response;
        } // End function error_500
    
    
    } // End class Respuestas