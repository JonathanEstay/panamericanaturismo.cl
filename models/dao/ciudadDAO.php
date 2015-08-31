<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class ciudadDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getCiudades($codigo='')
    {
        $sql='SELECT C.nombre AS cnombre, C.codigo AS ccodigo 
		FROM ciudad C ';

        if(!empty($codigo))
        {
            $sql.=' WHERE C.codigo = "'.$codigo.'" ';
        }

        $sql.=' GROUP BY C.nombre, C.codigo
        ORDER BY C.nombre ASC';
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['cnombre']));
                $ciudadObj->setCodigo(trim($ciuDB['ccodigo']));
                
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getCiudadesPRG()
    {
        $sql = 'EXEC combo_ciudades_terrestres';
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['ciudad']));
                $ciudadObj->setCodigo(trim($ciuDB['codigo']));
                
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getCiudad($codigo = false) {
        $sql = 'SELECT codigo, nombre FROM ciudad';
        
        if(!empty($codigo)){ $sql.=' WHERE codigo = "'.$codigo.'" '; }
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['nombre']));
                $ciudadObj->setCodigo(trim($ciuDB['codigo']));
                
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getCiudadesBloq($ciudad='')
    {
        $sql='SELECT C.nombre AS ciudad
            FROM ciudad	C
            JOIN h2h_Programa P ON (C.codigo = P.Ciudad)
            JOIN h2h_ProgramaOpc PO ON (P.Id = PO.IdProg)
            JOIN bloqueos B ON (PO.record_c = B.record_c)
            WHERE PO.record_c <> "" AND getdate() <= PO.hasta AND B.estado = "A" 
            AND (SELECT COUNT(NUM_FILE) FROM DET_BLOQ DB WHERE DB.RECORD_C = PO.record_c AND  DB.num_file=0 and tipo="") > 0';
        
        if(!empty($ciudad))
        {
            $sql.=' AND C.nombre LIKE "'.$ciudad.'%" ';
        }

        $sql.=' GROUP BY C.nombre
            ORDER BY C.nombre ASC';
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['ciudad']));
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
}