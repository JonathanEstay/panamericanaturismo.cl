<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

// 5 metodos : index , cierre , proceso, fracaso , exito.
class pagoController extends Controller{
    
    public function __construct() {
        parent::__construct();
        $this->_json = $this->loadModel('json');
    }
    
    
    public function index() {
        $this->redireccionar('system');
    }
    
    public function cierre(){
        /*echo var_dump($_POST);
        echo '<br>';
        echo var_dump($_GET);
        echo '<br>';
        echo var_dump(file_get_contents('php://input'));
        echo '<br>';
        echo file_get_contents('php://input');
        exit;*/
        if($this->proceso()){
            $this->redireccionar('pago/exito');
        } else {
            $this->redireccionar('pago/fracaso');
        }            
    }
    
    public function proceso(){
        
        $jsonPay = json_decode(file_get_contents(ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json'));
        $url = 'http://travelclub-test.herokuapp.com/api/checkout/orderStatus?external_id=' . $jsonPay->pay_file . '&agency_id=' . $jsonPay->pay_agency_id;
        $json = $this->curlGET_JSON($url, $jsonPay->pay_user, $jsonPay->pay_pass);
        //echo $json->hash; echo '<br>'; echo $json->external_id; echo '<br>'; echo $json->agency_id; echo '<br>'; echo $json->status; echo '<br>'; exit;
        if(/*$jsonPay->pay_hash == $json->hash && */$jsonPay->pay_file == $json->external_id && $jsonPay->pay_agency_id == $json->agency_id) {
            if($json->status == 'success') { 
                return true;
            } else {
                 Session::set('sess_status_pago', false);
                Session::set('sess_msj_pago', '[2022] Error al intentar realizar el pago (' . str_replace('ó', '&oacute;', $json->error_message) . ')');
                return false;
            }
        } else {
            Session::set('sess_status_pago', false);
            Session::set('sess_msj_pago', '[2021] Error al intentar realizar el pago');
            return false;
        }
            
        //return true;
    }
    
    public function fracaso(){
        $this->_view->msj = Session::get('sess_msj_pago');
        $this->_view->renderingCenterBox('fracaso');
    }
    
    public function exito(){
      
        $this->_view->renderingCenterBox('exito');
        
    }
    
    
}