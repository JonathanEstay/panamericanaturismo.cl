<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class usuarioDTO
{
    private $_clave;
    private $_password;
    private $_cambio_pass;
    private $_nombre;
    private $_codigo;
    private $_dctod;
    private $_dctoh;
    private $_id_agencia;
    private $_agencia;
    private $_markup;
    private $_fecha_pass;
    private $_depto;
    private $_atipoa;
    private $_firma;
    private $_correo;
    private $_correo_admin;
    private $_rut;
    
    
    public function getRut() {
        return $this->_rut;
    }

    public function setRut($rut) {
        $this->_rut = $rut;
    }

        
    public function setClave($clave)
    {
        $this->_clave=$clave;
    }
    public function getClave()
    {
        return $this->_clave;
    }
    
    
    public function setPassword($pass)
    {
        $this->_password=$pass;
    }
    public function getPassword()
    {
        return $this->_password;
    }
    
    
    public function setCambioPass($cpass)
    {
        $this->_cambio_pass=$cpass;
    }
    public function getCambioPass()
    {
        return $this->_cambio_pass;
    }
    
    
    public function setCodigo($codigo)
    {
        $this->_codigo=$codigo;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    
    public function setDoctoD($dctod)
    {
        $this->_dctod=$dctod;
    }
    public function getDoctoD()
    {
        return $this->_dctod;
    }
    
    
    public function setDoctoH($dctoh)
    {
        $this->_dctoh=$dctoh;
    }
    public function getDoctoH()
    {
        return $this->_dctoh;
    }
    
    
    public function setIdAgen($idAgen)
    {
        $this->_id_agencia=$idAgen;
    }
    public function getIdAgen()
    {
        return $this->_id_agencia;
    }
    
    
    public function setAgencia($agencia)
    {
        $this->_agencia=$agencia;
    }
    public function getAgencia()
    {
        return $this->_agencia;
    }
    
    
    public function setNombre($nombre)
    {
        $this->_nombre=$nombre;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
    
    
    public function setEmail($correo)
    {
        $this->_correo=$correo;
    }
    public function getEmail()
    {
        return $this->_correo;
    }
    
    
    public function setEmailOpera($correoAd)
    {
        $this->_correo_admin=$correoAd;
    }
    public function getEmailOpera()
    {
        return $this->_correo_admin;
    }
    
    
    public function setMarkup($markup)
    {
        $this->_markup= $markup;
    }
    public function getMarkup()
    {
        return $this->_markup;
    }
    
    
    public function setFechaPass($fecpass)
    {
        $this->_fecha_pass=$fecpass;
    }
    public function getFechaPass()
    {
        return $this->_fecha_pass;
    }
    
    
    public function setDepto($depto)
    {
        $this->_depto=$depto;
    }
    public function getDepto()
    {
        return $this->_depto;
    }
    
    
    public function setAtipoa($atipoa)
    {
        $this->_atipoa=$atipoa;
    }
    public function getAtipoa()
    {
        return $this->_atipoa;
    }
    
    
    public function setFirma($firma)
    {
        $this->_firma=$firma;
    }
    public function getFirma()
    {
        return $this->_firma;
    }
}
?>