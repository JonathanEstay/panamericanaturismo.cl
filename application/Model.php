<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Model
{
    private $_registry;
    protected $_db;
    
    public function __construct() {
        $this->_registry = Registry::getInstancia();
        $this->_db= $this->_registry->_db;
    }
}