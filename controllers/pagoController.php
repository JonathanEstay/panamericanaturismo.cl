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
        $url = $jsonPay->pay_url_api . 'api/checkout/orderStatus?external_id=' . $jsonPay->pay_file . '&agency_id=' . $jsonPay->pay_agency_id;
        $json = $this->curlGET_JSON($url, $jsonPay->pay_user, $jsonPay->pay_pass);
        //echo $json->hash; echo '<br>'; echo $jsonPay->pay_hash; echo '<br>'; echo $json->external_id; echo '<br>'; 
        //echo $json->agency_id; echo '<br>'; echo $json->status; echo '<br>'; exit;
        
        if(is_object($json)) {
            if(/*$jsonPay->pay_hash == $json->hash && */$jsonPay->pay_file == $json->external_id && $jsonPay->pay_agency_id == $json->agency_id) {
                if($json->status == 'success') {
                    return true;
                } else {
                     Session::set('sess_status_pago', false);
                    Session::set('sess_msj_pago', '[2021] Error al intentar realizar el pago (' . str_replace('ó', '&oacute;', $json->error_message) . ')');
                    return false;
                }
            } else {
                Session::set('sess_status_pago', false);
                Session::set('sess_msj_pago', '[2022] Error al intentar realizar el pago');
                return false;
            }
        } else {
            Session::set('sess_status_pago', false);
            Session::set('sess_msj_pago', '[2023] Error al intentar realizar el pago');
            return false;
        }
    }
    
    public function fracaso(){
        $this->_view->status = Session::get('sess_status_pago');
        $this->_view->msj = Session::get('sess_msj_pago');
        $this->_view->renderingCenterBox('fracaso');
        Session::destroy('sess_status_pago');
        Session::destroy('sess_msj_pago');
    }
    
    public function exito(){
        $this->_view->currentMenu = 11;
        //$this->_view->procesoTerminado=false;
        $this->_view->titulo = 'ORISTRAVEL';
        //Rescatando post
        $nFile= 203703;//$this->getTexto('CR_n_file');
        $codPRG= 40600;//$this->getTexto('CR_cod_prog');
        $codBloq= 337803;//$this->getTexto('CR_cod_bloq');
        
        
        $M_file= $this->loadModel('reserva');
        $M_bloqueos= $this->loadModel('bloqueo');
        $M_packages= $this->loadModel('programa');
        
        if(!$nFile) {
            throw new Exception('File no recibido');
        }
        //Creando los objetos para las View
        $objsFile= $M_file->getFile($nFile);
        
        $this->_view->CC_objsDetFile= $M_file->getDetFile($nFile);
        $recordC= $M_bloqueos->getRecodC($codPRG,$codBloq);
        
        $objsBloq= $M_bloqueos->getBloqueos($recordC[0][0]);
        
        $this->_view->CC_objsDetBloq= $M_bloqueos->getDetBloq($recordC[0][0], $nFile);
        
        $objsPackages= $M_packages->getPackagesH2H($codPRG);
        
        
        if($objsFile) {
            $this->_view->CC_agencia=$objsFile[0]->getAgencia();
            $this->_view->CC_vage= $objsFile[0]->getVage();
            $this->_view->CC_nomPax= $objsFile[0]->getNomPax();
            $this->_view->CC_nPax= $objsFile[0]->getNPax();
            $this->_view->CC_fviaje= $objsFile[0]->getFViaje();
            $this->_view->CC_moneda= $objsFile[0]->getMoneda();
            $this->_view->CC_totventa= $objsFile[0]->getTotVenta();
            $this->_view->CC_cambio= $objsFile[0]->getCambio();
            $this->_view->CC_comag= $objsFile[0]->getComag();
            $this->_view->CC_fecha= $objsFile[0]->getFecha();
            
            $this->_view->CC_datos= $objsFile[0]->getDatos();
            $this->_view->CC_ajuste= $objsFile[0]->getAjuste();
            $this->_view->CC_tcomi= $objsFile[0]->getTComi();
        }
        
        if($objsPackages) {
            $this->_view->CC_nombreProg=$objsPackages[0]->getNombre();
        }
        
        if($objsBloq) {
            $this->_view->CC_notas= str_replace("\n", "<br>", $objsBloq[0]->getNotas());
        } else {
            $this->_view->CC_notas=false;
        }
        
        $this->_view->numFile= $nFile;
        $this->_view->codigoPRG= $codPRG;
        $this->_view->codigoBloq= $codBloq;
        Session::set('sess_condiciones','travelclub');

        $this->_view->condicionesGenerales= file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . Session::get('sess_condiciones') . '.phtml');
        
        
        
        $this->_view->renderingSystem('exito');
        Session::destroy('sess_status_pago');
        Session::destroy('sess_msj_pago');
    }
    
    
}