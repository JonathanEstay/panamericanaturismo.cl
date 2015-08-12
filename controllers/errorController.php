<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class errorController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->_view->titulo= 'Error';
        $this->_view->mensaje= $this->_getError();
        $this->_view->renderingMain('index');
    }
    
    
    public function access($codigo)
    {
        $this->_view->titulo= 'Error';
        $this->_view->mensaje= $this->_getError($codigo);
        $this->_view->renderingMain('access');
    }
    
    //utilizo '_' para identificar que es una funcion privada
    private function _getError($codigo = false) 
    {
        if($codigo) {
            //$codigo = $this->filtrarInt($codigo);
            if(is_int($codigo))
                $codigo=$codigo;
            
        } else {
            $codigo = 'default';
        }
        
        $error['default'] = 'Ha ocurrido un error en esta página';
        $error['5050'] = 'Acceso restringido';
        $error['8080'] = 'Tiempo de la session agotado';
        
        if(array_key_exists($codigo, $error)) {
            return $error[$codigo];
        } else {
            return $error['default'];
        }
    }
}

?>