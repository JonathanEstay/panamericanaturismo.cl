<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class categoriaDTO
{
    private $_codigo;
    private $_nombre;
    
    public function setCodigo($cod)
    {
        $this->_codigo= $cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    public function setNombre($nombre)
    {
        $this->_nombre= $nombre;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
}