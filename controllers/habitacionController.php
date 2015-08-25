<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class habitacionController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){}
    
    public function editar()
    {
        $ETH_codHotel= $this->getTexto('H_codHotel');
        if($ETH_codHotel)
        {
            Session::set('sessMOD_ETH_codHotel', $ETH_codHotel);
            $ETH_hotel= $this->loadModel('hotel');
            $ETH_tHab= $this->loadModel('tipoHab');
            
            
            $ETH_objHotel= $ETH_hotel->getHotel($ETH_codHotel);
            $this->_view->ETH_nombreHotel= $ETH_objHotel[0]->getHotel();
            
            
            $this->_view->ETH_objsTipoHab= $ETH_tHab->getTipoHab();
        
            
            $this->_view->renderingCenterBox('editarTipoHab');
        }
        else
        {
            throw new Exception('Error al editar Tipo habitaci&oacute;n');
        }
    }
    
    public function detalle()
    {
        $DTH_codTiHab= $this->getTexto('_PCD_');
        if($DTH_codTiHab)
        {
            Session::set('sessMOD_DTH_codTipoHab', $DTH_codTiHab);
            $DTH_tHab= $this->loadModel('tipoHab');
            
            $DTH_objsTipoHab= $DTH_tHab->getTipoHab($DTH_codTiHab);
            $this->_view->DTH_nombreDTipoHab= $DTH_objsTipoHab[0]->getNombre();
            
            $DTH_objsDetTipoHab= $DTH_tHab->getDetTipoHab($DTH_codTiHab, Session::get('sessMOD_ETH_codHotel'));
            if($DTH_objsDetTipoHab)
            {
                Session::set('sess_DTH_cntFotos', 1);
                $this->_view->DTH_foto1= $DTH_objsDetTipoHab[0]->getFoto1();
                $this->_view->DTH_foto2= $DTH_objsDetTipoHab[0]->getFoto2();
                $this->_view->DTH_foto3= $DTH_objsDetTipoHab[0]->getFoto3();
                $this->_view->DTH_foto4= $DTH_objsDetTipoHab[0]->getFoto4();
                
                Session::set('sessMOD_DTH_img1', $this->_view->DTH_foto1);
                Session::set('sessMOD_DTH_img2', $this->_view->DTH_foto2);
                Session::set('sessMOD_DTH_img3', $this->_view->DTH_foto3);
                Session::set('sessMOD_DTH_img4', $this->_view->DTH_foto4);
            }
            else
            {
                Session::set('sess_DTH_cntFotos', 0);
                $this->_view->DTH_foto1=false;
                $this->_view->DTH_foto2=false;
                $this->_view->DTH_foto3=false;
                $this->_view->DTH_foto4=false;
                
                Session::set('sessMOD_DTH_img1', $this->_view->DTH_foto1);
                Session::set('sessMOD_DTH_img2', $this->_view->DTH_foto2);
                Session::set('sessMOD_DTH_img3', $this->_view->DTH_foto3);
                Session::set('sessMOD_DTH_img4', $this->_view->DTH_foto4);
            }
            
            $this->_view->renderingCenterBox('detalleTipoHab');
        }
        else
        {
            throw new Exception('Error al cargar el detalle de tipo habitaci&oacute;n');
        }
    }
    
    public function modificar()
    {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest' || (Session::get('sess_browser') == 'IE9'))
        {
            $MTH_tHab= $this->loadModel('tipoHab');
            //$this->getLibrary('upload' . DS . 'class.upload');
            $rutaImg= ROOT . 'public' . DS . 'img' . DS .'tipo_habitacion' . DS;

            $cntFotos=0;
            $ML_status=true;
            $ML_sqlIns='INSERT INTO fotos_hoteles (tipoh, cod_hotel';
            for($i=1; $i<=4; $i++)
            {
                if(isset($_FILES['DTH_flImagen' . $i]['name']))
                {
                    if($_FILES['DTH_flImagen' . $i]['name'])
                    {
                        if(Functions::validaFoto($_FILES['DTH_flImagen' . $i]['type'])==false)
                        {
                            $ML_status=false;
                            echo 'La Imagen '. $i .' debe ser formato [.JPG] [.GIF] [.PNG]';
                            break;
                        }

                        if($_FILES['DTH_flImagen' . $i]['size'] > 524288) //512KB
                        {
                            $ML_status=false;
                            echo 'La Imagen '. $i .' debe ser menor a <b>500kb</b>';
                            break;
                        }
                        
                        $ML_sqlIns.=', foto' . $i;
                    }
                    else
                    {
                        ++$cntFotos;
                    }
                }
                else
                {
                    ++$cntFotos;
                }
            }
            
            
            
            
            
            
            if($ML_status)
            {
                $ML_sqlUpd='UPDATE fotos_hoteles SET ';
                $ML_sqlIns.=') VALUES ( "'.Session::get('sessMOD_DTH_codTipoHab').'", "'.Session::get('sessMOD_ETH_codHotel').'" ';
                $ML_c='';
                for($i=1; $i<=4; $i++)
                {
                    if(isset($_FILES['DTH_flImagen' . $i]['name']))
                    {
                        if($_FILES['DTH_flImagen' . $i]['name'])
                        {
                            $upload= new upload($_FILES['DTH_flImagen' . $i], 'es_ES');
                            $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                            $upload->file_max_size = '524288'; // 512KB
                            $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                            $upload->process($rutaImg);
                            
                            $ML_sqlIns.= ', "' . $upload->file_dst_name . '" ';
                            $ML_sqlUpd.= $ML_c . ' foto' . $i . '= "' . $upload->file_dst_name . '" ';
                            $ML_c=','; 
                            /*if($upload->processed)
                            {   //THUMBNAILS
                                $imagen= $upload->file_dst_name; //nombre de la imagen
                                $thumb= new upload($upload->file_dst_pathname);
                                $thumb->image_resize= true;
                                $thumb->image_x= 100;
                                $thumb->image_y= 100;
                                $thumb->file_name_body_pre= 'thumb_';
                                $thumb->process($rutaImg . 'thumb' . DS);
                            }
                            else
                            {
                                echo '(Imagen ' . $i . ')'.$upload->error . '<br>';
                            }*/
                        }
                    }
                    else
                    {
                        if($this->getTexto('chkDTH_flImagen' . $i)=='on')
                        {
                            $cntFotos=0;
                            Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            $ML_sqlUpd.= $ML_c . ' foto' . $i . '= "" ';
                            $ML_c=',';
                        }
                    }
                    
                }
                
                
                if($cntFotos==4)
                {
                    $ML_status=false;
                    echo 'Para modificar debe realizar al menos un cambio. ';
                }
                else
                {
                    if(Session::get('sess_DTH_cntFotos')==1)
                    {
                        $ML_sqlUpd.=' WHERE tipoh = "'.Session::get('sessMOD_DTH_codTipoHab').'" AND cod_hotel = "'.Session::get('sessMOD_ETH_codHotel').'"';
                        //echo $ML_sqlUpd;
                        $MTH_tHab->exeSQL($ML_sqlUpd);
                    }
                    else
                    {
                        $ML_sqlIns.=')';
                        $MTH_tHab->exeSQL($ML_sqlIns);
                    }
                    echo 'OK';
                }
                
            }
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }
}