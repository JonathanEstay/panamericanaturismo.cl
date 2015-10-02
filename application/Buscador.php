<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Buscador extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    public function index(){}
    
    
    
    public function getUrl() {   
        switch (Session::get('sess_codigo_cliente_url')) {
            case '3f7a2611ee08c6645796463e0bb1ae7f':
                Session::set('sess_boton_pago', true);
                Session::set('sess_iframe', false);
                Session::set('sess_condiciones', 'travelclub');
                Session::set('sess_user_hash', 'E3ra79');
                return 'http://hoteles.travelclub.cl/es';
                break;
            
            case '__OTRO__':
                Session::destroy('sess_boton_pago');
                Session::set('sess_iframe', false);
                Session::set('sess_condiciones', 'panamericana');
                Session::set('sess_user_hash', false);
                return 'http://hoteles.travelclub.cl/es';
                break;

            default:
                Session::destroy('sess_boton_pago');
                Session::set('sess_iframe', true);
                Session::set('sess_condiciones', 'panamericana');
                Session::set('sess_user_hash', false);
                return 'http://www.panamericanaturismo.cl';
                break;
        }
    }
    
    public function buscar($url='') {
        //if(substr($this->getServer('HTTP_REFERER'), 16, 22) == 'panamericanaturismo.cl' || substr($this->getServer('HTTP_REFERER'), 14, 22) == 'panamericanaturismo.cl')
        //{
            Session::set('sess_url_buscador', $url);
        //} else {
            
        //}
    }
    
    public function getCliente($cliente) {
        
        $lista_clientes = array(
            "buscador" => "",
            "buscador_travelclub" => "3f7a2611ee08c6645796463e0bb1ae7f",
            "otro" => "otro_codigo"
            );
        
        foreach ($lista_clientes as $cli => $val) {
            if($cliente == $cli){
                Session::set('sess_codigo_cliente_url', $val);
                return true;
            }
        }
        
        return false;
    }
    
    public function validar($form='') {
        if($form!='form'){
            Session::acceso('Usuario');
            return false;
        } else {
            return true;
        }
    }
    
    
    public function validaForm() {
        $form = $this->_view->getArgumentos();
        if (!$form) {
            $form[0] = '';
        }
        if (!$form) {
            $form[0] = 'a';
        }
        if ($form[0] != 'form') {
            Session::acceso('Usuario');
        }
    }
    
    
}
