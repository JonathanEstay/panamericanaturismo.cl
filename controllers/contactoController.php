<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class contactoController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->_ciudad = $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    public function index()
    {
        Session::acceso('Usuario');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG= $this->_ciudad->getCiudadesPRG();

        $this->_view->currentMenu=5;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('contactenos');
    }
    
    public function enviar() {
        Session::acceso('Usuario');
        
        //Cargando libs
        $this->getLibrary('class.phpmailer');
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        
        //$mail->Port = 25;
        $mail->Host = "mail.oristravel.com";
        $mail->Username = "oris@oristravel.com";
        $mail->Password = "tsyacom01";
        
        $mail->From = 'oris@oristravel.com';
        $mail->FromName = 'Solicitud de Contacto WEB-ORIS';
        $mail->CharSet = CHARSET;
        $mail->Subject = 'Confirmacion de reserva online: ';
        	
        $body  = "<html><body>Un mensaje HTML</body></html>";
        $mail->MsgHTML($body);

        
        $mail->AddAddress('jestay@tsyacom.cl', "");
        //$mail->AddAddress('jjreyes.romero88@gmail.com', "");
        if (!$mail->Send()) {
            echo "Error al enviar: " . $mail->ErrorInfo;
        } else {
            echo "Mensaje enviado!";
        }
    }
}