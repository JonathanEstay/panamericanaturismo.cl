<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class bookingController extends Controller
{
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad = $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    public function index($form='') {
        $this->_view->form=$form;
        Session::acceso('Usuario');
        $reserva= $this->loadModel('reserva');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();
        
        $this->_view->rdbRes=false;
        $this->_view->rdbVia=false;
        
        if(Session::get('sess_CR_fechaDesde') && Session::get('sess_CR_fechaHasta'))
        {
            $this->_view->CR_fechaIni= Session::get('sess_CR_fechaDesde');
            $this->_view->CR_fechaFin= Session::get('sess_CR_fechaHasta');
            
            if(Session::get("sess_CR_tipoFecha")==1)
            {
                $this->_view->rdbRes='checked';
            }
            else
            {
                $this->_view->rdbVia='checked';
            }
            
            
            if (WEB) {
                $this->_view->objReservas= $reserva->getReservas(
                    Functions::invertirFecha(Session::get('sess_CR_fechaDesde'), '/', '-'),
                    Functions::invertirFecha(Session::get('sess_CR_fechaHasta'), '/', '-'),
                    Session::get('sess_CR_tipoFecha'),
                    Session::get('sess_sp_acceso'),
                    Session::get('sess_clave_usuario')
                    );
            } else {
                //Local
                $this->_view->objReservas= $reserva->getReservas(
                str_replace('/', '-', Session::get('sess_CR_fechaDesde')),
                str_replace('/', '-', Session::get('sess_CR_fechaHasta')),
                Session::get('sess_CR_tipoFecha'),
                Session::get('sess_sp_acceso'),
                Session::get('sess_clave_usuario')
                );
            }
        }
        else
        {
            $this->_view->objReservas=false;
            $this->_view->CR_fechaIni= Session::get('sess_fechaDefault');
            $this->_view->CR_fechaFin= Functions::sumFecha(Session::get('sess_fechaDefault'), 0, 3);

            if(Session::get('sess_CR_tipoFecha')==1)
            {
                $this->_view->rdbRes='checked';
            }
            else
            {
                $this->_view->rdbVia='checked';
            }
        }
        
        
        $this->_view->currentMenu=1;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('consultarReserva');
    }
    
    
    
    public function voucher($numFile=false)
    {
        if(!$numFile) {
            $this->redireccionar('booking');
        }
        
        //Session::acceso('Usuario');
        $numFile = base64_decode($numFile);
        $numFile = $numFile*1;
        
        
        $ruta_img= 'views/layout/' . DEFAULT_LAYOUT . '/img/';
        
        ob_start();
        require_once ROOT . 'views' . DS . 'system' . DS .'pdf' . DS . 'vouchea.php';
        $content = ob_get_clean();
        
        
        $this->getLibrary('html2pdf.class');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
                    //$html2pdf->setModeDebug();
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Voucher_N_'.$numFile.'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    
    public function ver() {
        $numFile= $this->getTexto('numFile');
        if($numFile==''){
            $this->redireccionar('booking');
        }
        $this->_view->numfile=$numFile;
        $this->_view->renderingCenterBox('voucher');
    }
    
    
    public function cartaConfirmacion($form ='')
    {
        $this->_view->form=$form;
        Session::acceso('Usuario');
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
        
        
        if($objsFile) {
            $this->_view->CC_agencia=$objsFile[0]->getAgencia();
            $this->_view->CC_vage= $objsFile[0]->getVage();
            $this->_view->CC_nomPax= $objsFile[0]->getNomPax();
            $this->_view->CC_nPax= $objsFile[0]->getNPax();
            $this->_view->CC_fviaje= $objsFile[0]->getFViaje();
            $this->_view->CC_moneda= $objsFile[0]->getMoneda();
            $this->_view->CC_totventa= $objsFile[0]->getTotVenta();
            $this->_view->CC_cambio= $objsFile[0]->getCambio();
            $this->_view->CC_comag= $objsFile[0]->getComag();
            $this->_view->CC_fecha= $objsFile[0]->getFecha();
            
            $this->_view->CC_datos= $objsFile[0]->getDatos();
            $this->_view->CC_ajuste= $objsFile[0]->getAjuste();
            $this->_view->CC_tcomi= $objsFile[0]->getTComi();
        }
        
        if($objsPackages) {
            $this->_view->CC_nombreProg=$objsPackages[0]->getNombre();
        }
        
        if($objsBloq) {
            $this->_view->CC_notas= str_replace("\n", "<br>", $objsBloq[0]->getNotas());
        } else {
            $this->_view->CC_notas=false;
        }
        
        $this->_view->numFile= $nFile;
        $this->_view->codigoPRG= $codPRG;
        $this->_view->codigoBloq= $codBloq;
        

        $this->_view->condicionesGenerales= file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . Session::get('sess_condiciones') . '.phtml');
        $this->_view->renderingCartas(Session::get('sess_condiciones'));
    }
    
    
    public function buscar()
    {
        Session::acceso('Usuario');
        
        Session::set('sess_CR_fechaDesde', $this->getTexto('txtFechaDesde-ConsRes'));
        Session::set('sess_CR_fechaHasta', $this->getTexto('txtFechaHasta-ConsRes'));
        Session::set('sess_CR_tipoFecha', $this->getInt('rdbFecha'));
        
        $this->redireccionar('booking');
    }
   
}