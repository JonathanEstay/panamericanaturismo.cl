<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class hotelesController extends Controller 
{
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad= $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    public function index($form='')
    {
        $this->_view->form=$form;
        
        Session::acceso('Usuario');
        $categorias= $this->loadModel('categoria');
        $hoteles= $this->loadModel('hotel');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();


        $this->_view->objCategorias= $categorias->getCategorias();
        
        if(Session::get('sess_H_nombre') || Session::get('sess_H_ciudad') || Session::get('sess_H_cat'))
        {
            $this->_view->objHoteles= $hoteles->getHoteles(Session::get('sess_H_nombre'), Session::get('sess_H_ciudad'), Session::get('sess_H_cat'));
        }
        else
        {
            $this->_view->objHoteles=false;
        }
        
        
        
        $this->_view->currentMenu=2;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('hoteles');
    }
    
    public function editar($form='')
    {
        $this->_view->form=$form;
        $EH_codHotel= $this->getTexto('H_codHotel');
        if($EH_codHotel)
        {
            Session::set('sessMOD_EH_codHotel', $EH_codHotel);
            $hoteles= $this->loadModel('hotel');
            $categorias= $this->loadModel('categoria');

            $this->_view->objCategorias= $categorias->getCategorias();
            
            
            $objHotel= $hoteles->getHotel($EH_codHotel);
            if($objHotel)
            {
                $this->_view->EH_hotel= $objHotel[0]->getHotel();
                $this->_view->EH_cat= $objHotel[0]->getCat();
                $this->_view->EH_lat= $objHotel[0]->getLat();
                $this->_view->EH_lon= $objHotel[0]->getLon();
                $this->_view->EH_direc= $objHotel[0]->getDirec();
                $this->_view->EH_web= $objHotel[0]->getSitioWeb();
                $this->_view->EH_descripcion= $objHotel[0]->getDescrip();
                
                $this->_view->EH_imgEnc= $objHotel[0]->getImgEnc();
                $this->_view->EH_imgCont= $objHotel[0]->getImgCont();
                $this->_view->EH_imgCont2= $objHotel[0]->getImgCont2();
                $this->_view->EH_imgCont3= $objHotel[0]->getImgCont3();
                $this->_view->EH_imgCont4= $objHotel[0]->getImgCont4();
                
                /* SERVICIOS HOTEL*/
                if($objHotel[0]->getRestaurante()==1){ $this->_view->EH_rest='checked="checked"'; }
                if($objHotel[0]->getLavanderia()==1){ $this->_view->EH_lavan='checked="checked"'; }
                if($objHotel[0]->getBar()==1){ $this->_view->EH_bar='checked="checked"'; }
                if($objHotel[0]->getCafeteria()==1){ $this->_view->EH_cafe='checked="checked"'; }
                if($objHotel[0]->getServHab()==1){ $this->_view->EH_servHab='checked="checked"'; }
                if($objHotel[0]->getBusiness()==1){ $this->_view->EH_business='checked="checked"'; }
                if($objHotel[0]->getInterHotel()==1){ $this->_view->EH_intHot='checked="checked"'; }
                if($objHotel[0]->getEstaciona()==1){ $this->_view->EH_est='checked="checked"'; }
                if($objHotel[0]->getPiscinaCub()==1){ $this->_view->EH_pCub='checked="checked"'; }
                if($objHotel[0]->getPiscinaDes()==1){ $this->_view->EH_pDes='checked="checked"'; }
                if($objHotel[0]->getGym()==1){ $this->_view->EH_gym='checked="checked"'; }
                if($objHotel[0]->getSpa()==1){ $this->_view->EH_spa='checked="checked"'; }
                if($objHotel[0]->getTenis()==1){ $this->_view->EH_tenis='checked="checked"'; }
                if($objHotel[0]->getGuarderia()==1){ $this->_view->EH_guard='checked="checked"'; }
                if($objHotel[0]->getSalasReu()==1){ $this->_view->EH_salas='checked="checked"'; }
                if($objHotel[0]->getJardin()==1){ $this->_view->EH_jardin='checked="checked"'; }
                if($objHotel[0]->getDiscapacitados()==1){ $this->_view->EH_disca='checked="checked"'; }
                if($objHotel[0]->getBoutique()==1){ $this->_view->EH_bou='checked="checked"'; }
                
                
                /* SERVICIOS HABITACION */
                if($objHotel[0]->getAcondicionado()==1){ $this->_view->EH_acon='checked="checked"'; }
                if($objHotel[0]->getCalefaccion()==1){ $this->_view->EH_cale='checked="checked"'; }
                if($objHotel[0]->getNoFuma()==1){ $this->_view->EH_noFuma='checked="checked"'; }
                if($objHotel[0]->getCajaFuerte()==1){ $this->_view->EH_cajaF='checked="checked"'; }
                if($objHotel[0]->getMiniBar()==1){ $this->_view->EH_mBar='checked="checked"'; }
                if($objHotel[0]->getTV()==1){ $this->_view->EH_tv='checked="checked"'; }
                if($objHotel[0]->getTvCable()==1){ $this->_view->EH_tvC='checked="checked"'; }
                if($objHotel[0]->getInterHab()==1){ $this->_view->EH_intHab='checked="checked"'; }
                if($objHotel[0]->getSecador()==1){ $this->_view->EH_seca='checked="checked"'; }
                if($objHotel[0]->getBarraSeg()==1){ $this->_view->EH_barra='checked="checked"'; }
                if($objHotel[0]->getTelefono()==1){ $this->_view->EH_fono='checked="checked"'; }            
            }
            
            $this->_view->renderingCenterBox('editarHotel');
        }
        else
        {
            throw new Exception('Error al tratar de editar el hotel');
        }
    }
    
    public function modificar()
    {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest'  || (Session::get('sess_browser') == 'IE9'))
        {
            Session::acceso('Usuario');
            
            $MH_nombreHotel= $this->getTexto('txtEH_nombreHotel');
            $MH_direc= $this->getTexto('txtEH_direc');
            $MH_cate= $this->getTexto('cmbEH_categoria');
            $MH_lat= $this->getTexto('txtEH_latitud');
            $MH_lon= $this->getTexto('txtEH_longitud');
            $MH_sitWeb= $this->getTexto('txtEH_sitioWeb');
            $MH_areaDescrip= $this->getPostClave('areaDescrip');
            
            
            if(!$MH_nombreHotel)
            {
                echo 'Debe ingresar un nombre de hotel'; exit;
            }
            else if(!$MH_cate)
            {
                echo 'El hotel debe tener una categor&iacute;a'; exit;
            }
            else if(!$MH_direc)
            {
                echo 'Debe ingresar una direcci&oacute;n para el hotel'; exit;
            }
            
            
            
            $MH_Hotel= $this->loadModel('hotel');
            //$this->getLibrary('upload' . DS . 'class.upload');
            $rutaImg= ROOT . 'public' . DS . 'img' . DS .'hoteles' . DS;

            
            for ($i = 1; $i <= 5; $i++) {
                if (isset($_FILES['flImagen' . $i]['name'])) {
                    if ($_FILES['flImagen' . $i]['name']) {
                        if (Functions::validaFoto($_FILES['flImagen' . $i]['type']) == false) {
                            echo 'La Imagen ' . $i . ' debe ser formato [.JPG] [.GIF] [.PNG]';
                            exit;
                        }

                        if ($_FILES['flImagen' . $i]['size'] > 524288) { //512KB
                            echo 'La Imagen ' . $i . ' debe ser menor a <b>500kb</b>';
                            exit;
                        }
                    }
                }
            }





            //Servicios Hotel
            $MH_chkRest= Functions::validaChk($this->getTexto('chkEH_rest'));
            $MH_chkLavan= Functions::validaChk($this->getTexto('chkEH_lavan'));
            $MH_chkPisDesc= Functions::validaChk($this->getTexto('chkEH_pisDesc'));
            $MH_chkCanTenis= Functions::validaChk($this->getTexto('chkEH_cTenis'));
            $MH_chkBar= Functions::validaChk($this->getTexto('chkEH_bar'));
            $MH_chkBusCen= Functions::validaChk($this->getTexto('chkEH_busCen'));
            $MH_chkSpa= Functions::validaChk($this->getTexto('chkEH_spa'));
            $MH_chkGuard= Functions::validaChk($this->getTexto('chkEH_guarderia'));
            $MH_chkCafe= Functions::validaChk($this->getTexto('chkEH_cafe'));
            $MH_chkInterHot= Functions::validaChk($this->getTexto('chkEH_interHot'));
            $MH_chkGym= Functions::validaChk($this->getTexto('chkEH_gym'));
            $MH_chkSaReu= Functions::validaChk($this->getTexto('chkEH_sReu'));
            $MH_chkServHab= Functions::validaChk($this->getTexto('chkEH_servHab'));
            $MH_chkEst= Functions::validaChk($this->getTexto('chkEH_estaciona'));
            $MH_chkPisCub= Functions::validaChk($this->getTexto('chkEH_pisCub'));
            $MH_chkJar= Functions::validaChk($this->getTexto('chkEH_jardin'));
            $MH_chkDisca= Functions::validaChk($this->getTexto('chkEH_disca'));
            $MH_chkBou= Functions::validaChk($this->getTexto('chkEH_bou'));


            //Servicios Habitacion
            $MH_chkAirAcond= Functions::validaChk($this->getTexto('chkEH_airAcond'));
            $MH_chkCaFuerte= Functions::validaChk($this->getTexto('chkEH_cFuerte'));
            $MH_chkTvCable= Functions::validaChk($this->getTexto('chkEH_tvCable'));
            $MH_chkSecPelo= Functions::validaChk($this->getTexto('chkEH_sPelo'));
            $MH_chkCalef= Functions::validaChk($this->getTexto('chkEH_calefac'));
            $MH_chkMinBar= Functions::validaChk($this->getTexto('chkEH_mBar'));
            $MH_chkFono= Functions::validaChk($this->getTexto('chkEH_fono'));
            $MH_chkBarraSeg= Functions::validaChk($this->getTexto('chkEH_barraSeg'));
            $MH_chkNoFumar= Functions::validaChk($this->getTexto('chkEH_noFumar'));
            $MH_chkTV= Functions::validaChk($this->getTexto('chkEH_tv'));
            $MH_chkInterHab= Functions::validaChk($this->getTexto('chkEH_interHab'));


            $MH_sql='UPDATE hotel 
                    SET hotel="'.mb_convert_encoding($MH_nombreHotel, "ISO-8859-1", "UTF-8").'", direc="'.mb_convert_encoding($MH_direc, "ISO-8859-1", "UTF-8").'", cat="'.$MH_cate.'", descripcion="' . str_replace('\\', '', htmlentities($MH_areaDescrip)) . '", SWEB="'.$MH_sitWeb.'", estado="", 
                    lat="'.$MH_lat.'", lon="'.$MH_lon.'", restaurante='.$MH_chkRest.', bar='.$MH_chkBar.', cafeteria='.$MH_chkCafe.', 
                    s_habitacion='.$MH_chkServHab.', busness_center='.$MH_chkBusCen.', internet_hotel='.$MH_chkInterHot.', estacionamiento='.$MH_chkEst.', 
                    piscina_cub='.$MH_chkPisCub.', piscina_des='.$MH_chkPisDesc.', gym='.$MH_chkGym.', spa='.$MH_chkSpa.', tenis='.$MH_chkCanTenis.', 
                    guarderia='.$MH_chkGuard.', salas_reunion='.$MH_chkSaReu.', jardin='.$MH_chkJar.', discapacitados='.$MH_chkDisca.', 
                    bautique='.$MH_chkBou.', acondicionado='.$MH_chkAirAcond.', calefaccion='.$MH_chkCalef.', no_fuma='.$MH_chkNoFumar.', 
                    caja_fuerte='.$MH_chkCaFuerte.', mini_bar='.$MH_chkMinBar.', television='.$MH_chkTV.', tv_cable='.$MH_chkTvCable.', 
                    inter_hab='.$MH_chkInterHab.',	secador_pelo='.$MH_chkSecPelo.', barra_seguridad='.$MH_chkBarraSeg.', 
                    lavanderia='.$MH_chkLavan.', telefono='.$MH_chkFono;

            

            
            for($i=1; $i<=5; $i++)
            {
                if(isset($_FILES['flImagen' . $i]['name']))
                {
                    if($_FILES['flImagen' . $i]['name'])
                    {
                        $upload= new upload($_FILES['flImagen' . $i], 'es_ES');
                        $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                        $upload->file_max_size = '524288'; // 512KB
                        $upload->file_new_name_body= sha1(uniqid());
                        $upload->process($rutaImg);

                        if($upload->processed)
                        {   //THUMBNAILS
                            $imagen= $upload->file_dst_name; //nombre de la imagen
                            //$MH_sql.= ', foto' . $i . '= "' . $imagen . '" ';

                            $thumb= new upload($upload->file_dst_pathname);
                            $thumb->image_resize= true;
                            $thumb->image_x= 150;
                            $thumb->image_y= 150;
                            $thumb->file_name_body_pre= 'thumb_';
                            $thumb->process($rutaImg . 'thumb' . DS);
                            
                            if($i==1)
                            {	
                                $MH_sql.=', img_encabezado = "'.$imagen.'", mini_img_encabezado = "'.$imagen.'" ';
                            }
                            else if($i==2)
                            {	
                                $MH_sql.=', img_contenido = "'.$imagen.'", mini_img_contenido = "'.$imagen.'" ';
                            }
                            else
                            {
                                $MH_sql.=', img_contenido'.($i-1).' = "'.$imagen.'", mini_img_contenido'.($i-1).' = "'.$imagen.'" ';
                            }
                        }
                        else
                        {
                            echo '(Imagen ' . $i . ')'.$upload->error . '<br>';
                        }
                    }
                }
                else
                {
                    if($i==1)
                    {	
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            Functions::eliminaFile($rutaImg . 'thumb' . DS . 'thumb_' . Session::get('sessMOD_DTH_img' . $i));
                            $MH_sql.=', img_encabezado = "", mini_img_encabezado = "" ';
                            Session::destroy('sessMOD_DTH_img' . $i);
                        }
                    }
                    else if($i==2)
                    {	
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            Functions::eliminaFile($rutaImg . 'thumb' . DS . 'thumb_' . Session::get('sessMOD_DTH_img' . $i));
                            $MH_sql.=', img_contenido = "", mini_img_contenido = "" ';
                            Session::destroy('sessMOD_DTH_img' . $i);
                        }
                    }
                    else
                    {
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            Functions::eliminaFile($rutaImg . 'thumb' . DS . 'thumb_' . Session::get('sessMOD_DTH_img' . $i));
                            //echo Session::get('sessMOD_DTH_img' . $i); exit;
                            $MH_sql.=', img_contenido'.($i-1).' = "", mini_img_contenido'.($i-1).' = "" ';
                            Session::destroy('sessMOD_DTH_img' . $i);
                        }
                    }
                    
                }
            }

            
            $MH_sql.=' WHERE codigo='.$_SESSION['sessMOD_EH_codHotel'];
            
            //echo $MH_sql; exit;
            $MH_Hotel->exeSQL($MH_sql);
            echo 'OK';
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador.');
        }
    }
    
    public function buscar()
    {
        
        if($this->getTexto('txtNombre-Hot') == 'Ingrese nombre hotel') {
            Session::set('sess_H_nombre', '');
        } else {
            Session::set('sess_H_nombre', $this->getTexto('txtNombre-Hot'));
        }
        
        Session::set('sess_H_ciudad', $this->getTexto('cmbCiudad-Hot'));
        Session::set('sess_H_cat', $this->getTexto('cmbCategoria'));
        
        $this->redireccionar('hoteles');
    }
}
