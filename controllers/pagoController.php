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
    }
    
    
    public function index() {
        $this->redireccionar('system');
    }
    
    public function cierre(){
        if(!Session::get('sess_status_pago')){
            $this->redireccionar('pago/fracaso');
        } else {
            $this->redireccionar('pago/proceso');
        }            
    }
    
    public function proceso(){
        echo 'Verificando si se realizo el pago correctamente'; exit;
    }
    
    public function fracaso(){
        $this->_view->msj = Session::get('sess_msj_pago');
        $this->_view->renderingCenterBox('fracaso');
    }
    
    public function exito(){
      
        $this->_view->renderingCenterBox('exito');
        
    }
    
    
}