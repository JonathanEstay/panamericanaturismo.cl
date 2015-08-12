<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class detalleReservaDTO
{
    private $_file;
    private $_codigo;
    private $_nombre;
    private $_in;
    private $_out;
    private $_paxS;
    private $_paxD;
    private $_paxT;
    private $_paxQ;
    private $_paxC1;
    private $_paxC2;
    private $_paxA;
    private $_paxI;
    private $_paxCA;
    
    
    public function setFile($file)
    {
        $this->_file=$file;
    }
    public function getFile()
    {
        return $this->_file;
    }
    
    
    public function setCodigo($cod)
    {
        $this->_codigo= $cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    
    public function setNombre($nom)
    {
        $this->_nombre=$nom;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
    
    
    public function setIN($in)
    {
        $this->_in=$in;
    }
    public function getIn()
    {
        return $this->_in;
    }
    
    
    public function setOut($out)
    {
        $this->_out=$out;
    }
    public function getOut()
    {
        return $this->_out;
    }
    
    
    public function setPaxS($s)
    {
        $this->_paxS=$s;
    }
    public function getPaxS()
    {
        return $this->_paxS;
    }
    
    
    public function setPaxD($d)
    {
        $this->_paxD=$d;
    }
    public function getPaxD()
    {
        return $this->_paxD;
    }
    
    
    public function setPaxT($t)
    {
        $this->_paxT=$t;
    }
    public function getPaxT()
    {
        return $this->_paxT;
    }
    
    
    public function setPaxQ($q)
    {
        $this->_paxQ=$q;
    }
    public function getPaxQ()
    {
        return $this->_paxQ;
    }
    
    
    public function setPaxC1($c1)
    {
        $this->_paxC1=$c1;
    }
    public function getPaxC1()
    {
        return $this->_paxC1;
    }
    
    
    public function setPaxC2($c2)
    {
        $this->_paxC2=$c2;
    }
    public function getPaxC2()
    {
        return $this->_paxC2;
    }
    
    
    public function setPaxA($a)
    {
        $this->_paxA=$a;
    }
    public function getPaxA()
    {
        return $this->_paxA;
    }
    
    
    public function setPaxI($i)
    {
        $this->_paxI=$i;
    }
    public function getPaxI()
    {
        return $this->_paxI;
    }
    
    
    public function setPaxCA($ca)
    {
        $this->_paxCA=$ca;
    }
    public function getPaxCA()
    {
        return $this->_paxCA;
    }
}