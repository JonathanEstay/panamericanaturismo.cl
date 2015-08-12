<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class tipoHabDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getTipoHab($cod=0)
    {
        $sql='SELECT codigo, nombre FROM tipoh';
		
        if(!empty($cod))
        {
            $sql.=' WHERE codigo="'.$cod.'"';
        }
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos))
        {
            $objsTipoH= array();
            $arrayTipoH= $this->_db->fetchAll($datos);
            
            foreach ($arrayTipoH as $thabDB)
            {
                $objTipoH= new tipoHabDTO();
                
                $objTipoH->setCodigo(trim($thabDB['codigo']));
                $objTipoH->setNombre(trim($thabDB['nombre']));
                
                $objsTipoH[]=$objTipoH;
            }
            
            return $objsTipoH;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getDetTipoHab($tipo, $cod)
    {
        $sql='SELECT tipoh, foto1, foto2, foto3, foto4, cod_hotel 	
            FROM fotos_hoteles 
            WHERE tipoh = "'.$tipo.'" AND cod_hotel = '.$cod;
        
        //echo $sql;
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos))
        {
            $objsDetTipoH= array();
            $arrayDetTipoH= $this->_db->fetchAll($datos);
            
            foreach ($arrayDetTipoH as $detThabDB)
            {
                $objDetTipoH= new tipoHabDTO();
                
                $objDetTipoH->setTipoHab(trim($detThabDB['tipoh']));
                $objDetTipoH->setFoto1(trim($detThabDB['foto1']));
                $objDetTipoH->setFoto2(trim($detThabDB['foto2']));
                $objDetTipoH->setFoto3(trim($detThabDB['foto3']));
                $objDetTipoH->setFoto4(trim($detThabDB['foto4']));
                $objDetTipoH->setCodHotel(trim($detThabDB['cod_hotel']));
                
                
                $objsDetTipoH[]=$objDetTipoH;
            }
            
            return $objsDetTipoH;
        }
        else
        {
            return false;
        }
    }
    
    
    public function exeSQL($sql)
    {
        $this->_db->consulta($sql);
    }
}