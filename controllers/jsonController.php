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
    
    

    public function sendJson() {
        $ejemplo = array("external_id" => "24585","status" => "Success","amount" => "300000","hash" => "12345");
        $json = $this->curlJSON($ejemplo, BASE_URL . 'json/getAcusePago', 'travelclub', 'c0af51A18d');
        echo var_dump($json);
    }
    
    public function getHash() {
        if($this->getTexto('__JSON__') == '466deec76ecdf5fca6d38571f6324d54') {
            if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
                if (Session::get('sess_boton_pago')) { //QUITAR !
                    
                    $urlJson= ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json';
                    $contentJson= file_get_contents($urlJson);
                    $jsonFile = json_decode($contentJson);
                    
                    //$url = 'http://apishopper.herokuapp.com/api/checkout/uploadGeneric';
                    $url = $jsonFile->pay_url_api . 'api/checkout/uploadGeneric';
                    $json = array(
                        "external_id" => $jsonFile->pay_file, 
                        "agency_id" => $jsonFile->pay_agency_id,
                        "currency" => $jsonFile->pay_currency,
                        "amount" => $jsonFile->pay_amount,
                        "tax" => $jsonFile->pay_tax,
                        "subject" => "Pago por reserva N-".$jsonFile->pay_file,
                        "redirection_url" => BASE_URL . 'pago/cierre',
                        "callback_url" => BASE_URL . 'json/getAcusePago'
                    );
                    
                    $getJson= $this->curlJSON($json, $url, $jsonFile->pay_user, $jsonFile->pay_pass);
                    if(is_object($getJson)) {
                        /*$file = fopen($urlJson, "r");
                        while(!feof($file)) {$jsonPay = str_replace('}', '', fgets($file)); }
                        fclose($file);*/
                        
                        if($this->_json->nuevoPago($jsonFile->pay_file, $getJson->hash, $jsonFile->pay_amount)) {
                            $file = fopen($urlJson, "w");
                            fwrite($file, str_replace('}', '', $contentJson) . ',"pay_hash":"' . $getJson->hash . '"}');
                            fclose($file);

                            echo date('His');
                        } else {
                            //throw new Exception("Error al intentar realizar el pago");
                            Session::set('sess_status_pago', false);
                            Session::set('sess_msj_pago', '[1019] Error al intentar realizar el pago');
                            $this->redireccionar('pago/cierre');
                        }

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
                        
                    $urlJson= ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json';
                    $contentJson= file_get_contents($urlJson);
                    $jsonFile = json_decode($contentJson);
                    if($jsonFile->pay_hash) {
                        $this->_view->hash = $jsonFile->pay_hash;
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
