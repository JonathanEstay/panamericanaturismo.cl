<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class pasajeroDAO extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPasajeros($num_file) {
        
        $sql = 'SELECT * FROM rooming WHERE num_file = ' . $num_file;
        //echo $sql;
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos) > 0) {
            $objetosPax= array();
            $arrayRooming = $this->_db->fetchAll($datos);
            foreach($arrayRooming as $objDB) {
                $objPasajero = new pasajeroDTO();
                
                $objPasajero->setNombre(trim($objDB['nombre']));
                $objPasajero->setApellido(trim($objDB['apellido']));
                $objPasajero->setTipo(trim($objDB['tipo']));
                $objPasajero->setEdad(trim($objDB['edad']));
                $objPasajero->setRut(trim($objDB['rut']));
                $objPasajero->setHab(trim($objDB['nhab']));
                
                $objetosPax[] = $objPasajero;
            }
            
            return $objetosPax;
            
        } else {
            return false;
        }
    }
}
