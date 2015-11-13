<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class programasController extends Controller {

    private $_ciudad;

    public function __construct() {
        parent::__construct();
        $this->_ciudad = $this->loadModel('ciudad');
        Buscador::validaForm();
        $this->_loadLeft();
    }

    /*     * *****************************************************************************
     *                                                                              *
     *                                METODOS VIEWS                                 *
     *                                                                              *
     * ***************************************************************************** */

    public function index($form = '') {

        $item = Buscador::validar($form);
        $this->_view->form = $form;
        $this->_view->url = Buscador::getUrl();
        $this->_view->setJS(array('validaCampos', 'programas'));
        //$this->getLibrary('kint/Kint.class');

        $this->_view->ML_fechaIni_PRG = Session::get('sess_BP_fechaIn_PRG');
        $this->_view->ML_fechaFin_PRG = Session::get('sess_BP_fechaOut_PRG');

        $this->_view->objCiudades = $this->_ciudad->getCiudadesBloq();
        $this->_view->objCiudadesPRG = $this->_ciudad->getCiudadesPRG();
        $this->_view->pago = true;// cambiar a false

        /*if (Session::get('sess_boton_pago')) {
            $this->_view->pago = true;
        }*/
        if (Session::get('sess_BP_ciudadDes_PRG')) {

            //$this->loadDTO('incluye');
            $programas = $this->loadModel('programa');

            if (WEB) {
                //WEB
                $sql = "EXEC TS_GET_PROGRAMAS '" . Session::get('sess_BP_ciudadDes_PRG') . "', '', '" . Functions::invertirFecha(Session::get('sess_BP_fechaIn_PRG'), '/', '-') . "' ";
            } else {
                //Local
                $sql = "EXEC TS_GET_PROGRAMAS '" . Session::get('sess_BP_ciudadDes_PRG') . "', '', '" . str_replace('/', '-', Session::get('sess_BP_fechaIn_PRG')) . "' ";
            }
            Session::set('sess_TS_GET_PROGRAMAS', $sql);
            //echo $sql; exit;
            //Kint::dump( $programas->exeTS_GET_PROGRAMAS($sql) );
            $this->_view->objCiudadBs = $this->_ciudad->getCiudad(Session::get('sess_BP_ciudadDes_PRG'));
            $this->_view->objProgramas = $programas->exeTS_GET_PROGRAMAS($sql);
            //$this->_view->objProgramasCNT = count($this->_view->objProgramas);
        }

        $us = $this->loadModel('usuario');
        $tcambio = $us->getPaisTcProg(Session::get('sess_BP_ciudadDes_PRG'));
        $TcambioSess =$us->getTcambio($tcambio);
        Session::set('sess_tcambio', $TcambioSess->getTipoCambio());

        //Session::destroy('sess_BP_ciudadDes');
        $this->_view->currentMenu = 22;
        $this->_view->procesoTerminado = false;
        $this->_view->titulo = 'ORISTRAVEL';
        $this->_view->renderingSystem('programas', $item);
    }

    public function admin($form = '') {

        $this->_view->form = $form;
        Session::acceso('Usuario');
        $this->_view->objCiudades = $this->_ciudad->getAdminCiudades(); //getCiudadesBloq()
        $this->_view->objCiudadesPRG = $this->_ciudad->getCiudadesPRG();
        $this->_view->setJS(array('programas'));

        if (Session::get('sess_AP_ciudad')) {
            $programas = $this->loadModel('programa');
            //getAdmProgramas
            $this->_view->objProgramas = $programas->getAdmProgramas(Session::get('sess_AP_ciudad'));
        }


        $this->_view->currentMenu = 3;
        $this->_view->titulo = 'ORISTRAVEL';
        $this->_view->renderingSystem('adminProgramas');
    }

    /*     * *****************************************************************************
     *                                                                              *
     *                          METODOS VIEWS CENTER BOX                            *
     *                                                                              *
     * ***************************************************************************** */

    public function itinerario($form = '') {
        $this->_view->form = $form;
        Session::acceso('Usuario');

        if ($this->getTexto('varCenterBox')) {
            $itinerario = str_replace(" ", "_", $this->getTexto('varCenterBox'));
            $this->_view->codPDF = $itinerario;

            $this->_view->renderingCenterBox('verPdf');
        } else {
            throw new Exception("Error al desplegar el Itinerario");
        }
    }

    public function detalle($form = '') {


        $this->_view->form = $form;
        Buscador::validar($form);

        $programas = $this->loadModel('programa');

        if ($this->getInt('__SP_id__')) {
            $sql = "EXEC TS_GET_PROGRAMAS_ID " . $this->getInt('__SP_id__');
            Session::set('sess_TS_GET_PROGRAMAS_ID', $sql);
            //echo $sql; exit;
            $this->_view->objProgramas = $programas->exeTS_GET_PROGRAMAS($sql);


            if (WEB) {
                //WEB
                $sql = "EXEC TS_GET_DETALLEPROG " . $this->getInt('__SP_id__') . ", '', '" . Functions::invertirFecha(Session::get('sess_BP_fechaIn_PRG'), '/', '-') . "' ";
            } else {
                //Local
                $sql = "EXEC TS_GET_DETALLEPROG " . $this->getInt('__SP_id__') . ", '', '" . Session::get('sess_BP_fechaIn_PRG') . "' ";
            }




            Session::set('sess_TS_GET_DETALLEPROG', $sql);

            //echo $sql; exit;
            $objOpcProgramas = $programas->exeTS_GET_DETALLEPROG($sql);
            if ($objOpcProgramas) {
                if ($objOpcProgramas[0]->getError()) {

                    throw new Exception('<b>Error</b>: [' . $objOpcProgramas[0]->getError() . '] <br> <b>Mensaje</b>: [' . $objOpcProgramas[0]->getMensaje() . ']');
                } else {

                    $rutaPDF = ROOT . 'public' . DS . 'pdf' . DS . 'upl_' . str_replace(' ', '_', $this->_view->objProgramas[0]->getCodigo()) . '.pdf';
                    $this->_view->_PDF = false;
                    if (is_readable($rutaPDF)) {
                        $this->_view->_PDF = true;
                    }

                    $this->_view->objOpcProgramas = $objOpcProgramas;
                    $this->_view->pago = true;//cambiar condicion false
                    /*if (Session::get('sess_boton_pago')) {
                        $this->_view->pago = true;
                    }*/
                    //$this->_view->hoteles= $this->_view->objOpcProgramas[0]->getNombreHotel();
                    $this->_view->renderingCenterBox('detalleProg');
                }
            } else {
                throw new Exception('Error al cargar las opciones');
            }
        } else {
            throw new Exception('Error al cargar las opciones');
        }
    }

    public function pasajeros($form = '') {

        $this->_view->form = $form;



        Session::accForm('Usuario');

        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest') {

            if ($this->getInt('_PP_')) {
                $this->_view->cntP = $this->getInt('_PP_');
                Session::set('sess_SGL', $this->getInt('_SGL_'));
                Session::set('sess_DBL', $this->getInt('_DBL_'));
                Session::set('sess_TPL', $this->getInt('_TPL_'));
                Session::set('sess_moneda', $this->getTexto('_MON_'));
                Session::set('sess_claveOpc', $this->getTexto('_OPC_'));
                Session::set('sess_CHD1', $this->getInt('_CHD1_'));
                Session::set('sess_CHD2', $this->getInt('_CHD2_'));
                Session::set('sess_PF', $this->getInt('_PF_'));
                $programas = $this->loadModel('programa');
                $edad = $programas->getChild($this->getTexto('_OPC_'));
                if($edad){
                    Session::set('sessRP_edadChd1', $edad->getChedad1());
                    Session::set('sessRP_edadChd2', $edad->getChedad2());
                } else {
                    ession::set('sessRP_edadChd1', 0);
                    Session::set('sessRP_edadChd2', 0);
                }
                $this->_view->hab = $this->getJson('_HAB_');
                $this->_view->hot = $this->getJson('_HOT_');
                $this->_view->plan = $this->getJson('_PLAN_');
                $this->_view->cant = $this->getJson('_CANT_');
                $this->_view->chd1 = $this->getInt('_CHD1_');
                $this->_view->chd2 = $this->getInt('_CHD2_');
                $this->_view->pf = $this->getInt('_PF_');
                $estado = $this->getTexto('_EST_');

                if ($estado === 'AVAILABLE') {
                    $this->_view->renderingCenterBox('pasajeros');
                } else {
                    $this->_view->renderingCenterBox('cotizacion');
                }
            } else {
                throw new Exception('Error al cargar las opciones');
            }
        } else {
            throw new Exception('Error al cargar los pasajeros');
        }
    }

    public function enviarMail($form = '') {


        $this->_view->nom = $this->getTexto('nombreCot');
        $this->_view->tele = $this->getTexto('telefonoCot');
        $correoCot = $this->getTexto('correoCot');
        $this->_view->correo = $correoCot;
        $this->_view->hot = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("hot"))))));
        $this->_view->hab = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("hab"))))));
        $this->_view->plan = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("plan"))))));
        $this->_view->cant = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("cant"))))));
        $cant = $this->getInt('DP_cmbHab');
        $this->_view->cantHab = $cant;

        for ($i = 1; $i <= $cant; $i++) {

            Session::set('adult_' . $i, $this->getInt('DP_cmbAdultos_' . $i));
            Session::set('child_' . $i, $this->getInt('DP_cmbChild_' . $i));
            Session::set('EdadChild_1_' . $i, $this->getInt('DP_EdadChild_1_' . $i));
            Session::set('EdadChild_2_' . $i, $this->getInt('DP_EdadChild_2_' . $i));
        }
        $this->_view->nota = $this->getTexto('rP_txtComentario');


        ob_start();
        $this->_view->renderingCenterBox('mailCotizacion');
        $contenido = ob_get_contents();
        ob_clean();

        $this->loadDTO('usuarioH2h');
        $GetCorreo = $this->loadModel('programa');

        $this->getLibrary('class.phpmailer');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = MAIL_HOST;
        $mail->Port = 25;
        $mail->From = MAIL_USER;
        $mail->FromName = Session::get('sess_condiciones') . ' ' . 'Cotización:';
        $mail->CharSet = CHARSET;
        $mail->Subject = 'Solicitud de Cotización: ';
        $mail->MsgHTML($contenido);

        //$mail->AltBody = 'Su servidor de correo no soporta html';

        if (Session::get('Autenticado')) {

            $correos = $GetCorreo->getCorreo(Session::get('sess_clave_usuario'), 2);
        } else {
            if (Session::get('sess_boton_pago')) {
                $correos = $GetCorreo->getCorreo('tclub', 1);
            } else {
                $correos = $GetCorreo->getCorreo('pan', 1);
            }
        }

        $mail->AddAddress($correos->getCorreoEjecutivo(), "");
        $mail->AddBCC($correos->getCorreoVendedor());
        if (!Session::get('Autenticado')) {
            $mail->AddBCC($correoCot);
        }



        $mail->SMTPAuth = MAIL_AUT;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->Send();

        $this->_view->renderingCenterBox('exito');
    }

    public function detallePasajeros($form = '') {

        $this->_view->form = $form;

        Session::acceso('Usuario');

        $this->_view->pago = true;//cambiar a false

        /*if (Session::get('sess_boton_pago')) {
            $this->_view->pago = true;
        }*/
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest') {
            $totalPago = 0;
            if ($this->getInt('DP_cmbHab')) {
                for ($i = 1; $i <= $this->getInt('DP_cmbHab'); $i++) {
                    Session::set('sess_DP_cmbAdultos_' . $i, $this->getInt('DP_cmbAdultos_' . $i));
                    Session::set('sess_DP_cmbChild_' . $i, $this->getInt('DP_cmbChild_' . $i));
                }

                Session::set('sess_distribucionPax', $this->_distribucionPax($this->getInt('DP_cmbHab')));

                $totalPago = $this->_valorTotal($this->getInt('DP_cmbHab'));
                Session::set('sess_DP_cntHab', $this->getInt('DP_cmbHab'));

                if (Session::get('sess_boton_pago')) {//quitar ! 
                    $this->_view->boton = "Pagar";
                } else {
                    $this->_view->boton = "Reservar";
                }

                $this->_view->totalPago = $totalPago;
                $this->_view->cntHab = $this->getInt('DP_cmbHab');
                $this->_view->condicionesGenerales = Functions::getCondicionesGenerales();
                $this->_view->hot = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("hot"))))));
                $this->_view->hab = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("hab"))))));
                $this->_view->plan = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("plan"))))));
                $this->_view->cant = explode(',', str_replace(']', '', str_replace('[', '', str_replace('"', '', str_replace('\\', '', $this->getJson("cant"))))));
                $this->_view->renderingCenterBox('detallePasajeros');
            } else {
                throw new Exception('Debe ingresar la cantidad de habitaciones');
            }
        } else {
            throw new Exception('Error al cargar los pasajeros');
        }
    }

    public function programasCondiciones($form = '') {

        $this->_view->form = $form;
        $this->_view->renderingCenterBox('condicionesProg');
    }
    public function test(){
        
        $programa = $this->loadModel('programa');
        $this->loadDTO('hotelMail');
        $hotel = $programa->getDetFile(204269);
        $correo = ENT_EMAIL;
        $fono = ENT_FONO;
        $nombre = ENT_NAME;
        $ciudad ='Santiago';
        $solicitud = 'SOLICITUD DE RESERVA';
        $estado = 'ALLOTMENT';
        $logo =BASE_URL.'/views/layout/default/img/logo.jpg';
        
        include ROOT . 'controllers' . DS .'include'.DS.'parseMailHotel.php';
        
        foreach ($arrayHtml as $HTML) {
         $this->mailHoteles(204269,$HTML,'ohurtado@tsyacom.cl');   
        }
   
    }

    /**
     * Metodo CenterBox: Proceso de reserva de un programa.
     * <PRE>
     * -.Creado: 20/05/2015
     * </PRE>
     * @return String OK
     * @author Jonathan Estay
     */
    public function procesoReserva($form = '') {


        Session::acceso('Usuario');
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest') {
            $programas = $this->loadModel('programa');
            $this->loadDTO('usuarioH2h');
            if (Session::get('sess_boton_pago')) {// quitar !
                $pasajeros = $this->_validaPasajeros();
                if ($pasajeros) {

                    $habitacion = explode(';', Session::get('sess_distribucionPax'));
                    $hab2 = (isset($habitacion[1])) ? $habitacion[1] : '';
                    $hab3 = (isset($habitacion[2])) ? $habitacion[2] : '';
                    $objOpcPrograma = $programas->exeTS_GET_DETALLEPROG(Session::get('sess_TS_GET_DETALLEPROG'));

                    foreach ($objOpcPrograma as $objOpcProg) {

                        if (WEB) {
                            //WEB
                            $sql = 'exec TS_RESERVAR_PRG '
                                    . '"' . Session::get('sess_clave_usuario') . '", '
                                    . '"' . Session::get('sess_codigoPrograma') . '", '
                                    . '"' . $objOpcProg->getClaveOpc() . '", '
                                    . '"", '
                                    . '"' . Functions::invertirFecha(Session::get('sess_BP_fechaIn_PRG'), '/', '-') . '", '
                                    . '"' . $habitacion[0] . '", '
                                    . '"' . $hab2 . '", '
                                    . '"' . $hab3 . '", '
                                    . '"datos", '
                                    . '"", '
                                    . '"", '
                                    . '"", '
                                    . '"", '
                                    . '"' . Session::get('sess_rut') . '", ' //@rut_cliente
                                    . 'NULL, '
                                    . 'NULL, '
                                    . 'NULL, '
                                    . '"TI", ' //@tipof
                                    . '"A", ' //@estado
                                    . '0, ' //@tcomi
                                    //. '"' . date('d-m-Y') . '", ' //@F_contab
                                    . '"' . date('Y-m-d') . '", ' //@F_contab
                                    . '"' . $this->getTexto('DP_txtNombre_1_1') . ' ' . $this->getTexto('DP_txtApellido_1_1') . '"'; //@vage    
                            $sql .= $pasajeros;
                        } else {
                            //Local
                            $sql = 'exec TS_RESERVAR_PRG '
                                    . '"' . Session::get('sess_clave_usuario') . '", '
                                    . '"' . Session::get('sess_codigoPrograma') . '", '
                                    . '"' . $objOpcProg->getClaveOpc() . '", '
                                    . '"", '
                                    . '"' . Session::get('sess_BP_fechaIn_PRG') . '", '
                                    . '"' . $habitacion[0] . '", '
                                    . '"' . $hab2 . '", '
                                    . '"' . $hab3 . '", '
                                    . '"datos", '
                                    . '"", '
                                    . '"", '
                                    . '"", '
                                    . '"", '
                                    . '"' . Session::get('sess_rut') . '", ' //@rut_cliente
                                    . 'NULL, '
                                    . 'NULL, '
                                    . 'NULL, '
                                    . '"TI", ' //@tipof
                                    . '"A", ' //@estado
                                    . '0, ' //@tcomi
                                    . '"' . date('d-m-Y') . '", ' //@F_contab
                                    . '"' . $this->getTexto('DP_txtNombre_1_1') . ' ' . $this->getTexto('DP_txtApellido_1_1') . '"'; //@vage    
                            $sql .= $pasajeros;
                        }
                    }
                    //echo $sql;
                    //exit;
                    $objResPrograma = $programas->exeTS_RESERVAR($sql);
                   

                    foreach ($objResPrograma as $objRes) {
                        if (!$objRes->getFile()) {
                            throw new Exception('<b>Codigo:</b> [ ' . $objRes->getError() . ' ],<br>'
                            . '<b>Mensaje:</b> ' . $objRes->getMensaje());
                        } else {
                            Session::set('sess_numeroFile', $objRes->getFile());
                            $param = 'correo=1' . '&file=' . $objRes->getFile() . '&programa=' . Session::get('sess_codigoPrograma') . '&__sucessful__=ok';


                            $html = $this->curlPOST($param, BASE_URL . 'programas/cartaConfirmacion/form');



                            $this->getLibrary('class.phpmailer');
                            $this->mailReserva($objRes->getFile(), $html);
                            echo 'OK&' . md5(':D');
                        }
                    }
                }
            } else {
                $pasajeros = $this->_validaPasajeros();
                if ($pasajeros) {

                    $habitacion = explode(';', Session::get('sess_distribucionPax'));
                    
                    $hab2 = (isset($habitacion[1])) ? $habitacion[1] : '';
                    $hab3 = (isset($habitacion[2])) ? $habitacion[2] : '';
                    
                    $objOpcPrograma = $programas->exeTS_GET_DETALLEPROG(Session::get('sess_TS_GET_DETALLEPROG'));
                    foreach ($objOpcPrograma as $objOpcProg) {

                        if (Session::get('sess_claveOpc') == $objOpcProg->getClaveOpc()) {

                            if (WEB) {
                                //WEB
                                $sql = 'exec TS_RESERVAR_PRG '
                                        . '"' . Session::get('sess_clave_usuario') . '", '
                                        . '"' . Session::get('sess_codigoPrograma') . '", '
                                        . '"' . $objOpcProg->getClaveOpc() . '", '
                                        . '"", '
                                        . '"' . Functions::invertirFecha(Session::get('sess_BP_fechaIn_PRG'), '/', '-') . '", '
                                        . '"' . $habitacion[0] . '", '
                                        . '"' . $hab2 . '", '
                                        . '"' . $hab3 . '", '
                                        . '"datos", '
                                        . '"", '
                                        . '"", '
                                        . '"", '
                                        . '"", '
                                        . '"' . Session::get('sess_rut') . '", ' //@rut_cliente
                                        . 'NULL, '
                                        . 'NULL, '
                                        . 'NULL, '
                                        . '"TI", ' //@tipof
                                        . '"A", ' //@estado
                                        . '0, ' //@tcomi
                                        //. '"' . date('d-m-Y') . '", ' //@F_contab
                                        . '"' . date('Y-m-d') . '", ' //@F_contab
                                        . '"' . $this->getTexto('DP_txtNombre_1_1') . ' ' . $this->getTexto('DP_txtApellido_1_1') . '"'; //@vage    
                                $sql .= $pasajeros;
                            } else {
                                //Local
                                $sql = 'exec TS_RESERVAR_PRG '
                                        . '"' . Session::get('sess_clave_usuario') . '", '
                                        . '"' . Session::get('sess_codigoPrograma') . '", '
                                        . '"' . $objOpcProg->getClaveOpc() . '", '
                                        . '"", '
                                        . '"' . Session::get('sess_BP_fechaIn_PRG') . '", '
                                        . '"' . $habitacion[0] . '", '
                                        . '"' . $hab2 . '", '
                                        . '"' . $hab3 . '", '
                                        . '"datos", '
                                        . '"", '
                                        . '"", '
                                        . '"", '
                                        . '"", '
                                        . '"' . Session::get('sess_rut') . '", ' //@rut_cliente
                                        . 'NULL, '
                                        . 'NULL, '
                                        . 'NULL, '
                                        . '"TI", ' //@tipof
                                        . '"A", ' //@estado
                                        . '0, ' //@tcomi
                                        . '"' . date('d-m-Y') . '", ' //@F_contab
                                        . '"' . $this->getTexto('DP_txtNombre_1_1') . ' ' . $this->getTexto('DP_txtApellido_1_1') . '"'; //@vage    
                                $sql .= $pasajeros;
                            }
                        }
                    }
                    
                    //echo $sql;
                    //exit;
                    //echo 'OK&' .  md5(':D'); exit;
                    $objResPrograma = $programas->exeTS_RESERVAR($sql);
                    
                    foreach ($objResPrograma as $objRes) {
                        if (!$objRes->getFile()) {
                            throw new Exception('<b>Codigo:</b> [ ' . $objRes->getError() . ' ],<br>'
                            . '<b>Mensaje:</b> ' . $objRes->getMensaje());
                        } else {
                            Session::set('sess_numeroFile', $objRes->getFile());
                            $param = 'correo=1' . '&file=' . $objRes->getFile() . '&programa=' . Session::get('sess_codigoPrograma') . '&__sucessful__=ok';


                            $html = $this->curlPOST($param, BASE_URL . 'programas/cartaConfirmacion/form');


                            $mailHotel=$programas->getCorreoHotel($objRes->getFile());
                            
                            
                            $this->getLibrary('class.phpmailer');
                            //$this->mailReserva($objRes->getFile(), $html);
                            echo 'OK&' . md5(':D');
                        }
                    }
                }
            }
        } else {
            throw new Exception('Error al cargar las opciones');
        }
    }

    /**
     * Metodo CenterBox: Abre la carta de confirmacion una vez realizada la reserva.
     * <PRE>
     * -.Creado: 20/05/2015
     * </PRE>
     * @return String HTML carta confirmacion
     * @author Jonathan Estay
     */
    public function cartaConfirmacion($form = '') {
        $this->_view->form = $form;
        //Session::acceso('Usuario');
        /* if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest') { */
        if ($this->getTexto('__sucessful__')) {
            //Cargando modelos
            $M_file = $this->loadModel('reserva');
            $M_packages = $this->loadModel('programa');
            $pajasero = $this->loadModel('pasajero');

            if (!Session::get('sess_numeroFile')) {
                if ($this->getInt('correo') == 1) {
                    Session::set('sess_numeroFile', $this->getTexto('file'));
                    Session::set('sess_codigoPrograma', $this->getTexto('programa'));
                } else {
                    throw new Exception('File no recibido');
                }
            }


            $objsFile = $M_file->getFile(Session::get('sess_numeroFile'));
            $this->_view->CC_objsDetFile = $M_file->getDetFile(Session::get('sess_numeroFile'));

            $objsPackages = $M_packages->getPackages(Session::get('sess_codigoPrograma'));


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

                $this->_view->CC_datos = $objsFile[0]->getDatos();
                $this->_view->CC_ajuste = $objsFile[0]->getAjuste();
                $this->_view->CC_tcomi = $objsFile[0]->getTComi();
            }

            if ($objsPackages) {
                $this->_view->CC_nombreProg = $objsPackages[0]->getNombre();
            }

            $this->_view->objetosPasajero = $pajasero->getPasajeros(Session::get('sess_numeroFile'));
            //echo var_dump($this->_view->objetosPasajero);
            $this->_view->condicionesGenerales = Functions::getCondicionesGenerales();

            $this->_view->numFile = Session::get('sess_numeroFile');
            $this->_view->codigoPRG = Session::get('sess_codigoPrograma');

            $this->_view->renderingCenterBox('cartaConfirm');
        } else {
            throw new Exception('Error al desplegar la carta de confirmacion, [sucessful]');
        }
        /* } else {
          throw new Exception('Error al desplegar la carta de confirmacion');
          } */
    }

    /*
     * Begin: Administracion
     */

    /**
     * Metodo CenterBox: Formulario para editar un programa.
     * <PRE>
     * -.Creado: 15/04/2015
     * </PRE>
     * @return String Vista
     * @author Jonathan Estay
     */
    public function editar($form = '') {
        $this->_view->form = $form;

        Session::acceso('Usuario');
        Session::destroy('sessMOD_EP_codPRG');
        $AP_codigoPrg = $this->getTexto('varCenterBox');
        if ($AP_codigoPrg) {
            $EP_programa = $this->loadModel('programa');
            Session::set('sessMOD_EP_codPRG', $AP_codigoPrg);

            $EP_objPrograma = $EP_programa->getAdmProgramas(0, $AP_codigoPrg);
            if ($EP_objPrograma) {
                $this->_view->EP_nombreProg = $EP_objPrograma[0]->getNombre();
                $rutaPDF = ROOT . 'public' . DS . 'pdf' . DS . 'upl_' . str_replace(' ', '_', $EP_objPrograma[0]->getCodigo()) . '.pdf';
                if (is_readable($rutaPDF)) {
                    $this->_view->EP_PDF = 'upl_' . str_replace(' ', '_', $EP_objPrograma[0]->getCodigo()) . '.pdf';
                } else {
                    $this->_view->EP_PDF = false;
                }


                $rutaFoto = ROOT . 'public' . DS . 'img' . DS . 'programas' . DS . 'thumb' . DS . 'upl_' . str_replace(' ', '_', $EP_objPrograma[0]->getCodigo());
                $extension = Functions::getExtensionImagen($rutaFoto);
                if ($extension) {
                    $this->_view->ep_foto = 'upl_' . str_replace(' ', '_', $EP_objPrograma[0]->getCodigo()) . $extension;
                } else {
                    $this->_view->ep_foto = false;
                }


                $objPrograma = $EP_programa->getPrograma(Session::get('sessMOD_EP_codPRG'));
                if ($objPrograma) {
                    $this->_view->ep_descripcion = $objPrograma[0];
                    $this->_view->hotel = $objPrograma[1];
                    $this->_view->traslados = $objPrograma[2];
                    $this->_view->tkt_aereo = $objPrograma[3];
                    $this->_view->seguro_viajes = $objPrograma[4];
                    $this->_view->EH_rest = $objPrograma[5];
                } else {
                    $this->_view->ep_descripcion = '';
                    $this->_view->hotel = 0;
                    $this->_view->traslados = 0;
                    $this->_view->tkt_aereo = 0;
                    $this->_view->seguro_viajes = 0;
                    $this->_view->EH_rest = 0;
                }

                $this->_view->renderingCenterBox('editarPrograma');
            } else {
                throw new Exception('Error al intentar editar programa. (Metodo)');
            }
        } else {
            throw new Exception('Error al intentar editar programa');
        }
    }

    /**
     * Metodo procesador: Modifica el pdf de un programa en base al codigo de este.
     * <PRE>
     * -.Creado: 15/04/2015
     * </PRE>
     * @return String OK
     * @author Jonathan Estay
     */
    public function modificar_pdf() {
        Session::acceso('Usuario');
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest' || (Session::get('sess_browser') == 'IE9')) {

            $ruta = ROOT . 'public' . DS . 'pdf' . DS;
            if ($this->getTexto('chkEP_flPDF')) {

                if ($this->getTexto('chkEP_flPDF') == 'on') {

                    if (Functions::eliminaFile($ruta . 'upl_' . str_replace(' ', '_', Session::get('sessMOD_EP_codPRG')) . '.pdf')) {
                        echo 'OK';
                    } else {
                        throw new Exception('Error al eliminar el archivo, intente nuevamente');
                    }
                } else {
                    throw new Exception('Debe seleccionar un archivo a eliminar');
                }
            } else {

                if (Functions::uploadFile('flPDF', 'application/pdf', Session::get('sessMOD_EP_codPRG'), $ruta)) {
                    echo 'OK';
                } else {
                    throw new Exception('Error al intentar subir el archivo');
                }
            }
        } else {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }

    public function imprimir($form = '') {

        $programas = $this->loadModel('programa');
        $sql = Session::get('sess_TS_GET_PROGRAMAS_ID');
        $this->_view->objProgramas = $programas->exeTS_GET_PROGRAMAS($sql);
        $id = $this->getTexto('varCenterBoxNota');
        $this->_view->moneda = $this->getTexto('varCenterBoxmoneda');
        $this->_view->sgl = $this->getTexto('varCenterBoxsgl');
        $this->_view->dbl = $this->getTexto('varCenterBoxdbl');
        $this->_view->tpl = $this->getTexto('varCenterBoxtpl');
        $this->_view->chd1 = $this->getTexto('varCenterBoxchd1');
        $this->_view->chd2 = $this->getTexto('varCenterBoxchd2');
        $this->_view->pf = $this->getTexto('varCenterBoxpf');
        $this->_view->hab = $this->getJson('varCenterBox');
        $this->_view->hot = $this->getJson('varCenterBoxH');
        $this->_view->plan = $this->getJson('varCenterBoxPa');
        $this->_view->cant = $this->getJson('varCenterBoxCat');

        $this->_view->pago = true;//cambiar a false

       /* if (Session::get('sess_boton_pago')) {
            $this->_view->pago = true;
        }*/

        $this->_view->nota = $programas->getNotaOpc($id);

        $this->_view->renderingCenterBox('imprimir');
    }

    /**
     * Metodo procesador: Modifica la foto de un programa en base al codigo de este.
     * <PRE>
     * -.Creado: 08/06/2015
     * -.Modificado: 09/06/2015
     * </PRE>
     * @return String OK
     * @author Jonathan Estay
     */
    public function modificar_foto() {
        Session::acceso('Usuario');
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest' || (Session::get('sess_browser') == 'IE9')) {
            $ruta = ROOT . 'public' . DS . 'img' . DS . 'programas' . DS;
            if ($this->getTexto('chkEP_flFoto')) {

                if ($this->getTexto('chkEP_flFoto') == 'on') {

                    $extension = Functions::getExtensionImagen($ruta . 'upl_' . str_replace(' ', '_', Session::get('sessMOD_EP_codPRG')));
                    if (Functions::eliminaFile($ruta . 'upl_' . str_replace(' ', '_', Session::get('sessMOD_EP_codPRG')) . $extension)) {
                        Functions::eliminaFile($ruta . 'thumb' . DS . 'upl_' . str_replace(' ', '_', Session::get('sessMOD_EP_codPRG')) . $extension);
                        echo 'OK';
                    } else {
                        throw new Exception('Error al eliminar el archivo, intente nuevamente');
                    }
                } else {
                    throw new Exception('Debe seleccionar un archivo a eliminar');
                }
            } else {

                if (Functions::uploadFileImage('flFoto', $ruta, Session::get('sessMOD_EP_codPRG'))) {
                    echo 'OK';
                } else {
                    throw new Exception('Error al intentar subir el archivo');
                }
            }
        } else {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }

    /**
     * Metodo procesador: Modifica la foto de un programa en base al codigo de este.
     * <PRE>
     * -.Creado: 08/06/2015
     * -.Modificado: 09/06/2015
     * </PRE>
     * @return String OK
     * @author Jonathan Estay
     */
    public function modificar() {
        Session::acceso('Usuario');
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest' || (Session::get('sess_browser') == 'IE9')) {
            $comentario = $this->getPostClave('areaDescrip');
            /* if($comentario) { */
            $programa = $this->loadModel('programa');
            $objPrograma = $programa->getPrograma(Session::get('sessMOD_EP_codPRG'));
            //echo var_dump($objPrograma);
            if ($objPrograma) {
                $programa->comentario(Session::get('sessMOD_EP_codPRG'), $comentario);
                echo 'OK';
            } else {
                $programa->comentario(Session::get('sessMOD_EP_codPRG'), $comentario, true);
                echo 'OK';
            }
            /* } else {
              throw new Exception('Debe ingresar un comentario' . $comentario);
              } */
        } else {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }

    /*
     * End: Administracion
     */

    /**
     * Metodo procesador: Modifica lo que incluye un programa.
     * <PRE>
     * -.Creado: 20/10/2015
     * -.Modificado: 01/01/1900
     * </PRE>
     * @return String OK
     * @author Jonathan Estay
     */
    public function agregarIncluye() {
        Session::acceso('Usuario');
        if (strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest' || (Session::get('sess_browser') == 'IE9')) {

            $hotel = Functions::validaChk($this->getTexto('chkHotel'));
            $traslado = Functions::validaChk($this->getTexto('chkTraslado'));
            $tkt_aereo = Functions::validaChk($this->getTexto('chkTKT_Aereo'));
            $seguro_viaje = Functions::validaChk($this->getTexto('chkSeguroViajes'));

            $plan_alim_chk = Functions::validaChk($this->getTexto('chkPlanAlimento'));
            $plan_alim_cmb = $this->getTexto('cmbPlanAlimento');


            if (!$plan_alim_chk) {
                $plan_alim_cmb = 0;
            }

            //echo 'PA: ' . $plan_alim_cmb;            exit;

            $programa = $this->loadModel('programa');
            $objPrograma = $programa->getPrograma(Session::get('sessMOD_EP_codPRG'));

            $st = true;
            if ($objPrograma) {
                $st = false;
            }
            $programa->addServiciosIncluidos(Session::get('sessMOD_EP_codPRG'), $hotel, $traslado, $tkt_aereo, $seguro_viaje, $plan_alim_cmb, $st);
            echo 'OK';
        } else {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }

    /*
     * End: Administracion
     */















    /*     * *****************************************************************************
     *                                                                              *
     *                             METODOS PRIVADOS                                 *
     *                                                                              *
     * ***************************************************************************** */

    /**
     * Metodo privado: Retorna la distribucion de los pasajeros.
     * <PRE>
     * -.Creado: 02/06/2015
     * -.Modificado: 03/06/2015
     * </PRE>
     * @return String Contiene la distribucion ((01SGL, 01DBL, 01TPL) + 01CHD + 01CH2) a pasar al Stored Procedure 
     * @author Jonathan Estay
     */
    private function _distribucionPax($hab) {

        $sgl = 0;
        $dbl = 0;
        $tpl = 0;
        $distribucion = '';
        $distribucionTMP = '';
        for ($i = 1; $i <= $hab; $i++) {

            if(Session::get('sess_PF')>0 && Session::get('sess_DP_cmbAdultos_' . $i) == 2 && Session::get('sess_DP_cmbChild_' . $i) == 2){
                $distribucion .='01DEP'.';';
            }
            else{
                if (Session::get('sess_DP_cmbAdultos_' . $i) == 1) {
                $sgl++;
                $distribucionTMP = '0' . $sgl . 'SGL';
            } else if (Session::get('sess_DP_cmbAdultos_' . $i) == 2) {
                $dbl++;
                $distribucionTMP = '0' . $dbl . 'DBL';
            } else if (Session::get('sess_DP_cmbAdultos_' . $i) == 3) {
                $tpl++;
                $distribucionTMP = '0' . $tpl . 'TPL';
            }

            //CHD
            if (Session::get('sess_DP_cmbChild_' . $i) == 1) {
                $distribucionTMP .= '+01CHD';
            } else if (Session::get('sess_DP_cmbChild_' . $i) == 2) {
                $distribucionTMP .= '+01CHD+01CH2';
            }
            
            $distribucion .= $distribucionTMP . ';';
            }
        }
        
        return $distribucion;
    }

    /**
     * Metodo privado: Valida todos los pasajeros antes de realizar la reserva de un programa.
     * <PRE>
     * -.Creado: 19/05/2015
     * -.Modificado: 20/05/2015
     * </PRE>
     * @return String Contiene la cantidad de pasajeros a pasar al Stored Procedure 
     * @author Jonathan Estay
     */
    private function _validaPasajeros() {

        $cnt = 0;
        $pasajeros = '';
        for ($i = 1; $i <= Session::get('sess_DP_cntHab'); $i++) {
            /*
             * Begin: Validacion Adulto
             */
            for ($j = 1; $j <= Session::get('sess_DP_cmbAdultos_' . $i); $j++) {
                $cnt++;
                if (!$this->getTexto('DP_txtNombre_' . $i . '_' . $j)) {
                    throw new Exception("Debe ingresar un <b>Nombre</b> para el pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                }
                if (!$this->getTexto('DP_txtApellido_' . $i . '_' . $j)) {
                    throw new Exception("Debe ingresar un <b>Apellido</b> para el pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                }


                $pasajeros.= ', "' . $this->getTexto('DP_txtNombre_' . $i . '_' . $j) . ' ' . $this->getTexto('DP_txtApellido_' . $i . '_' . $j) . '"';



                if (!$this->getCheckbox('DP_chkPasaporte_' . $i . '_' . $j)) {

                    if (!$this->getTexto('DP_txtRut_' . $i . '_' . $j)) {
                        throw new Exception("Debe ingresar un <b>Rut</b> para el pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                    }
                    if (!Functions::validaRut($this->getTexto('DP_txtRut_' . $i . '_' . $j))) {
                        throw new Exception("<b>Rut</b> incorrecto del pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                    }

                    $pasajeros.= ', "' . $this->getTexto('DP_txtRut_' . $i . '_' . $j) . '"';
                } else {
                    if (!$this->getTexto('DP_txtPasaporte_' . $i . '_' . $j)) {
                        throw new Exception("Debe ingresar un <b>Pasaporte</b> para el pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                    }

                    $pasajeros.= ', "' . $this->getTexto('DP_txtPasaporte_' . $i . '_' . $j) . '"';
                }


                if (!$this->getTexto('DP_txtFecha_' . $i . '_' . $j)) {
                    throw new Exception("Debe ingresar una <b>Fecha de nacimiento</b> para el pasajero [" . $j . "], de la habitaci&oacute;n [" . $i . "]");
                }


                if (WEB) {
                    $pasajeros.= ', "' . Functions::invertirFecha($this->getTexto('DP_txtFecha_' . $i . '_' . $j), '/', '-') . '", "A"';
                } else {
                    $pasajeros.= ', "' . $this->getTexto('DP_txtFecha_' . $i . '_' . $j) . '", "A"';
                }
            }
            /*
             * End: Validacion Adulto
             */


            /*
             * Begin: Validacion Child
             */
            //if(Session::get('sess_DP_cmbChild_' . $i)) {
            for ($k = 1; $k <= Session::get('sess_DP_cmbChild_' . $i); $k++) {
                $cnt++;
                if (!$this->getTexto('DP_txtNombreC_' . $i . '_' . $k)) {
                    throw new Exception("Debe ingresar un <b>Nombre</b> para el child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                }
                if (!$this->getTexto('DP_txtApellidoC_' . $i . '_' . $k)) {
                    throw new Exception("Debe ingresar un <b>Apellido</b> para el child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                }

                $pasajeros.= ', "' . $this->getTexto('DP_txtNombreC_' . $i . '_' . $k) . ' ' . $this->getTexto('DP_txtApellidoC_' . $i . '_' . $k) . '"';



                if (!$this->getCheckbox('DP_chkPasaporteC_' . $i . '_' . $k)) {

                    if (!$this->getTexto('DP_txtRutC_' . $i . '_' . $k)) {
                        throw new Exception("Debe ingresar un <b>Rut</b> para el child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                    }
                    if (!Functions::validaRut($this->getTexto('DP_txtRutC_' . $i . '_' . $k))) {
                        throw new Exception("<b>Rut</b> incorrecto del child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                    }

                    $pasajeros.= ', "' . $this->getTexto('DP_txtRutC_' . $i . '_' . $k) . '"';
                } else {
                    if (!$this->getTexto('DP_txtPasaporteC_' . $i . '_' . $k)) {
                        throw new Exception("Debe ingresar un <b>Pasaporte</b> para el child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                    }

                    $pasajeros.= ', "' . $this->getTexto('DP_txtPasaporteC_' . $i . '_' . $k) . '"';
                }


                if (!$this->getTexto('DP_txtFechaC_' . $i . '_' . $k)) {
                    throw new Exception("Debe ingresar una <b>Fecha de nacimiento</b> para el child [" . $k . "], de la habitaci&oacute;n [" . $i . "]");
                }


                if (WEB) {
                    $pasajeros.= ', "' . Functions::invertirFecha($this->getTexto('DP_txtFechaC_' . $i . '_' . $k), '/', '-') . '", "C"';
                } else {
                    $pasajeros.= ', "' . $this->getTexto('DP_txtFechaC_' . $i . '_' . $k) . '", "C"';
                }
            }
            /*
             * End: Validacion Child
             */
        }

        for ($l = $cnt; $l < 12; $l++) {
            $pasajeros.= ', "", "", "", ""';
        }

        return $pasajeros;
    }

    /**
     * Metodo privado: Calcula el valor total a pagar antes de reservar un programa.
     * <PRE>
     * -.Creado: 19/05/2015
     * </PRE>
     * @param $hab Cantidad de habitaciones
     * @return int valor total de la habitacion
     * @author Jonathan Estay
     */
    private function _valorTotal($hab) {
        $total = 0;
        for ($i = 1; $i <= $hab; $i++) {
 
            if(Session::get('sess_PF')>0&& Session::get('sess_DP_cmbAdultos_' . $i) == 2 && Session::get('sess_DP_cmbChild_' . $i) == 2){
                $total =  $total + Session::get('sess_PF');
                
            }else{
                if (Session::get('sess_DP_cmbAdultos_' . $i) == 1) {
                $total = $total + (Session::get('sess_DP_cmbAdultos_' . $i) * Session::get('sess_SGL'));
            } else if (Session::get('sess_DP_cmbAdultos_' . $i) == 2) {
                $total = $total + (Session::get('sess_DP_cmbAdultos_' . $i) * Session::get('sess_DBL'));
            } else if (Session::get('sess_DP_cmbAdultos_' . $i) == 3) {
                $total = $total + (Session::get('sess_DP_cmbAdultos_' . $i) * Session::get('sess_TPL'));
            }
            if (Session::get('sess_DP_cmbChild_' . $i) == 1) {
            $total = $total + Session::get('sess_CHD1');
            } else if (Session::get('sess_DP_cmbChild_' . $i) == 2) {
            $total = $total + Session::get('sess_CHD1') + Session::get('sess_CHD2');
            }
            }
        }
        
        
        return $total;
    }

    /*     * *****************************************************************************
     *                                                                              *
     *                             METODOS PROCESADORES                             *
     *                                                                              *
     * ***************************************************************************** */

    /**
     * Metodo procesador: Procesa los datos de la busqueda de programas.
     * <PRE>
     * -.Creado: 19/05/2015
     * </PRE>
     * @author Jonathan Estay
     */
    public function buscar($form = '', $url = '') {

        Buscador::buscar($url);

        $BP_cntHab = $this->getInt('mL_cmbHab_PRG');
        $BP_ciudadDes = $this->getTexto('mL_txtCiudadDestino_PRG');
        $BP_fechaIn = $this->getTexto('mL_txtFechaIn_PRG');
        $BP_fechaOut = $this->getTexto('mL_txtFechaOut_PRG');
        $BP_hotel = $this->getTexto('mL_txtHotel_PRG');

        if ($BP_ciudadDes) {
            Session::set('sess_BP_ciudadDes_PRG', $BP_ciudadDes);
        }

        Session::set('sess_BP_cntHab_PRG', $BP_cntHab);
        Session::set('sess_BP_fechaIn_PRG', $BP_fechaIn);
        Session::set('sess_BP_fechaOut_PRG', $BP_fechaOut);
        Session::set('sess_BP_hotel_PRG', $BP_hotel);


        Session::set('sess_BP_cntPas', 0);
        Session::set('sess_BP_cntAdl', 0);
        Session::set('sess_BP_cntChd', 0);
        Session::set('sess_BP_cntInf', 0);

        for ($i = 1; $i <= 3; $i++) {
            if ($i <= $BP_cntHab) {
                Session::set('sess_BP_Adl_' . $i, $this->getInt('mL_cmbAdultos_' . $i));
                Session::set('sess_BP_Chd_' . $i, $this->getInt('mL_child_' . $i));
                Session::set('sess_BP_Inf_' . $i, $this->getInt('mL_inf_' . $i));


                if (Session::get('sess_BP_Adl_' . $i) > 0) {
                    Session::set('sess_BP_cntAdl', (Session::get('sess_BP_cntAdl') + 1));
                }
                if (Session::get('sess_BP_Chd_' . $i) > 0) {
                    Session::set('sess_BP_cntChd', (Session::get('sess_BP_cntChd') + 1));
                }
                if (Session::get('sess_BP_Inf_' . $i) > 0) {
                    Session::set('sess_BP_cntInf', (Session::get('sess_BP_cntInf') + 1));
                }


                for ($x = 1; $x <= 2; $x++) {
                    Session::set('sess_BP_edadChd_' . $x . '_' . $i, $this->getInt('mL_edadChild_' . $x . '_' . $i));
                }

                Session::set('sess_BP_cntPas', (Session::get('sess_BP_cntPas') + Session::get('sess_BP_Adl_' . $i) + Session::get('sess_BP_Chd_' . $i)));
            } else {
                Session::set('sess_BP_Adl_' . $i, 0);
                Session::set('sess_BP_Chd_' . $i, 0);
                Session::set('sess_BP_Inf_' . $i, 0);

                Session::set('sess_BP_edadChd_1_' . $i, 0);
                Session::set('sess_BP_edadChd_2_' . $i, 0);
            }
        }


        $this->redireccionar('programas/index/' . $form);
    }

    /**
     * Metodo procesador: Guarda en sesion la ciudad buscada en la administracion de programas.
     * <PRE>
     * -.Creado: 19/05/2015
     * </PRE>
     * @author Jonathan Estay
     */
    public function buscarAdm() {
        Session::set('sess_AP_ciudad', $this->getTexto('AP_cmbCiudadDestino'));
        $this->redireccionar('programas/admin');
    }

}
