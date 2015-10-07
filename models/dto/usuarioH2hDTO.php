<?php

/*
 * Proyecto : PanamericanaWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : viernes, 02 de octubre de 2015
 */

class usuarioH2hDTO {
    
    private $_correoejecutivo;
    private $_correovendedor;
    
    
    
    public function setCorreoEjecutivo($correo) {
        $this->_correoejecutivo = $correo;
    }
    public function getCorreoEjecutivo() {
        return $this->_correoejecutivo;
    }
    
    
    public function setCorreoVendedor($correo) {
        $this->_correovendedor=$correo;
    }
    public function getCorreoVendedor(){
        return $this->_correovendedor;
    }
}
