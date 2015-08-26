<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class voucherController extends Controller
{
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad= $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    
    public function index($form='') {
        $this->_view->form=$form;
        Session::acceso('Usuario');
        $agencia= $this->loadModel('agencia');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();
        
        $this->_view->objAgencias= $agencia->getAgencias();
        
        $this->_view->currentMenu=4;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('imagenes');
    }
    
    
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                          METODOS VIEWS CENTER BOX                            *
    *                                                                              *
    *******************************************************************************/
    public function logo($form='') {
        $this->_view->form=$form;
        Session::destroy('sessMOD_LV_idAgen');
        Session::destroy('sessMOD_LV_imagen');
        $I_idAgen= $this->getTexto('_PCD_');
        if($I_idAgen)
        {
            Session::set('sessMOD_LV_idAgen', $I_idAgen);
            $agencia= $this->loadModel('agencia');
            $LV_objAgencia= $agencia->getAgencias($I_idAgen);
            if($LV_objAgencia)
            {
                $this->_view->I_nombre= $LV_objAgencia[0]->getNombre();
                $this->_view->I_imagen= $LV_objAgencia[0]->getImagen();
                Session::set('sessMOD_LV_imagen', $this->_view->I_imagen);
                
                $this->_view->renderingCenterBox('logoVoucher');
            }
            else
            {
                throw new Exception('Error al intentar ver agencia');
            }
        }
    }
    
    
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                             METODOS PROCESADORES                             *
    *                                                                              *
    *******************************************************************************/
    public function modificar() {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest' || (Session::get('sess_browser') == 'IE9'))
        {
            $rutaIMG= ROOT . 'public' . DS . 'img' . DS . 'voucher' . DS;
            $MLV_agencia= $this->loadModel('agencia');
            
            //echo var_dump($_POST);
            //echo '<br>';echo '<br>';echo '<br>';
            //echo var_dump($_FILES); exit;
            
            if(isset($_FILES['flImagenVouAgen']['name']))
            {
                if($_FILES['flImagenVouAgen']['name'])
                {
                    //$this->getLibrary('upload' . DS . 'class.upload');

                    $upload= new upload($_FILES['flImagenVouAgen'], 'es_ES');
                    $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                    $upload->file_max_size = '524288'; // 512KB
                    //$upload->file_new_name_body= 'upl_' . uniqid();
                    $upload->file_new_name_body= 'upl_' . Session::get('sessMOD_LV_idAgen');
                    $upload->process($rutaIMG);

                    if($upload->processed)
                    {
                        $MLV_agencia->actualizaVoucherAgen(Session::get('sessMOD_LV_idAgen'), $upload->file_dst_name);
                        echo 'OK';
                    }
                    else
                    {
                        throw new Exception( $upload->error );
                    }
                }
                else
                {
                    throw new Exception('Debe seleccionar un archivo desde su computador...');
                }
            }
            else
            {
                if($this->getTexto('chk_flImagenVouAgen'))
                {
                    if($this->getTexto('chk_flImagenVouAgen')=='on')
                    {
                        if(Functions::eliminaFile($rutaIMG . Session::get('sessMOD_LV_imagen')))
                        {
                            $MLV_agencia->actualizaVoucherAgen(Session::get('sessMOD_LV_idAgen'), '');
                            echo 'OK';
                        }
                        else
                        {
                            throw new Exception('Error al eliminar el archivo, intente nuevamente');
                        }
                    }
                    else
                    {
                        throw new Exception('Debe seleccionar un archivo a eliminar');
                    }
                }
                else
                {
                    throw new Exception('Debe seleccionar un archivo desde su computador');
                }
            }
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }
}