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
        if($this->getPOST()) { //SI RECIBO UN POST
            $json= json_decode(json_encode($this->getPOST()));
            header('Content-Type: application/json');
        } else { //SI RECIBO UN JSON
            header('Content-Type: application/json');
            $json = json_decode(file_get_contents('php://input'));
        }
        
        if($json) {
            $objAgencyId = $this->_json->getAgencyId();
            if ($objAgencyId) {
                if (isset($json->status) && isset($json->hash) && isset($json->amount) && isset($json->external_id)) {
                    $status = $json->status;
                    $hash = $json->hash;
                    $monto = $json->amount;
                    $num_file = $json->external_id;

                    $this->_json->logJSON($num_file,  str_replace('\\', '', json_encode($json)), 'S'); //LOG RS

                    if (trim($status) !== "" && trim($hash) !== "" && trim($monto) !== "" && trim($num_file) !== "") {
                        $data = $this->_json->updatePagos($status, $hash, $monto, $num_file);
                        if ($data) {
                            $mensaje = array("reservation_confirmation_id"=>$data->getNum(),"agency_id"=>$objAgencyId[0]->getIdAgentExter(),"time"=>date("d/m/Y H:i:s"));
                        } else {
                            $mensaje = 'Acceso denegado';
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
        } else {
            $mensaje = 'Acceso denegado';
        }
        
        echo json_encode($mensaje);
    }
    
    
    
    
    

    public function sendJson() {
        $ejemplo = array("external_id" => "24601","status" => "success","amount" => "9","hash" => "9db28f1b52e34dee49cb69e0d4f0b1aaO1723");
        $json = $this->curlJSON($ejemplo, BASE_URL . 'json/getAcusePago');
        echo var_dump($json);
    }
    
    public function getHash() {
        if($this->getTexto('__JSON__') == '466deec76ecdf5fca6d38571f6324d54') {
            if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
                if (Session::get('sess_boton_pago')) { //QUITAR !
                    
                    $urlJson= ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json';
                    $contentJson= file_get_contents($urlJson);
                    $jsonFile = json_decode($contentJson);
                    
                    $url = $jsonFile->pay_url_api . 'api/checkout/uploadGeneric';
                    $json = array(
                        "external_id" => $jsonFile->pay_file, 
                        "agency_id" => $jsonFile->pay_agency_id,
                        "currency" => $jsonFile->pay_currency,
                        "amount" => $jsonFile->pay_amount,
                        "tax" => $jsonFile->pay_tax,
                        "subject" => "Pago por reserva N-".$jsonFile->pay_file,
                        "redirection_url" => BASE_URL . 'pago/cierre/'.$jsonFile->pay_file,
                        "callback_url" => BASE_URL . 'json/getAcusePago'
                    );
                    
                    
                    $this->_json->logJSON($jsonFile->pay_file,  str_replace('\\', '', json_encode($json)), 'Q'); //LOG RQ
                    $getJson= $this->curlJSON($json, $url, $jsonFile->pay_user, $jsonFile->pay_pass);
                    $this->_json->logJSON($jsonFile->pay_file,  str_replace('\\', '', json_encode($getJson)), 'S'); //LOG RS
                    
                    if(is_object($getJson)) {
                        
                        if($this->_json->nuevoPago($jsonFile->pay_file, $getJson->hash, $getJson->pay_email, $getJson->pay_fono)) {
                            $file = fopen($urlJson, "w");
                            fwrite($file, str_replace('}', '', $contentJson) . ',"pay_hash":"' . $getJson->hash . '"}');
                            fclose($file);
                            echo date('His');
                            exit;
                        } else {
                            Session::set('sess_msj_pago', '[1019] Error al intentar realizar el pago');
                        }
                    } else {
                        Session::set('sess_msj_pago', '[1014] Error al intentar realizar el pago');
                    }
                } else {
                    Session::set('sess_msj_pago', '[1013] Error al intentar realizar el pago');
                }
            } else {
                Session::set('sess_msj_pago', '[1012] Error al intentar realizar el pago');
            }
        } else {
            Session::set('sess_msj_pago', '[1011] Error al intentar realizar el pago');
        }
        
        Session::set('sess_status_pago', false);
        $this->redireccionar('pago/cierre');
    }
    
    
    public function checkPayment() {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
            if($this->getTexto('__PAYMENT__')) {
                if (Session::get('sess_boton_pago')) { //QUITAR !
                        
                    $urlJson= ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json';
                    $contentJson= file_get_contents($urlJson);
                    $jsonFile = json_decode($contentJson);
                    if(isset($jsonFile->pay_hash)) {
                        $this->_view->hash = $jsonFile->pay_hash;
                        $this->_view->url_api = $jsonFile->pay_url_api;
                        $this->_view->renderingCenterBox('pago_travelclub');
                        exit;
                    } else {
                        Session::set('sess_msj_pago', '[1018] Error al intentar realizar el pago');
                    }
                } else {
                    Session::set('sess_msj_pago', '[1017] Error al intentar realizar el pago');
                }
            } else {
                Session::set('sess_msj_pago', '[1016] Error al intentar realizar el pago');
            }
        } else {
            Session::set('sess_msj_pago', '[1015] Error al intentar realizar el pago');
        }
        
        Session::set('sess_status_pago', false);
        $this->redireccionar('pago/cierre');
    }
}
