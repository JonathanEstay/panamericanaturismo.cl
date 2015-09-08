<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class View
{
    //private $_request;
    private $_controlador;
    private $_js;
    private $_rutas;
    private $_args;
    
    public function __construct(Request $peticion) { //$peticion es un objeto de Request
        $this->_controlador= $peticion->getControlador();
        //$this->_request = $peticion;
        $this->_js=array();
        $this->_rutas = array();
  
        $this->_args = $peticion->getArgs();
        /*$modulo = $this->_request->getModulo();
        $controlador= $this->_request->getControlador();
        
        if($modulo) {
            $this->_rutas['view'] = ROOT . 'modules' . DS . $modulo . DS . 'views' . DS . $controlador . DS; 
            $this->_rutas['js'] = BASE_URL . 'modules/' . $modulo . '/views/' . $controlador . '/js/'; 
        } else {
            $this->_rutas['view'] = ROOT . 'views' . DS . $controlador . DS; 
            $this->_rutas['js'] = BASE_URL . 'views/' . $controlador . '/js/'; 
        }*/
    }
    
    
    public function setJs(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                //$this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
                $this->_js[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }
    
    
    public function renderingMain($vista, $item=false) //principal
    {
        //se incluye directamente el '/' ya que estas rutas siempre van a ser asi
        $_layoutParams= array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/', 
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/', 
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/'
        );
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView))
        {
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'menu-left.php';
            include_once $rutaView;
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }
        else
        {
            throw new Exception('Error de vista: '.$rutaView);
        }
    }
    
    
    public function getArgumentos(){
        return $this->_args;
    }

    

    public function renderingSystem($vista, $item=false)
    {
        $js = array();
        
        if(count($this->_js)){
            $js = $this->_js;
        }
        
        //se incluye directamente el '/' ya que estas rutas siempre van a ser asi
        $_layoutParams= array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/', 
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/', 
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_hoteles' => BASE_URL . 'public/img/hoteles/',
            'ruta_programas' => BASE_URL . 'public/img/programas/',
            'js' => $js
        );
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView))
        {
            if($item){
                include_once ROOT . 'views' . DS . 'layout' . DS . 'buscador' . DS . '_NavBar.php';
                include_once ROOT . 'views' . DS . 'layout' . DS . 'buscador' . DS . '_LeftSidebar.php';
            } else {
                include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . '_NavBar.php';
                include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . '_LeftSidebar.php';
            }
            
            
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . '_Footer.php';
        }
        else
        {
            throw new Exception('Error de vista: '.$rutaView);
        }
    }
    
    
    
    
    public function renderingCenterBox($vista, $item=false)
    {
        //se incluye directamente el '/' ya que estas rutas siempre van a ser asi
        $_layoutParamsCB= array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/', 
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/', 
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_js_public' => BASE_URL . 'public/js/',
            'ruta_pdf' => BASE_URL . 'public/pdf/',
            'ruta_voucher' => BASE_URL . 'public/img/voucher/',
            'ruta_fotos_hab' => BASE_URL . 'public/img/tipo_habitacion/',
            'ruta_fotos_hotel' => BASE_URL . 'public/img/hoteles/',
            'ruta_fotos_hotel_thumb' => BASE_URL . 'public/img/hoteles/thumb/thumb_',
            'ruta_iconos_hotel' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/hotel/',
            'ruta_programas' => BASE_URL . 'public/img/programas/'
        );
        
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . 'centerBox' . DS . $vista . '.phtml';
        if(is_readable($rutaView))
        {
            include_once $rutaView;
        }
        else
        {
            throw new Exception('Error de vista AJAX: ' . $vista);
        }
    }
    
}