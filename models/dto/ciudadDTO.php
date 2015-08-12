<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class ciudadDTO
{
    private $_nombre;
    private $_codigo;
    
    public function setNombre($ciudad)
    {
        $this->_nombre=$ciudad;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
    
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
}