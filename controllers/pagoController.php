<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class pagoController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->_json = $this->loadModel('json');
        $this->_ciudad = $this->loadModel('ciudad');
        $this->_loadLeft();
    }

    public function index() {
        $this->redireccionar('system');
    }

    public function cierre($external_id) {
        if (Session::get('sess_boton_pago')) {
            if(Session::get("sess_file") == $external_id) {
                
                
                sleep(2); //Esperando acuse pago de travel
                if ($this->confirmarPago($external_id)) { //LOCAL
                    $this->redireccionar('pago/exito');
                } else {
                    if ($this->reconfirmarPago()) { //TRAVEL
                        $this->redireccionar('pago/exito');
                    } else {
                        Session::set('sess_status_pago', false);
                        Session::set('sess_msj_pago', Session::get('sess_msj_pago') . '[2026] Error al intentar realizar el pago');
                        $this->redireccionar('pago/fracaso');
                    }
                }
                
                
            } else {
                $this->redireccionar('pago/fracaso');
            }
        } else {
            $this->redireccionar('pago/fracaso');
        }
    }
    
    public function confirmarPago($ext_id) {
        if (Session::get('sess_boton_pago')) {
            if(Session::get("sess_file") == $ext_id) {
                
                $jsonPay = json_decode(file_get_contents(ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . $ext_id . '.json'));

                $objPago = $this->_json->payConfirm($jsonPay->pay_file, $jsonPay->pay_hash);
                if($objPago) {
                    foreach($objPago as $objPay) {
                        if($objPay->getStatus() == 'success'){
                            return true;
                        } else {
                            Session::set('sess_status_pago', false);
                            Session::set('sess_msj_pago', '[2024] Error al intentar realizar el pago @' . $objPay->getStatus() . '@');
                            return false;
                        }
                    }
                } else {
                    Session::set('sess_status_pago', false);
                    Session::set('sess_msj_pago', '[2025] Error al intentar realizar el pago');
                    return false;
                }
                
                
            } else {
                $this->redireccionar('pago/fracaso');
            }
        } else {
            $this->redireccionar('pago/fracaso');
        }
    }
    
    public function reconfirmarPago() {

        $jsonPay = json_decode(file_get_contents(ROOT . 'public' . DS . 'paylog' . DS . $this->getServer('REMOTE_ADDR') . '_' . Session::get("sess_file") . '.json'));
        $url = $jsonPay->pay_url_api . 'api/checkout/orderStatus?external_id=' . $jsonPay->pay_file . '&agency_id=' . $jsonPay->pay_agency_id;
        
        $this->_json->logJSON($jsonPay->pay_file, $url, 'Q'); //LOG RQ
        $json = $this->curlGET_JSON($url, $jsonPay->pay_user, $jsonPay->pay_pass);
        $this->_json->logJSON($jsonPay->pay_file, json_encode($json), 'S'); //LOG RS
        
        if (is_object($json)) {
            if ($jsonPay->pay_hash == $json->hash && $jsonPay->pay_file == $json->external_id && $jsonPay->pay_agency_id == $json->agency_id) {
                if ($json->status == 'success') {
                    return true;
                } else {
                    Session::set('sess_status_pago', false);
                    Session::set('sess_msj_pago', '[2021] Error al intentar realizar el pago (' . str_replace('ó', '&oacute;', $json->error_message) . ')');
                    return false;
                }
            } else {
                Session::set('sess_status_pago', false);
                Session::set('sess_msj_pago', '[2022] Error al intentar realizar el pago');
                return false;
            }
        } else {
            Session::set('sess_status_pago', false);
            Session::set('sess_msj_pago', '[2023] Error al intentar realizar el pago');
            return false;
        }
    }

    public function fracaso() {
        $this->_view->ML_fechaIni = Session::get('sess_BP_fechaIn');
        $this->_view->ML_fechaFin = Session::get('sess_BP_fechaOut');
        $this->_view->objCiudades = $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG = $this->_ciudad->getCiudadesPRG();
        $this->_view->currentMenu = 11;
        $this->_view->titulo = 'ORISTRAVEL';
        
        $this->_view->status = Session::get('sess_status_pago');
        $this->_view->msj = Session::get('sess_msj_pago');
        $this->_view->renderingSystem('fracaso', true);
        Session::destroy('sess_status_pago');
        Session::destroy('sess_msj_pago');
    }

    public function exito() {
        $this->_view->ML_fechaIni = Session::get('sess_BP_fechaIn');
        $this->_view->ML_fechaFin = Session::get('sess_BP_fechaOut');
        $this->_view->objCiudades = $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG = $this->_ciudad->getCiudadesPRG();
        $this->_view->currentMenu = 11;
        $this->_view->titulo = 'ORISTRAVEL';
        
        //Rescatando post
        $nFile = '203598'; //$this->getTexto('CR_n_file');
        $codPRG = 'CH15FLN02B2'; //$this->getTexto('CR_cod_prog');
        $codBloq = "2015FLN038"; //$this->getTexto('CR_cod_bloq');
        $correoSend='ohurtado@tsyacom.cl';
        $user ='tclub';

        $M_file = $this->loadModel('reserva');
        $M_bloqueos = $this->loadModel('bloqueo');
        $M_packages = $this->loadModel('programa');

        if (!$nFile) {
            throw new Exception('File no recibido');
        }
        //Creando los objetos para las View
        $objsFile = $M_file->getFile($nFile);

        $this->_view->CC_objsDetFile = $M_file->getDetFile($nFile);
        //$recordC = $M_bloqueos->getRecodC($codPRG, $codBloq);

        $objsBloq = $M_bloqueos->getBloqueos($codBloq);

        $this->_view->CC_objsDetBloq = $M_bloqueos->getDetBloq($codBloq, $nFile);
        
        
        $objsPackages = $M_packages->getPackages($codPRG);


        if ($objsFile) {
            $this->_view->CC_agencia = $objsFile[0]->getAgencia();
            $this->_view->CC_vage = $objsFile[0]->getVage();
            $this->_view->CC_nomPax = $objsFile[0]->getNomPax();
            $this->_view->CC_nPax = $objsFile[0]->getNPax();
            $this->_view->CC_fviaje = $objsFile[0]->getFViaje();
            $this->_view->CC_moneda = $objsFile[0]->getMoneda();
            $this->_view->CC_totventa = $objsFile[0]->getTotVenta();
            $this->_view->CC_cambio = $objsFile[0]->getCambio();
            $this->_view->CC_comag = $objsFile[0]->getComag();
            $this->_view->CC_fecha = $objsFile[0]->getFecha();

            $this->_view->CC_datos = $objsFile[0]->getDatos();
            $this->_view->CC_ajuste = $objsFile[0]->getAjuste();
            $this->_view->CC_tcomi = $objsFile[0]->getTComi();
        }

        if ($objsPackages) {
            $this->_view->CC_nombreProg = $objsPackages[0]->getNombre();
        }

        if ($objsBloq) {
            $this->_view->CC_notas = str_replace("\n", "<br>", $objsBloq[0]->getNotas());
        } else {
            $this->_view->CC_notas = false;
        }

        $this->_view->numFile = $nFile;
        $this->_view->codigoPRG = $codPRG;
        $this->_view->codigoBloq = $codBloq;
        Session::set('sess_condiciones', 'travelclub');

        $this->_view->condicionesGenerales = file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . Session::get('sess_condiciones') . '.phtml');

        $this->loadDTO('usuarioH2h');
        //ob_start();
        //$this->_view->renderingSystem('exito');
        //$contenido = ob_get_contents();
        //$mC_HTML = file_gethis->_view->renderingSystem('exito');t_contents($this->_view->renderingCenterBox('travelclub'));
        
        
        ob_start();
        $this->_view->renderingCartas('travelclub');
        $contenido = ob_get_contents();
        ob_clean();
        
        
        
        $mailSend = $M_file->getCorreo($user);
        
        $this->getLibrary('class.phpmailer');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = trim("190.196.23.232");
        $mail->Port = 25;
        $mail->From = 'panamericana@online.panamericanaturismo.cl';
        $mail->FromName = 'TravelClub Reserva Online';
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Confirmacion de reserva online: ';
        $mail->MsgHTML($contenido);

        //$mail->AltBody = 'Su servidor de correo no soporta html';
        
        $mail->AddAddress($correoSend ,"");
        $mail->AddBCC($mailSend->getCorreoEjecutivo());
        $mail->AddBCC($mailSend->getCorreoVendedor());
        //$mail->AddAddress("destino2@correo.com","Nombre 02"); 
        

        //$mail->AddBCC($MC_correoOculto);

        $mail->SMTPAuth = true;
        $mail->Username = trim("online@panamericanaturismo.cl");
        $mail->Password = trim("Fe90934");
        $mail->Send();
        
        $this->_view->cartaConfirm = $contenido;
        $this->_view->renderingSystem('exito', true);     
        Session::destroy('sess_status_pago');
        Session::destroy('sess_msj_pago');
    }

}
