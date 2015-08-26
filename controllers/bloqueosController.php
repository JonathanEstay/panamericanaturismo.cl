<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class bloqueosController extends Controller
{
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad = $this->loadModel('ciudad');
        
        $form=$this->_view->getForm();
        
        if(!$form){
            $form[0]='a';
            
        }
       if($form[0]!='form'){
        Session::acceso('Usuario');   
        }
        
        $this->_loadLeft();
    }
    
    
    public function index($form='')
    {
        
        $item=true;
        $this->_view->_stilo='left: 169px;';
        if($form!='form'){
            Session::acceso('Usuario');
            $item=false;
            
            
        }
        $this->_view->form=$form;
        //$this->_view->setJS(array(''));
        
        //$this->getLibrary('kint/Kint.class');
        
        $this->_view->ML_fechaIni= Session::get('sess_BP_fechaIn');
        $this->_view->ML_fechaFin= Session::get('sess_BP_fechaOut');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();
        
        
        if(Session::get('sess_BP_ciudadDes'))
        {
            $this->loadDTO('incluye');
            $bloqueos= $this->loadModel('bloqueo');
            
            if(WEB) {
                //Web
                $sql="exec TS_GET_BLOQUEOS_PROG '".Session::get('sess_BP_ciudadDes')."', "
                    . "'".Functions::invertirFecha(Session::get('sess_BP_fechaIn'), '/', '-')."', "
                    . "'".Functions::invertirFecha(Session::get('sess_BP_fechaOut'), '/', '-')."', "
                    . "'".Session::get('sess_BP_hotel')."'";
            } else {
                //Local
                $sql="exec TS_GET_BLOQUEOS_PROG '".Session::get('sess_BP_ciudadDes')."', "
                    . "'".str_replace('/', '-', Session::get('sess_BP_fechaIn'))."', "
                    . "'".str_replace('/', '-', Session::get('sess_BP_fechaOut'))."', "
                    . "'".Session::get('sess_BP_hotel')."'";
                
            }
            
            
            for($i=1; $i<=3; $i++)
            {
                $sql.= ", '".Session::get('sess_BP_Adl_'.$i)."', '".Session::get('sess_BP_edadChd_1_'.$i)."', 
                    '".Session::get('sess_BP_edadChd_2_'.$i)."', '".Session::get('sess_BP_Inf_'.$i)."'"; //habitaciones
            }
          
            
            Session::set('sess_sql_TraeProg', $sql);
            //echo $sql; exit;
            
            //$this->_view->objCiudadBloq= $this->_ciudad->getCiudadesBloq(Session::get('sess_BP_ciudadDes_PRG'));
            $this->_view->objBloqueos= $bloqueos->TS_GET_BLOQUEOS_PROG($sql, true);
            $this->_view->objBloqueosCNT = count($this->_view->objBloqueos);
        }
        
        //Session::destroy('sess_BP_ciudadDes_PRG');
        $this->_view->currentMenu=11;
        //$this->_view->procesoTerminado=false;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('bloqueos',$item);
    }
    
    
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                          METODOS VIEWS CENTER BOX                            *
    *                                                                              *
    *******************************************************************************/
    public function opciones($form='')
    {
        if($form!='form'){
            Session::acceso('Usuario');
        }
        $this->_view->form = $form;
        //echo "opciones!"; exit;
        $BO_idprog= $this->getTexto('__id__');
        //$this->_view->ML_fechaIni= Session::get('sess_BP_fechaIn');
        //$this->_view->ML_fechaFin= Session::get('sess_BP_fechaOut');
        
        
        if(Session::get('sess_BP_ciudadDes'))
        {
            $bloqueos= $this->loadModel('bloqueo');
            
            if(WEB) {
                $sql="exec TS_GET_BLOQUEOS_PROG_DETALLE " . $BO_idprog . ", "
                //Web
                . "'".Functions::invertirFecha(Session::get('sess_BP_fechaIn'), '/', '-')."', "
                . "'".Functions::invertirFecha(Session::get('sess_BP_fechaOut'), '/', '-')."', "
                . "'".Session::get('sess_BP_hotel')."'";
            } else {
                $sql="exec TS_GET_BLOQUEOS_PROG_DETALLE " . $BO_idprog . ", "
                //Local
                . "'".str_replace('/', '-', Session::get('sess_BP_fechaIn'))."', "
                . "'".str_replace('/', '-', Session::get('sess_BP_fechaOut'))."', "
                . "'".Session::get('sess_BP_hotel')."'";
            }
                    
            
            for($i=1; $i<=3; $i++)
            {
                $sql.= ", '".Session::get('sess_BP_Adl_'.$i)."', '".Session::get('sess_BP_edadChd_1_'.$i)."', 
                        '".Session::get('sess_BP_edadChd_2_'.$i)."', '".Session::get('sess_BP_Inf_'.$i)."'"; //habitaciones
            }
            
            //Session::set('sess_sql_TraeProg', $sql);
            //echo $sql; exit;
            
            $this->_view->objOpcBloqueos= $bloqueos->TS_GET_BLOQUEOS_PROG_DETALLE($sql, false);
            $this->_view->objOpcBloqueosCNT = count($this->_view->objOpcBloqueos);
        }
        
        $this->_view->renderingCenterBox('opcionesPrograma');
    }
    
    
    public function fotosHotel($form='')
    {
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $FH_codHotel= $this->getTexto('varCenterBox');
        if($FH_codHotel)
        {
            $FH_hotel= $this->loadModel('hotel');
            
            $this->_view->objFotosHotel= $FH_hotel->getFotos($FH_codHotel);
            if($this->_view->objFotosHotel)
            {
                $this->_view->renderingCenterBox('fotosHotel');
            }
            else
            {
                throw new Exception('Error al desplegar las fotos, favor intente nuevamente.');
            }
        }
        else
        {
            throw new Exception('Error al ver las fotos del hotel.');
        }
    }
    
    public function fotosTipoHab($form='') {
        
        $DTH_codTiHab= $this->getTexto('varCenterBox');
        $DTH_codHot= $this->getTexto('varCenterBoxH');
        if($DTH_codTiHab)
        {
            Session::set('sessMOD_DTH_codTipoHab', $DTH_codTiHab);
            $DTH_tHab= $this->loadModel('tipoHab');
            
            $DTH_objsTipoHab= $DTH_tHab->getTipoHab($DTH_codTiHab);
            $this->_view->DTH_nombreDTipoHab= $DTH_objsTipoHab[0]->getNombre();
            
            //echo $DTH_codTiHab .' - '.$DTH_codHot; exit;
            $this->_view->DTH_objsDetTipoHab= $DTH_tHab->getDetTipoHab($DTH_codTiHab, $DTH_codHot);
            
            /*if($DTH_objsDetTipoHab)
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
            }*/
            
            if($this->_view->DTH_objsDetTipoHab)
            {
                $this->_view->renderingCenterBox('fotosTipoH');
            }
            else
            {
                throw new Exception('No se encontraron fotos para este tipo de habitacion.');
            }
            
        }
        else
        {
            throw new Exception('Error al cargar el detalle de tipo habitaci&oacute;n');
        }
    }
    
    
    public function mapas($form='')
    {
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $M_codHotel= $this->getTexto('varCenterBox');
        if($M_codHotel)
        {
            $M_hotel= $this->loadModel('hotel');
            
            $this->_view->objMapa= $M_hotel->getMapa($M_codHotel);
            if($this->_view->objMapa)
            {
                $this->_view->renderingCenterBox('mapas');
            }
            else
            {
                throw new Exception('Error al mostrar el mapa, favor intente nuevamente.');
            }
        }
        else
        {
            throw new Exception('Error al ver el mapa.');
        }
    }
    
    
    public function notas($form='')
    {
        $this->_view->form=$form;
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $idOpc= $this->getTexto('varCenterBox');
        if($idOpc)
        {
            $N_programa= $this->loadModel('programa');
            
            $this->_view->objPrograma= $N_programa->getNotaOpc($idOpc);
            $this->_view->renderingCenterBox('notas');
        }
        else
        {
            throw new Exception('Error al ver la nota.');
        }
    }
    
    
    public function servicios($form='')
    {
        $this->_view->form=$form;
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $S_codHotel= $this->getTexto('varCenterBox');
        if($S_codHotel)
        {
            $S_hotel= $this->loadModel('hotel');
            
            $this->_view->objHotel= $S_hotel->getHotel($S_codHotel);
            if($this->_view->objHotel)
            {
                $this->_view->renderingCenterBox('servicios');
            }
            else
            {
                throw new Exception('Error al desplegar los servicios, favor intente nuevamente.');
            }
        }
        else
        {
            throw new Exception('Error al ver los servicios');
        }
    }
    
    
    public function itinerarioVuelo($form='')
    {
        $this->_view->form=$form;
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $idOpc= $this->getTexto('varCenterBox');
        if($idOpc)
        {
            $IV_bloqueo= $this->loadModel('bloqueo');
            
            $this->_view->objPrograma= $IV_bloqueo->getItinerarioVuelo($idOpc);
            $this->_view->renderingCenterBox('itinerarioVuelo');
        }
        else
        {
            throw new Exception('Error al ver el itinerario.');
        }
    }
    
    
    public function condicionesGenerales($form='')
    {
        if($form!='form'){
        Session::acceso('Usuario');
        }
        $idPrg= $this->getTexto('varCenterBox');
        if($idPrg)
        {
            $CG_programa= $this->loadModel('programa');
            
            $this->_view->objPrograma= $CG_programa->getNota($idPrg);
            $this->_view->renderingCenterBox('condicionesGenerales');
        }
        else
        {
            throw new Exception('Error al ver las condiciones generales.');
        }
    }
    
    
    public function reservaPrograma($form='')
    {
        $this->_view->form=$form;
        Session::accForm('Usuario');
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest')
        {
            $RP_rdbOpc = false;
            $RP_idProg = false;
            //$this->
            $tags= array_keys($this->getPOST());
            if(!empty($tags[1])) { 
                $RP_rdbOpc= $this->getTexto('varCenterBox');
                $RP_idProg= $this->getTexto('varCenterBoxH');
            }
            
            
            if(!$RP_rdbOpc)
            {
                throw new Exception('Seleccione una opcion para poder reservar.');
            }
            else if($RP_idProg)
            {
                Session::set('sessRP_rdbOpc', $RP_rdbOpc);
                Session::set('sessRP_idPrograma', $RP_idProg);
            
                $bloqueo= $this->loadModel('bloqueo');
                $this->_view->objPrograma= $bloqueo->validaPrograma($RP_idProg, $RP_rdbOpc);
                
                if($this->_view->objPrograma) {
                    if(WEB) {
                        //Web
                        $sql="exec TS_GET_BLOQUEOS_PROG_ID " . $RP_idProg . ", " . $RP_rdbOpc .", "
                        . "'".Functions::invertirFecha(Session::get('sess_BP_fechaIn'), '/', '-')."', "
                        . "'".Functions::invertirFecha(Session::get('sess_BP_fechaOut'), '/', '-')."', ";
                    } else {
                        //Local
                        $sql="exec TS_GET_BLOQUEOS_PROG_ID " . $RP_idProg . ", " . $RP_rdbOpc .", "
                        . "'".str_replace('/', '-', Session::get('sess_BP_fechaIn'))."', "
                        . "'".str_replace('/', '-', Session::get('sess_BP_fechaOut'))."', ";
                    }
                    
                    
                    $sql.= "'".Session::get('sess_BP_hotel')."'";
                    for($i=1; $i<=3; $i++) {
                        $sql.= ", '".Session::get('sess_BP_Adl_'.$i)."', '".Session::get('sess_BP_edadChd_1_'.$i)."', 
                                '".Session::get('sess_BP_edadChd_2_'.$i)."', '".Session::get('sess_BP_Inf_'.$i)."'"; //habitaciones
                    }
                    
                    //echo $sql; exit;
                    $this->_view->objOpcionPrograma= $bloqueo->TS_GET_BLOQUEOS_PROG_ID($sql);
                    $cnt= count($this->_view->objOpcionPrograma);
                    /*for($i=1; $i<$cnt; $i++)
                    {
                        echo $this->_view->objOpcionPrograma[$i]->getIdOpc();
                        if($this->_view->objOpcionPrograma[$i]->getIdOpc() == $RP_rdbOpc)
                        {
                            $this->_view->objOpcionProg[]= $this->_view->objOpcionPrograma[$i];
                            break;
                        }
                    }*/
                    
                    //Formateando valores
                    $this->_view->fechaSalida= Functions::invertirFecha($this->_view->objOpcionPrograma[0]->getDesde(), '/', '/');
                    
                    $exp_fechaSalida= explode('/', $this->_view->objOpcionPrograma[0]->getDesde());
                    $this->_view->anoSalida= $exp_fechaSalida[0];
                    $this->_view->mesSalida= $exp_fechaSalida[1];
                    $this->_view->diaSalida= $exp_fechaSalida[2];
                    
                    $valorHab= $this->_view->objOpcionPrograma[0]->getValorHab();
                    $this->_view->precio= Functions::formatoValor($this->_view->objOpcionPrograma[0]->getMoneda(), ($valorHab[0]+$valorHab[1]+$valorHab[2]));
                    
                    $this->_view->hoteles= $this->_view->objOpcionPrograma[0]->getHoteles();
                    $this->_view->hotelesCNT= count($this->_view->hoteles);
                    $this->_view->renderingCenterBox('reservarPrograma');
                }
                else
                {
                    throw new Exception('Existe un error en el armado de programas, favor actualize la busqueda.');
                }
            }
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }
    
    
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                             METODOS PROCESADORES                             *
    *                                                                              *
    *******************************************************************************/
    public function procesoReserva($form='')
    {
        Session::acceso('Usuario');
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') {
            
            $n_file=0; $cod_prog=''; $cod_bloq='';
            
            $programa= $this->loadModel('bloqueo');
            
            require_once ROOT . 'controllers' . DS . 'include' . DS .'procesoReserva.php';
            $param="CR_n_file=$n_file&CR_cod_prog=$cod_prog&CR_cod_bloq=$cod_bloq";
            //$param="CR_n_file=190306&CR_cod_prog=CH14FLN01-2&CR_cod_bloq=2014FLN019";
            $html= $this->curlPOST($param, BASE_URL . 'bloqueos/cartaConfirmacion');
            
            if($pRP_error) {
                echo $pRP_msg;
            } else {
                //$this->getLibrary('class.phpmailer');
                //$this->mailReserva($n_file, $html);
                echo 'OK' . '&' . $n_file . '&' . $cod_prog . '&' . $cod_bloq;
            }
            
        } else {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }

    
    public function cartaConfirmacion($form='')
    {
        $this->_view->form=$form;
        //Cargando modelos
        $M_file= $this->loadModel('reserva');
        $M_bloqueos= $this->loadModel('bloqueo');
        $M_packages= $this->loadModel('programa');
        
        //Rescatando post
        $nFile= $this->getTexto('CR_n_file');
        $codPRG= $this->getTexto('CR_cod_prog');
        $codBloq= $this->getTexto('CR_cod_bloq');
        
        if(!$nFile) {
            throw new Exception('File no recibido');
        }
        
        //Creando los objetos para las View
        $objsFile= $M_file->getFile($nFile);
        
        $this->_view->CC_objsDetFile= $M_file->getDetFile($nFile);
        
        $objsBloq= $M_bloqueos->getBloqueos($codBloq);
        
        $this->_view->CC_objsDetBloq= $M_bloqueos->getDetBloq($codBloq, $nFile);
        
        $objsPackages= $M_packages->getPackages($codPRG);
        
        
        if($objsFile!=false)
        {
            $this->_view->CC_agencia=$objsFile[0]->getAgencia();
            $this->_view->CC_vage= $objsFile[0]->getVage();
            $this->_view->CC_nomPax= $objsFile[0]->getNomPax();
            $this->_view->CC_nPax= $objsFile[0]->getNPax();
            $this->_view->CC_fviaje= $objsFile[0]->getFViaje();
            $this->_view->CC_moneda= $objsFile[0]->getMoneda();
            $this->_view->CC_totventa= $objsFile[0]->getTotVenta();
            $this->_view->CC_cambio= $objsFile[0]->getCambio();
            $this->_view->CC_comag= $objsFile[0]->getComag();
            
            $this->_view->CC_datos= $objsFile[0]->getDatos();
            $this->_view->CC_ajuste= $objsFile[0]->getAjuste();
            $this->_view->CC_tcomi= $objsFile[0]->getTComi();
        }
        
        if($objsPackages!=false)
        {
            $this->_view->CC_nombreProg=$objsPackages[0]->getNombre();
        }
        
        if($objsBloq!=false)
        {
            $this->_view->CC_notas= str_replace("\n", "<br>", $objsBloq[0]->getNotas());
        }
        else
        {
            $this->_view->CC_notas=false;
        }
        
        $this->_view->numFile= $nFile;
        $this->_view->codigoPRG= $codPRG;
        $this->_view->codigoBloq= $codBloq;
        
        
        
        $this->_view->renderingCenterBox('cartaConfirm');
    }
    
    
    public function buscar($form='')
    {
        
        
        if($form === 'a'){
         Session::acceso('Usuario');   
        }
        $BP_cntHab= $this->getInt('mL_cmbHab');
        $BP_ciudadDes= $this->getTexto('mL_txtCiudadDestino');
        $BP_fechaIn= $this->getTexto('mL_txtFechaIn');
        $BP_fechaOut= $this->getTexto('mL_txtFechaOut');
        $BP_hotel= $this->getTexto('mL_txtHotel');

        if($BP_ciudadDes)
        {
            Session::set('sess_BP_ciudadDes', $BP_ciudadDes);
        }

        Session::set('sess_BP_cntHab', $BP_cntHab);
        Session::set('sess_BP_fechaIn', $BP_fechaIn);
        Session::set('sess_BP_fechaOut', $BP_fechaOut);
        
        if($BP_hotel == 'Nombre del hotel') { $BP_hotel=''; }
        Session::set('sess_BP_hotel', $BP_hotel);


        Session::set('sess_BP_cntAdl', 0);
        Session::set('sess_BP_cntChd', 0);
        Session::set('sess_BP_cntInf', 0);
        for($i=1; $i<=3; $i++) {
            
            if($i<=$BP_cntHab) {
                
                Session::set('sess_BP_Adl_'.$i, $this->getInt('mL_cmbAdultos_'.$i));
                Session::set('sess_BP_Chd_'.$i, $this->getInt('mL_child_'.$i));
                Session::set('sess_BP_Inf_'.$i, $this->getInt('mL_inf_'.$i));


                if(Session::get('sess_BP_Adl_'.$i)>0) {
                    Session::set('sess_BP_cntAdl', (Session::get('sess_BP_cntAdl')+1));
                }
                if(Session::get('sess_BP_Chd_'.$i)>0) {
                    Session::set('sess_BP_cntChd', (Session::get('sess_BP_cntChd')+1));
                }
                if(Session::get('sess_BP_Inf_'.$i)>0) {
                    Session::set('sess_BP_cntInf', (Session::get('sess_BP_cntInf')+1));
                }


                for($x=1; $x<=2; $x++) {
                    Session::set('sess_BP_edadChd_'.$x.'_' . $i, $this->getInt('mL_edadChild_'.$x.'_'.$i));
                }
                
            } else {
                Session::set('sess_BP_Adl_'.$i, 0);
                Session::set('sess_BP_Chd_'.$i, 0);
                Session::set('sess_BP_Inf_'.$i, 0);

                Session::set('sess_BP_edadChd_1_'.$i, 0);
                Session::set('sess_BP_edadChd_2_'.$i, 0);
            }
        }

        $this->redireccionar('bloqueos/index/'.$form);
    }
    public function validadPostFe($form=''){
        
        $fecha =$this->getTexto('fecha');
        
        if(!Session::get('sess_fechaDefault')){
           Session::set('sess_fechaDefault', $fecha);
        }        
    }
}