<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

abstract class Controller
{
    private $_registry;
    protected $_view;
    
    public function __construct() {
        $this->_registry = Registry::getInstancia();
        $this->_view= new View($this->_registry->_request);
    }
    
    abstract public function index();
    
    protected function _loadLeft()
    {
        
       
        
        if(substr($this->getServer('HTTP_REFERER'), 16, 22) == 'panamericanaturismo.cl' || substr($this->getServer('HTTP_REFERER'), 14, 22) == 'panamericanaturismo.cl')
        {
            
            $cliente = explode('/', substr($this->getServer('HTTP_REFERER'), 16, strlen($this->getServer('HTTP_REFERER')))); 
            if($cliente[1]) {
                
                Buscador::getCliente(trim($cliente[1]));    
            }
        }
        
        
        if($this->getTexto('mL_txtFechaIn')) {
            
            Session::set('sess_fechaDefault', $this->getTexto('mL_txtFechaIn'));
            
        } else if($this->getTexto('mL_txtFechaIn_PRG')) {
            
            Session::set('sess_fechaDefault', $this->getTexto('mL_txtFechaIn_PRG'));
            
        } else {
            
            Session::set('sess_fechaDefault', date('d/m/Y'));
        }
        

        
        
        if(!Session::get('sess_BP_fechaIn')) {
            $this->_view->ML_fechaIni =  Session::get('sess_fechaDefault');
            
        } else {
            
            $this->_view->ML_fechaIni =  Session::get('sess_BP_fechaIn');
        }
        
        if(!Session::get('sess_BP_fechaOut')) {
            
            $this->_view->ML_fechaFin=  Functions::sumFecha(Session::get('sess_fechaDefault'), 0, 6);//Session::get('sess_fechaDefault');
        } else {
            $this->_view->ML_fechaFin= Session::get('sess_BP_fechaOut');
        }
        
        
        
        
        
        
        if(!Session::get('sess_BP_fechaIn_PRG')) {
            
            $this->_view->ML_fechaIni_PRG= Functions::sumFecha(Session::get('sess_fechaDefault'), 0, 3);//Session::get('sess_fechaDefault');
        } else {
            
            $this->_view->ML_fechaIni_PRG = Session::get('sess_BP_fechaIn_PRG');
        }
        if(!Session::get('sess_BP_fechaOut_PRG')) {
            
            $this->_view->ML_fechaFin_PRG= Session::get('sess_fechaDefault');
            
        } else {
            
            $this->_view->ML_fechaFin_PRG= Session::get('sess_BP_fechaOut_PRG');
            
        }
        
    }
    
    protected function _alert($tipo=false, $msg=false)
    {
        Session::set('sess_alerts', $tipo); //Tipo alerta
        Session::set('sess_alerts_msg', $msg);
    }
    
    protected function _alertDestroy()
    {
        Session::destroy('sess_alerts');
        Session::destroy('sess_alerts_msg');
    }
    
    
    protected function loadModel($class)
    {
        $dao= $class . 'DAO';
        $dto= $class . 'DTO';
        $rutaDAO= ROOT . 'models' . DS . 'dao'. DS .$dao . '.php';
        $rutaDTO= ROOT . 'models' . DS . 'dto'. DS .$dto . '.php';
        $rutaDetalleDTO= ROOT . 'models' . DS . 'dto'. DS . 'detalle' .ucfirst($dto) . '.php';
        
        if(is_readable($rutaDAO))
        {
            if(is_readable($rutaDTO))
            {
                require_once $rutaDAO;
                require_once $rutaDTO;
                
                if(is_readable($rutaDetalleDTO))
                {
                    require_once $rutaDetalleDTO;
                }
                
                $dao= new $dao;
                return $dao; //retorna la instancia del modelo
            }
            else
            {
                throw new Exception('Error al cargar el DTO: ' . $rutaDTO);
            }
        }
        else
        {
            throw new Exception('Error al cargar el DAO: ' . $rutaDAO);
        }
    }
    
    protected function loadDTO($class)
    {
        $dto= $class . 'DTO';
        $rutaDTO= ROOT . 'models' . DS . 'dto'. DS .$dto . '.php';
        
        
        if(is_readable($rutaDTO))
        {
            require_once $rutaDTO;

            $dto= new $dto;
            return $dto; //retorna la instancia del modelo
        }
        else
        {
            throw new Exception('Error al cargar el DTO: ' . $rutaDTO);
        }
    }
    
    protected function getServer($clave)
    {
        if(!empty($_SERVER[$clave]))
        {
            return $_SERVER[$clave];
        }
    }
    
    protected function getPOST()
    {
        return $_POST;
    }
    
    protected function getPostClave($clave)
    {
        return trim($_POST[$clave]);
    }

    protected function getPostExist($clave)
    {
        if(isset($_POST[$clave])) {
            return true;
        } else {
            return false;
        }
    }
    
