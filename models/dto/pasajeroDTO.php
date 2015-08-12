<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class pasajeroDTO
{
    private $_nombre;
    private $_apellido;
    private $_tipo;
    private $_edad;
    private $_rut;
    private $_hab;
    
    
    public function getNombre() {
        return $this->_nombre;
    }
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }
    
    
    public function getApellido() {
        return $this->_apellido;
    }
    public function setApellido($ape) {
        $this->_apellido = $ape;
    }
    
    
    public function getTipo() {
        return $this->_tipo;
    }
    public function setTipo($tipo) {
        $this->_tipo = $tipo;
    }
    
    
    public function getEdad() {
        return $this->_edad;
    }
    public function setEdad($edad) {
        $this->_edad = $edad;
    }
    
    
    public function getRut() {
        return $this->_rut;
    }
    public function setRut($rut) {
        $this->_rut = $rut;
    }
    
    
    public function getHab() {
        return $this->_hab;
    }
    public function setHab($hab) {
        $this->_hab = $hab;
    }
}

?>