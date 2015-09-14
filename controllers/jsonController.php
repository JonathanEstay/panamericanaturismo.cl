<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class jsonController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->_json = $this->loadModel('json');
    }

    public function index() {
        $this->_view->rederJson('enviar_json');
    }

    public function getJson() {
        header('Content-Type: application/json');
        
        $json = json_decode(file_get_contents('php://input'));

        $headers = apache_request_headers();


        if (isset($headers['Authorization'])) {

            if ($this->getServer('PHP_AUTH_USER') && $this->getServer('PHP_AUTH_PW')) {


                $user = $this->getServer('PHP_AUTH_USER');

                $pass = $this->getServer('PHP_AUTH_PW');

                $objUsuarios = $this->_json->consultarUser($user);

                if ($objUsuarios) {

                    if ($objUsuarios[0]->getUser() == $user && $objUsuarios[0]->getPass() == $pass) {

                        if (isset($json->status) && isset($json->hash) && isset($json->monto) && isset($json->num_file)) {
                            $status = $json->status;
                            $hash = $json->hash;
                            $monto = $json->monto;
                            $num_file = $json->num_file;
                            if( $status!=="" && $hash!=="" && $monto!=="" && $num_file !=="" ){
                                
                            $data = $this->_json->updatePagos($status, $hash, $monto, $num_file);

                            if ($data) {
                                $mensaje = array("status"=>"OK" ,"codigo"=>"1" ,"mensaje"=>'Pago Realizado');
                                
                            } else {
                                $mensaje = array("status"=>"ERROR" ,"codigo"=>"2" ,"mensaje"=>'Pago no Realizado');
                                
                            }
                            
                            }else{
                                $mensaje = array("status"=>"ERROR" ,"codigo"=>"3" ,"mensaje"=>'Pago no Realizado');
                                
                            }
                        } else {

                            $mensaje = array("status"=>"ERROR" ,"codigo"=>"4" ,"mensaje"=>'Pago no Realizado');
                            
                        }
                    } else {
                        
                        $mensaje = array("status"=>"ERROR" ,"codigo"=>"5" ,"mensaje"=>'Usuario o Password incorrectas');
                        
                    }
                } else {
                    
                    $mensaje = array("status"=>"ERROR" ,"codigo"=>"6" ,"mensaje"=>'Usuario o Password incorrectas');

                }
            } else {

                   $mensaje = array("status"=>"ERROR" ,"codigo"=>"7" ,"mensaje"=>'Debe enviar usuario y password');
                
            }
        } else {
            
            $mensaje = array("status"=>"ERROR" ,"codigo"=>"8" ,"mensaje"=>'No autenticado');
            
        }
        
        echo json_encode( $mensaje);
    }

    public function enviarJson() {
        $ejemplo = array("status" => "ok", "hash" => "12345", "monto" => "300000", "num_file" => "24585");
        $html = $this->curlJSON($ejemplo, BASE_URL . 'json/getJson', 'tclub', 'PanamT05');

        echo $html;
    }

}