    protected function getTexto($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]= htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return trim($_POST[$clave]);
        }
    }
    
    protected function getJson($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            return $_POST[$clave];
        }
    }
    
    
    protected function getCheckbox($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            return true;
        }
    }
    
    protected function getInt($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]= filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return trim($_POST[$clave]);
        }
        
        return 0;
    }
    
    
    protected function redireccionar($ruta = false)
    {
        if($ruta) {
            header('location:' . BASE_URL . $ruta);
        } else {
            header('location:' . BASE_URL);
        }
        exit;
    }
    
    
    protected function getSql($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = strip_tags($_POST[$clave]);
            
            if(!get_magic_quotes_gpc()){
                $_POST[$clave] = mysql_escape_string($_POST[$clave]);
            }
            
            return trim($_POST[$clave]);
        }
    }
    
    protected function getAlphaNum($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }
    
    protected function getLibrary($libreria)
    {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            throw new Exception('Error al abrir la libreria: ' . $rutaLibreria);
        }
    }
    
    protected function filtrarInt($int)
    {
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else{
            return 0;
        }
    }
    
    protected function applicationRequirements()
    {
        $requirements = array(
            'version' => '',
            'curl' => '',
            'dom' => ''
        );

        $version = str_replace('.', '', phpversion());

        if ($version < 533) {
            $requirements['version'] = 'Se requiere PHP version 5.3.3 o superior.';
        }

        if (!function_exists('curl_init')) {
            $requirements['curl'] = 'Se requiere CURL library.';
        }

        if (!class_exists('DOMDocument')) {
            $requirements['dom'] = 'Se requiere DOM XML extension is required.';
        }

        return $requirements;
    }
    
    
    protected function curlPOST($param, $url) {
        $header = array();
        $header[] = 'Content-Type: text/xml; encoding="UTF-8"';
        $header[] = 'Content-Length: ' . strlen($param);
        
        $ch = curl_init($url); 
        //especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
        curl_setopt ($ch, CURLOPT_POST, 1);

        //le decimos qué paramáetros enviamos (pares nombre/valor, también acepta un array)
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        //le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        
        
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
    
    
    protected function curlGET_JSON($url, $user = false, $pass = false) {
        $header = array();
        $header[] = 'Content-Type: text/xml; encoding="UTF-8"';
        //$header[] = 'Content-Length: ' . strlen($param);
        
        $ch = curl_init($url);
        
        //Cabeceras a enviar (acepta array)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        
        
        if($user && $pass) {
            //Usuario y password que usan autentificacion BASIC
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        } 

        //le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $data = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($data);
    }
    
    
    protected function curlJSON($param, $url, $user = false, $pass = false) {
        
        $json = json_encode($param);
        $header = array();
        $header[] = 'Content-Type: application/json';
        //$header[] = 'Accept-Charset: ISO-8859-1,utf-8;'; 
        //$header[] = 'Content-Length: ' . strlen($json); 

        $ch = curl_init($url);
        
        //Cabeceras a enviar (acepta array)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        
        
        if($user && $pass) {
            //Usuario y password que usan autentificacion BASIC
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        }
        
        //especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
        curl_setopt($ch, CURLOPT_POST, 1);

        //le decimos qué paramáetros enviamos (pares nombre/valor, también acepta un array)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        //le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($data);
    }

    
    
    protected function mailReserva($file, $html) {
        // Preparar Correo electrónico
        $email_asunto="Confirmación de reserva online: ".$file;
        $email_destinatario = Session::get('sess_email');
        $email_destinatarioCC = Session::get('sess_email_opera');

        $mail = new PHPMailer();

        $mail->IsSMTP(); 
        $mail->Host = MAIL_HOST;
        $mail->Port = 25;
        $mail->From = MAIL_USER;
        $mail->CharSet = CHARSET; //'UTF-8';

        $mail->FromName = "Panamericana Online ";
        $mail->Subject = $email_asunto;
        $mail->MsgHTML($html); 

        $mail->AddAddress($email_destinatario, "");
        $mail->AddCC($email_destinatarioCC);

        $mail->SMTPAuth = MAIL_AUT;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;

        $mail->Send();
        sleep(2);
    }
    
    
    public static function destroyArray()
    {
        $arraySess = array('Autenticado', 'sess_key_', 'sess_ip', 'sess_fechaLogin', 
                            'sess_clave_usuario','sess_nombre',
                            'sess_cod_ven','sess_dctod','sess_dctoh','sess_agencia',
                            'sess_id_agen','sess_markup','sess_fecpass','sess_depto',
                            'sess_atipoa','sess_firma','sess_rut','sess_email','sess_email_opera',
                            'level','tiempo','sess_sp_acceso');
        
        return $arraySess;
    }
    
        protected function mailTipoCambio( $html,$email,$cc) {
        // Preparar Correo electrónico
        $email_asunto="Falta Tipo Cambio";
        $email_destinatario = $email;
        $email_destinatarioCC = $cc;
        $htmlEnviar = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">	  
                        <tr>
                        <td align="left">
                        <img src="'.BASE_URL.'views/layout/default/img/logo.jpg"  height="100" vspace="5" border="0" />
                        </td>
                        </tr>	
                        </table>';
        
        $htmlEnviar .=$html;
        
        $mail = new PHPMailer();

        $mail->IsSMTP(); 
        $mail->Host = MAIL_HOST;
        $mail->Port = 25;
        $mail->From = MAIL_USER;
        $mail->CharSet = CHARSET; //'UTF-8';

        $mail->FromName = "Panamericana ";
        $mail->Subject = $email_asunto;
        $mail->MsgHTML($htmlEnviar); 

        $mail->AddAddress($email_destinatario, "");
        if(is_array($cc)){
            
            foreach ($email_destinatarioCC as $c) {
         $mail->AddCC($c);  
            }
        }else{
         $mail->AddCC($email_destinatarioCC);   
        }

        $mail->SMTPAuth = MAIL_AUT;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;

        $mail->Send();
        sleep(2);
    }
}