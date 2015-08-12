<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Request
{
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    
    public function __construct() {
        
        if(isset($_GET['url'])) {
            
            $url= filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);//Limpia url
            $url= explode('/', $url);
            $url= array_filter($url); //arreglos no validos los elimina, (elimina '/' sobrantes)
            
            
            /* Modulos de la aplicacion */
            //1. modulo/controlador/metodo/argumento
            //2. controlador/metodo/argumento
            //$this->_modules = array('system'/*, 'login'*/);
            /*$this->_modulo = strtolower(array_shift($url));
            if(!$this->_modulo) {
                $this->_modulo = false;
            } else {
                if(count($this->_modules)) {
                    if(!in_array($this->_modulo, $this->_modules)) {
                        $this->_controlador = $this->_modulo;
                        $this->_modulo = false;
                    } else {
                        $this->_controlador = strtolower(array_shift($url));
                        
                        if(!$this->_controlador) {
                            $this->_controlador = 'index';
                        }
                    }
                } else {
                    $this->_controlador = $this->_modulo;
                    $this->_modulo = false;
                }
            }*/
            
            
            $this->_controlador= strtolower(array_shift($url)); //extrae el primer elemento del arreglo, y lo asigna
            $this->_metodo= strtolower(array_shift($url)); //extrae el primer elemento del arreglo, y lo asigna, viene sin el ontrolador
            $this->_argumentos= $url; //viene sin controlador ni metodo
        }
        
        if (!$this->_controlador) {
            $this->_controlador = DEFAULT_CONTROLLER;
        }

        if (!$this->_metodo) {
            $this->_metodo = 'index';
        }

        if (!$this->_argumentos) {
            $this->_argumentos = array();
        }
    }
    
    
    
    public function getModulo() {
        return $this->_modulo;
    }

    public function getControlador() {
        return $this->_controlador;
    }

    public function getMetodo() {
        return $this->_metodo;
    }

    public function getArgs() {
        return $this->_argumentos;
    }

}