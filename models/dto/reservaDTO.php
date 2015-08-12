<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class reservaDTO
{
    private $_agencia;
    private $_num_file;
    private $_nompax;
    private $_totventa;
    private $_estado;
    private $_totpag;
    private $_usuario;
    private $_moneda;
    private $_fecha;
    private $_fecha2;
    private $_f_viaje;
    private $_f_viaje2;
    private $_row;
    private $_cod_pak;
    private $_record_c;
    private $_vage;
    private $_npax;
    private $_cambio;
    private $_comag;
    private $_datos;
    private $_ajuste;
    private $_tcomi;
    
    public function setAgencia($agen)
    {
        $this->_agencia=$agen;
    }
    public function getAgencia()
    {
        return $this->_agencia;
    }
    
    
    public function setFile($file)
    {
        $this->_num_file=$file;
    }
    public function getFile()
    {
        return $this->_num_file;
    }
    
    
    public function setNomPax($nompax)
    {
        $this->_nompax=$nompax;
    }
    public function getNomPax()
    {
        return $this->_nompax;
    }
    
    
    public function setTotVenta($tventa)
    {
        $this->_totventa=$tventa;
    }
    public function getTotVenta()
    {
        return $this->_totventa;
    }
    
    
    public function setEstado($estado)
    {
        $this->_estado=$estado;
    }
    public function getEstado()
    {
        return $this->_estado;
    }
    
    
    public function setTotPag($tpag)
    {
        $this->_totpag=$tpag;
    }
    public function getTotPag()
    {
        return $this->_totpag;
    }
    
    
    public function setUsuario($user)
    {
        $this->_usuario=$user;
    }
    public function getUsuario()
    {
        return $this->_usuario;
    }
    
    
    public function setMoneda($mon)
    {
        $this->_moneda=$mon;
    }
    public function getMoneda()
    {
        return $this->_moneda;
    }
    
    
    public function setFecha($fecha)
    {
        $this->_fecha=$fecha;
    }
    public function getFecha()
    {
        return $this->_fecha;
    }
    
    
    public function setFecha2($fecha2)
    {
        $this->_fecha2=$fecha2;
    }
    public function getFecha2()
    {
        return $this->_fecha2;
    }
    
    
    public function setFViaje($fviaje)
    {
        $this->_f_viaje=$fviaje;
    }
    public function getFViaje()
    {
        return $this->_f_viaje;
    }
    
    
    public function setFViaje2($fviaje2)
    {
        $this->_f_viaje2=$fviaje2;
    }
    public function getFViaje2()
    {
        return $this->_f_viaje2;
    }
    
    
    public function setRow($row)
    {
        $this->_row=$row;
    }
    public function getRow()
    {
        return $this->_row;
    }
    
    
    public function setCodPak($cod)
    {
        $this->_cod_pak=$cod;
    }
    public function getCodPak()
    {
        return $this->_cod_pak;
    }
    
    
    public function setRecordC($record)
    {
        $this->_record_c=$record;
    }
    public function getRecordC()
    {
        return $this->_record_c;
    }
    
    
    public function setVage($vage)
    {
        $this->_vage=$vage;
    }
    public function getVage()
    {
        return $this->_vage;
    }
    
    
    public function setNpax($npax)
    {
        $this->_npax=$npax;
    }
    public function getNpax()
    {
        return $this->_npax;
    }
    
    
    public function setCambio($cam)
    {
        $this->_cambio=$cam;
    }
    public function getCambio()
    {
        return $this->_cambio;
    }
    
    
    public function setComag($comag)
    {
        $this->_comag=$comag;
    }
    public function getComag()
    {
        return $this->_comag;
    }
    
    
    public function setDatos($datos)
    {
        $this->_datos=$datos;
    }
    public function getDatos()
    {
        return $this->_datos;
    }
    
    
    public function setAjuste($ajuste)
    {
        $this->_ajuste=$ajuste;
    }
    public function getAjuste()
    {
        return $this->_ajuste;
    }
    
    
    public function setTcomi($tcomi)
    {
        $this->_tcomi= $tcomi;
    }
    public function getTcomi()
    {
        return $this->_tcomi;
    }
}