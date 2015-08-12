<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class paisDAO extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais($name) {
        $sql = 'SELECT codigo, nombre FROM pais WHERE nombre = "'.$name.'" ';
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos)) {
            
        } else {
            return false;
        }
    }
}