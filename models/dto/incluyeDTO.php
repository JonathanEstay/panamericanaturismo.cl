<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class incluyeDTO
{
    private $_codigo;
    private $_nombre;
    private $_ciudad;
    private $_noches;
    
    
    public function getNoches()
    {
        return $this->_noches;
    }
    public function setNoches($noches)
    {
        $this->_noches=$noches;
    }
    
    public function getCiudad()
    {
        return $this->_ciudad;
    }
    public function setCiudad($ciu)
    {
        $this->_ciudad=$ciu;
    }
    
    public function getCodigo()
    {
        return $this->_codigo;
    }
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    
    public function getNombre()
    {
        return $this->_nombre;
    }
    public function setNombre($nom)
    {
        $this->_nombre=$nom;
    }
}