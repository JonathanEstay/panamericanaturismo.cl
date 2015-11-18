<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class ciudadDAO extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCiudades($codigo = '') {
        $sql = 'SELECT C.nombre AS cnombre, C.codigo AS ccodigo 
		FROM ciudad C ';

        if (!empty($codigo)) {
            $sql.=' WHERE C.codigo = "' . $codigo . '" ';
        }

        $sql.=' GROUP BY C.nombre, C.codigo
        ORDER BY C.nombre ASC';

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();

            foreach ($ciudadArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['cnombre']));
                $ciudadObj->setCodigo(trim($ciuDB['ccodigo']));

                $objetosCiudad[] = $ciudadObj;
            }

            return $objetosCiudad;
        } else {
            return false;
        }
    }

    public function getCiudadesPRG() {
        $sql = 'EXEC combo_ciudades_terrestres';

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();

            foreach ($ciudadArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['ciudad']));
                $ciudadObj->setCodigo(trim($ciuDB['codigo']));

                $objetosCiudad[] = $ciudadObj;
            }

            return $objetosCiudad;
        } else {
            return false;
        }
    }

    public function getCiudad($codigo = false) {
        $sql = 'SELECT codigo, nombre FROM ciudad';

        if (!empty($codigo)) {
            $sql.=' WHERE codigo = "' . $codigo . '" ';
        }

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();

            foreach ($ciudadArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['nombre']));
                $ciudadObj->setCodigo(trim($ciuDB['codigo']));

                $objetosCiudad[] = $ciudadObj;
            }

            return $objetosCiudad;
        } else {
            return false;
        }
    }

    public function getCiudadesBloq($ciudad = '') {
        $sql = 'EXEC combo_ciudades_terrestres 1';

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();

            foreach ($ciudadArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['ciudad']));
                $objetosCiudad[] = $ciudadObj;
            }

            return $objetosCiudad;
        } else {
            return false;
        }
    }

    public function getAdminCiudades() {

        $sql = 'SELECT h.Ciudad , c.nombre FROM h2h_Programa h inner join ciudad c on c.codigo = h.Ciudad group by h.Ciudad,c.nombre';

        $datos = $this->_db->consulta($sql);

        if ($this->_db->numRows($datos) > 0) {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();

            foreach ($ciudadArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['nombre']));
                $objetosCiudad[] = $ciudadObj;
            }

            return $objetosCiudad;
        } else {

            return false;
        }
    }

    public function getSalidas($ciudad) {
        $sql = 'EXEC combo_fechas_salidas "' . $ciudad . '"';

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $salidaArray = $this->_db->fetchAll($datos);
            $objetosSalida = array();

            foreach ($salidaArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setCodigo('0');
                $ciudadObj->setSalida(trim($ciuDB['salida']));

                $objetosSalida[] = $ciudadObj;
            }

            return $objetosSalida;
        } else {
            return false;
        }
    }
    
    public function getCiudadCombo($fecha) {
        $sql= 'EXEC TS_GET_PROG_COMBO_CIUDAD "'.$fecha.'"';
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $salidaArray = $this->_db->fetchAll($datos);
            $objetosSalida = array();
            
            foreach ($salidaArray as $ciuDB) {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['nombre']));
                $ciudadObj->setCodigo(trim($ciuDB['CODIGO']));
                $objetosSalida[] = $ciudadObj;
            }
            return $objetosSalida;
        }else{
          return false;  
        }
        
    }

}
