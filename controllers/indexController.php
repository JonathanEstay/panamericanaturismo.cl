<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class indexController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        //$this->_view->titulo='Iniciar sesi&oacute;n';
        //$this->_view->renderizaPrincipal('login');
        if(!Session::get('Autenticado')) {
            header('Location: ' . BASE_URL . 'login');
        } else {
            header('Location: ' . BASE_URL . 'system');
        }
        
        exit;
    }
}

?>