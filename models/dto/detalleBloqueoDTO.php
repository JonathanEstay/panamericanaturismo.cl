<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class detalleBloqueoDTO
{
    private $_nompax;
    private $_rut;
    private $_fchild;
    private $_ninfant;
    private $_rut_inf;
    private $_finfant;
    private $_tp;
    private $_tipo_pax;
    private $_fecha_pag;
    private $_hora_robot;
    
    public function setNomPax($nom)
    {
        $this->_nompax=$nom;
    }
    public function getNomPax()
    {
        return $this->_nompax;
    }
    
    
    public function setRut($rut)
    {
        $this->_rut=$rut;
    }
    public function getRut()
    {
        return $this->_rut;
    }
    
    
    public function setFChild($fch)
    {
        $this->_fchild=$fch;
    }
    public function getFChild()
    {
        return $this->_fchild;
    }
    
    
    public function setNInfant($ni)
    {
        $this->_ninfant=$ni;
    }
    public function getNInfant()
    {
        return $this->_ninfant;
    }
    
    
    public function setRutInf($rutI)
    {
        $this->_rut_inf=$rutI;
    }
    public function getRutInf()
    {
        return $this->_rut_inf;
    }
    
    
    public function setFInfant($fi)
    {
        $this->_finfant=$fi;
    }
    public function getFInfant()
    {
        return $this->_finfant;
    }
    
    
    public function setTp($tp)
    {
        $this->_tp=$tp;
    }
    public function getTp()
    {
        return $this->_tp;
    }
    
    
    public function setTipoPax($tpax)
    {
        $this->_tipo_pax=$tpax;
    }
    public function getTipoPax()
    {
        return $this->_tipo_pax;
    }
    
    
    public function setFechaPag($fp)
    {
        $this->_fecha_pag=$fp;
    }
    public function getFechaPag()
    {
        return $this->_fecha_pag;
    }
    
    
    public function setHoraRobot($hora)
    {
        $this->_hora_robot=$hora;
    }
    public function getHoraRobot()
    {
        return $this->_hora_robot;
    }
}