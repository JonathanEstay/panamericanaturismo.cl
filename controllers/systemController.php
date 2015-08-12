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
     * </PRE>
     * @author: Jonathan Estay
     */
    public function salir()
    {
        Session::destroy();
        header('Location: ' . BASE_URL . 'login?ex');
        exit;
    }
}
?>