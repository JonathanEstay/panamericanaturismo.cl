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
        echo 'dfg';
                exit();
    }
    
    public function proceso(){
        
    }
    
    public function fracaso(){
        
    }
    
    public function exito(){
        
    }
    
    
}