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
                        if (trim($status) !== "" && trim($hash) !== "" && trim($monto) !== "" && trim($num_file) !== ""){
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
        
        echo json_encode($mensaje);
    }

    public function sendJson($json, $url) {
        //$ejemplo = array("external_id" => "24585","status" => "Success","amount" => "300000","hash" => "12345");
        $json = $this->curlJSON($json, $url, 'travelclub', 'c0af51A18d');
        return $json;
    }
    
    public function getHash() {
        if($this->getTexto('__JSON__') == '466deec76ecdf5fca6d38571f6324d54') {
            if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
                if (Session::get('sess_boton_pago')) { //QUITAR !
                    
                    $url = 'http://apishopper.herokuapp.com/api/checkout/uploadGeneric';
                    $json = array(
                        "external_id" => "1988", 
                        "agency_id" => "54c0239344ae3d41c8b83a23",
                        "currency" => "usd",
                        "amount" => "300",
                        "tax" => "100",
                        "subject" => "Un asunto",
                        "redirection_url" => BASE_URL . 'pago/cierre',
                        "callback_url" => BASE_URL . 'json/getAcusePago'
                    );
                    
                    $getJson= $this->curlJSON($json, $url, 'E3ra79', 'api33-33a');
                    if(is_object($getJson)) {
                        Session::set('sess_hash_transaction', $getJson->hash);
                        //echo "El hash es: " . $getJson->hash;
                        echo date('His');
                    } else {
                        //throw new Exception("Error al intentar realizar el pago");
                        Session::set('sess_status_pago', false);
                        Session::set('sess_msj_pago', '[1014] Error al intentar realizar el pago');
                        $this->redireccionar('pago/cierre');
                    }
                } else {
                    Session::set('sess_status_pago', false);
                    Session::set('sess_msj_pago', '[1013] Error al intentar realizar el pago');
                    $this->redireccionar('pago/cierre');
                }
            } else {
                Session::set('sess_status_pago', false);
                Session::set('sess_msj_pago', '[1012] Error al intentar realizar el pago');
                $this->redireccionar('pago/cierre');
            }
        } else {
            Session::set('sess_status_pago', false);
            Session::set('sess_msj_pago', '[1011] Error al intentar realizar el pago');
            $this->redireccionar('pago/cierre');
        }
    }
    
    
    public function checkPayment() {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
            if($this->getTexto('__PAYMENT__')) {
                if (Session::get('sess_boton_pago')) { //QUITAR !
                    if (Session::get('sess_hash_transaction')) {
                        $this->_view->hash = 'b51ed0257ac70f7aea669a1a223bd143O1340';//Session::get('sess_hash_transaction');
                        $this->_view->renderingCenterBox('pago_travelclub');
                    } else {
                        Session::set('sess_status_pago', false);
                        Session::set('sess_msj_pago', '[1018] Error al intentar realizar el pago');
                        $this->redireccionar('pago/cierre');
                    }
                } else {
                    Session::set('sess_status_pago', false);
                    Session::set('sess_msj_pago', '[1017] Error al intentar realizar el pago');
                    $this->redireccionar('pago/cierre');
                }
            } else {
                Session::set('sess_status_pago', false);
                Session::set('sess_msj_pago', '[1016] Error al intentar realizar el pago');
                $this->redireccionar('pago/cierre');
            }
        } else {
            Session::set('sess_status_pago', false);
            Session::set('sess_msj_pago', '[1015] Error al intentar realizar el pago');
            $this->redireccionar('pago/cierre');
        }
    }
}
