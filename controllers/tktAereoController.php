<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class tktAereoController extends Controller {
    
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad = $this->loadModel('ciudad');
        Buscador::validaForm();
        $this->_loadLeft();
    }
    
    public function index() {
        
    }
    //put your code here
}
