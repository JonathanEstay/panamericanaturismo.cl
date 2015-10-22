<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class systemController extends Controller
{
    private $_pdf;
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad= $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    /*******************************************************************************
    *                                                                              *
    *                                METODOS VIEWS                                 *
    *                                                                              *
    *******************************************************************************/
    public function index()
    {
        $this->_view->form='a';
        
        Session::acceso('Usuario');
        $this->_view->setJS(array('jquery.cycle2.min', 'sliderHome'));
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();
        
        $this->_view->index=true;
        $this->_view->currentMenu=0;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('index');
    }
    
    
    
    
    
    public function verPDF($id = false)
    {
        Session::acceso('Usuario');
        
        //$this->getLibrary('fpdf');
        $this->getLibrary('pdf_html');
        
        $pdf= new PDF('P', 'mm','letter');
        $ruta_img= ROOT . 'public' . DS . 'img' . DS;
        
        require_once ROOT . 'views' . DS . 'sistema' . DS . 'pdf' . DS . 'voucherPDF.php';
        
        //$this->_pdf= new FPDF();
        //$this->_pdf->AddPage();
        //$this->_pdf->SetFont('Arial','B',16);
        //$this->_pdf->Cell(40,10, utf8_decode('¡Hola, Mundo!'));
        //$this->_pdf->Cell(40,10,'¡Hola, Mundo!');
        //$this->_pdf->Output();
    }
    

    
    
    
    public function getSalidas() {
        $objetosSalidas = $this->_ciudad->getSalidas($this->getTexto('ciudad'));
        $salidasJSON = array();
        foreach ($objetosSalidas as $objSalida) {
            array_push($salidasJSON, $objSalida->getSalida());
        }
        echo json_encode($salidasJSON);
    }
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                             METODOS PROCESADORES                             *
    *                                                                              *
    *******************************************************************************/    
    
    /**
     * Metodo Procesador: Calcula el valor total a pagar antes de reservar un programa.
     * <PRE>
     * -.Creado: 19/05/2015
     * -.Modificado: 20/05/2015 (Sergio Orellana)
     * -.Modificado: 22/10/2015 (Jonathan Estay)
     * </PRE>
     * @author: Jonathan Estay
     */
    public function salir($location = true)
    {
        $arraySess = array('Autenticado', 'sess_key_', 'sess_ip', 'sess_fechaLogin', 
                            'sess_clave_usuario','sess_nombre',
                            'sess_cod_ven','sess_dctod','sess_dctoh','sess_agencia',
                            'sess_id_agen','sess_markup','sess_fecpass','sess_depto',
                            'sess_atipoa','sess_firma','sess_rut','sess_email','sess_email_opera',
                            'level','tiempo','sess_sp_acceso', 'sess_codigo_cliente_url');
        Session::destroy($arraySess);
        
        if($location) {
            header('Location: ' . BASE_URL . 'login?ex');
            exit;
        }
    }
}
?>