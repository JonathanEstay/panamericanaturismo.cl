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
        header('Location: ' . BASE_URL . 'login');
    }

    public function getAcusePago() {
        header('Content-Type: application/json');
        $json = json_decode(file_get_contents('php://input'));
        
        //echo var_dump($headers); exit;
        $mensaje = array("reservation_confirmation_id"=>"","agency_id"=>"","time"=>"");
        
        if ($this->getServer('PHP_AUTH_USER') && $this->getServer('PHP_AUTH_PW')) {

            $user = $this->getServer('PHP_AUTH_USER');
            $pass = $this->getServer('PHP_AUTH_PW');

            $objUsuarios = $this->_json->consultarUser($user);
            if ($objUsuarios) {
                
                if ($objUsuarios[0]->getUser() == $user && $objUsuarios[0]->getPass() == $pass) {

                    if (isset($json->status) && isset($json->hash) && isset($json->amount) && isset($json->external_id)) {
                        $status = $json->status;
                        $hash = $json->hash;
                        $monto = $json->amount;
                        $num_file = $json->external_id;
                        if ($status!=="" && $hash!=="" && $monto!=="" && $num_file !==""){

                            $data = $this->_json->updatePagos($status, $hash, $monto, $num_file);
                            if ($data) {
                                $mensaje = array("reservation_confirmation_id"=>$data->getNum(),"agency_id"=>$objUsuarios[0]->getIdAgentExter(),"time"=>date("d/m/Y H:i:s"));
                            }
                        }
                    }
                } else {
                    $mensaje = 'Acceso denegado';
                }
            } else {
                $mensaje = 'Acceso denegado';
            }
        } else {
            $mensaje = 'Acceso denegado';
        }
        
        
        if(isset($mensaje)) {
            echo json_encode($mensaje);
        }
    }

    public function enviarJson() {
        $ejemplo = array("external_id" => "24585","status" => "Success","amount" => "300000","hash" => "12345");
        $json = $this->curlJSON($ejemplo, BASE_URL . 'json/getAcusePago', 'travelclub', 'c0af51A18d');
        echo var_dump($json);
    }

}
