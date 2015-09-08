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
        switch (Session::get('sess_url_buscador')) {
            case '3f7a2611ee08c6645796463e0bb1ae7f':
                Session::set('sess_boton_pago', true);
                return 'http://www.travelclub.cl/';
                break;

            default:
                Session::destroy('sess_boton_pago');
                return 'http://www.panamericanaturismo.cl';
                break;
        }
    }
    
    public function buscar($url='') {
        Session::set('sess_url_buscador', $url);
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
