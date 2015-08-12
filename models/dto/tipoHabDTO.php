<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class tipoHabDTO
{
    private $_codigo;
    private $_nombre;
    private $_tipoh;
    private $_cod_hotel;
    private $_foto1;
    private $_foto2;
    private $_foto3;
    private $_foto4;
    
    
    public function getFoto4()
    {
        return $this->_foto4;
    }
    public function setFoto4($foto)
    {
        $this->_foto4=$foto;
    }
    
    public function getFoto3()
    {
        return $this->_foto3;
    }
    public function setFoto3($foto)
    {
        $this->_foto3=$foto;
    }
    
    public function getFoto2()
    {
        return $this->_foto2;
    }
    public function setFoto2($foto)
    {
        $this->_foto2=$foto;
    }
    
    public function getFoto1()
    {
        return $this->_foto1;
    }
    public function setFoto1($foto)
    {
        $this->_foto1=$foto;
    }
    
    public function getCodHotel()
    {
        return $this->_cod_hotel;
    }
    public function setCodHotel($cod)
    {
        $this->_cod_hotel=$cod;
    }
    
    public function getTipoHab()
    {
        return $this->_tipoh;
    }
    public function setTipoHab($th)
    {
        $this->_tipoh=$th;
    }
    
    public function getNombre()
    {
        return $this->_nombre;
    }
    public function setNombre($nom)
    {
        $this->_nombre=$nom;
    }
    
    public function getCodigo()
    {
        return $this->_codigo;
    }
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
}