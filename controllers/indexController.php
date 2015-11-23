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
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}

?>