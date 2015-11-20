<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Functions
{
    public function getCondicionesGenerales() {
        switch (Session::get('sess_codigo_cliente_url')) {
            case '3f7a2611ee08c6645796463e0bb1ae7f':
                
                return file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . 'travelclub.phtml');
                break;
            
            case '__OTRO__':
                return file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . 'travelclub.phtml');
                break;

            default:
                return file_get_contents(ROOT . 'views' . DS . 'condiciones' . DS . 'panamericana.phtml');
                break;
        }
    }
    
    public function validarFecha($fecha){
        
        $datos= explode('/', $fecha);
        
        return @checkdate($datos[1],$datos[0],$datos[2]);
    }


    public function uploadFile($file, $type, $name, $ruta) {
        if (isset($_FILES[$file]['name'])) {

            if ($_FILES[$file]['name']) {

                $upload = new upload($_FILES[$file], 'es_ES');
                $upload->allowed = array($type);
                $upload->file_max_size = '2097152'; // 2MB
                //$upload->file_new_name_body= 'upl_' . uniqid();
                $upload->file_new_name_body = 'upl_' . $name;
                $upload->process($ruta);

                if ($upload->processed) {
                    return true;
                } else {
                    throw new Exception('Error al subir el archivo: ' . $upload->error);
                }
            } else {
                throw new Exception('Debe seleccionar un archivo desde su computador');
            }
        } else {
            return false;
        }
    }
    
    
    
    
    public function uploadFileImage($file, $ruta, $name) {
        if(isset($_FILES[$file]['name'])) {
            if($_FILES[$file]['name']) {
                $upload= new upload($_FILES[$file], 'es_ES');
                $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                $upload->file_max_size = '524288'; // 512KB
                
                if ($name) {
                    $upload->file_new_name_body= 'upl_' . $name;
                } else {
                    $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                }
                $upload->process($ruta);

                if($upload->processed) { 
                    
                    //THUMBNAILS
                    $imagen= $upload->file_dst_name; 
                    $thumb= new upload($upload->file_dst_pathname);
                    $thumb->image_resize= true;
                    $thumb->image_x= 150;
                    $thumb->image_y= 150;
                    //$thumb->file_name_body_pre= 'thumb_';
                    $thumb->process($ruta . 'thumb' . DS);
                    
                    return true;
                    
                } else {
                    throw new Exception('Error al subir la imagen: ' . $upload->error);
                }
            }
            
        } else {
            return false;
        }
    }
    
    
    public function getExtensionImagen($file) {
        $types = array('.jpg', '.png', '.jpeg', '.gif');
        foreach($types as $ext) {
            if (file_exists($file . $ext)) {
                return $ext;
            }
        }
        
        return false;
    }
    
    public function getExtension($file) {
        $tmp = explode(".", $file); 
        $extension = end($tmp); 
        return $extension;
    }
    
    
    
    public function eliminaFile($file) {
        if(is_readable($file)) {
            @unlink($file);
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    public function tratoPax($tpax) {
        $result=NULL;
        switch ($tpax) {
        case 0:
            $result='Mr';
            break;
        case 1:
            $result='Mrs';
            break;
        case 2:
            $result='Mss';
            break;
        case 3:
            $result='Chl';
            break;
        }

        return $result;
    }
    
    public function validaRut($rut){
        if(strpos($rut,"-")==false) {
            $RUT[0] = substr($rut, 0, -1);
            $RUT[1] = substr($rut, -1);
        } else {
            $RUT = explode("-", trim($rut));
        }
        
        $elRut = str_replace(".", "", trim($RUT[0]));
        $factor = 2;
        $suma = 0;
        for($i = strlen($elRut)-1; $i >= 0; $i--) {
            $factor = $factor > 7 ? 2 : $factor;
            $suma += $elRut{$i}*$factor++;
        }
        $resto = $suma % 11;
        $dv = 11 - $resto;
        if($dv == 11) {
            $dv=0;
        } else if($dv == 10) {
            $dv="k";
        } else {
            $dv=$dv;
        }
       if($dv == trim(strtolower($RUT[1]))) {
           return true;
       } else {
           return false;
       }
    }
    
    public function traduceDia()
    {
        $dia=date('l');
        switch ($dia) {
            case 'Monday':
                $dia='Lunes';
                break;
            case 'Tuesday':
                $dia='Martes';
                break;
            case 'Wednesday':
                $dia='Mi&eacute;rcoles';
                break;
            case 'Thursday':
                $dia='Jueves';
                break;
            case 'Friday':
                $dia='Viernes';
                break;
            case 'Saturday':
                $dia='S&aacute;bado';
                break;
            case 'Sunday':
                $dia='Domingo';
                break;

            default:
                $dia='Error';
                break;
        }
        return $dia;
    }
    
    
    public function traduceMes()
    {
        $mes=date('F');
        switch ($mes) {
            case 'January':
                $mes='Enero';
                break;
            case 'February':
                $mes='Febrero';
                break;
            case 'March':
                $mes='Marzo';
                break;
            case 'April':
                $mes='Abril';
                break;
            case 'May':
                $mes='Mayo';
                break;
            case 'June':
                $mes='Junio';
                break;
            case 'July':
                $mes='Julio';
                break;
            case 'August':
                $mes='Agosto';
                break;
            case 'September':
                $mes='Septiembre';
                break;
            case 'October':
                $mes='Octubre';
                break;
            case 'November':
                $mes='Noviembre';
                break;
            case 'December':
                $mes='Diciembre';
                break;

            default:
                $mes='Error';
                break;
        }
        return $mes;
    }
    
    public function validaChk($chk)
    {
        if($chk=='on')
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    public function validaFoto($tipoFotoPerfil)
    {
        $tipoImagen=false;
            if(strpos(strtolower($tipoFotoPerfil), "gif")){ $tipoImagen= "gif"; }
        elseif(strpos(strtolower($tipoFotoPerfil), "png")){ $tipoImagen= "png"; }
        elseif(strpos(strtolower($tipoFotoPerfil), "jpeg")){ $tipoImagen= "jpg"; }
        elseif(strpos(strtolower($tipoFotoPerfil), "jpg")){ $tipoImagen= "jpg"; }

        if($tipoImagen)
        {
            return $tipoImagen;
        }
        else
        {
            return false;
        }
    }
    
    
    public static function fechaActual($dias=0)
    {
        $dyh= getdate(mktime(0, 0, 0, date("m"), date("d"), date("Y")) + 24*60*60*$dias);
        if($dyh['mday'] < 10){ $dia_dyh= "0".$dyh['mday']; }else{ $dia_dyh= $dyh['mday']; }
        if($dyh['mon'] < 10){ $mon_dyh= "0".$dyh['mon']; }else{ $mon_dyh= $dyh['mon']; }
        
        return $dia_dyh."/".$mon_dyh."/".$dyh['year'];
    }
    
    public static function invertirFecha($fecha, $char, $newChar)
    {
        if($fecha)
        {
            $datos = explode($char, $fecha);
            $fechaFinal = $datos[2].$newChar.$datos[1].$newChar.$datos[0];
        }
        else
        {
            $fechaFinal='';
        }
        
        return $fechaFinal;
    }
    
    public static function add_ceros($numero, $ceros) 
    {
        $cnt_ceros = 0;
        $dif = $ceros - strlen($numero);
        for($i=0; $i<=$dif; $i++) {
            $cnt_ceros .= 0;
        }

        return $cnt_ceros . $numero;
    }
    
    public static function getTipoMoneda($moneda) {
        switch ($moneda) {
            case 'D':
                $newMon='USD';
                break;
            case 'P':
                $newMon='$';
                break;
            case 'E':
                $newMon='EUR';
                break;
        
            default:
                $newMon='USD';
                break;
        }
        
        return $newMon;
    }

    public static function sumFecha($fIni, $dias=0, $meses=0, $years=0)
    {
        $fechaExp= explode('/', $fIni);
        $newDate= mktime(0, 0, 0, $fechaExp[1]+$meses, $fechaExp[0]+$dias, $fechaExp[2]+$years);
        $fechaEnd= date("d/m/Y", $newDate);
        
        return $fechaEnd;
        
        /*php 5.3 
        //P --Para iniciar los parametros de Fecah;
        //7Y --Setear 7 años
        //5M --Setear 5 meses
        //4D --Setear 4 dias
        //T -- para iniciar parametros de Hora
        //4H --Setear 4 horas
        //3M --Setear 3 minutos
        //2S --Setear 2 segundos
        //$fecha->add(new DateInterval('P7Y5M4DT4H3M2S'));
        $fecha = new DateTime($fIni);
        $fecha->add(new DateInterval('P'.$years.'Y'.$meses.'M'.$dias.'D'));
        echo $fecha->format('Y-m-d'); */
    }
    
    public function getMoneda($moneda) {
        if ($moneda == 'P') {
            return '$';
        } else if ($moneda == 'D') {
            return 'USD';
        } elseif ($moneda == 'E') {
            return 'EUR';
        }
    }
    
    public function getTarifa($dinero, $moneda) {
        if ($moneda == 'P') {
            return number_format($dinero, 0, ',', '.');
        } else if ($moneda == 'D') {
            return number_format($dinero, 2, ',', '.');
        } else if ($moneda == 'E') {
            return number_format($dinero, 0, ',', '.');
        }
    }
    
    public function formatoValor($moneda, $dinero) {
        
        $valor=false;
        if ($moneda == 'P') {
            $valor = '$ ' . number_format($dinero, 0, ',', '.');
        } else if ($moneda == 'D') {
            $valor = 'USD ' . number_format($dinero, 2, ',', '.');
        } else if ($moneda == 'E') {
            $valor = 'EUR ' . number_format($dinero, 0, ',', '.');
        }

        return $valor;
    }
    
    public static function getBrowser()
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent))
        {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
    
    public function validaCorreo($correo)
    {      
        
        $estado = true;
        $partes = explode("@", $correo);
        if (!empty($partes[0]) && !empty($partes[1]))
        {
            
            if (strlen(trim($partes[0])) < 2) {
                $estado = false;
            }else
                {           
                $partes_punto = explode(".", $partes[1]);
                $total_puntos = substr_count($partes[1], ".");
                if (!empty($partes_punto[0]) && !empty($partes_punto[1]))
                    {
                        for ($puntos = 0; $puntos <= $total_puntos; $puntos++) 
                        {
                            if (!empty($partes_punto[$puntos])) 
                                {
                                    if (strlen($partes_punto[$puntos]) < 2)
                                    {
                                    $estado = false;
                                    }
                                }else 
                                {
                                $estado = false;
                                }
                        }
                    }else
                    {
                    $estado = false;
                    }
                }
        }else 
        {
        $estado = false;
        }    
    return $estado;
    }
    public function convertirFechaCarta($fecha){
        
        $datos= explode('/', $fecha);
        
        switch ($datos[1]) {
            case '01':
                $mes='Enero';
                break;
            case '02':
                $mes='Febrero';
                break;
            case '03':
                $mes='Marzo';
                break;
            case '04':
                $mes='Abril';
                break;
            case '05':
                $mes='Mayo';
                break;
            case '06':
                $mes='Junio';
                break;
            case '07':
                $mes='Julio';
                break;
            case '08':
                $mes='Agosto';
                break;
            case '09':
                $mes='Septiembre';
                break;
            case '10':
                $mes='Octubre';
                break;
            case '11':
                $mes='Noviembre';
                break;
            case '12':
                $mes='Diciembre';
                break;

            default:
                $mes='Error';
                break;
        }
        $fechaNueva = $datos[0].' de '.$mes.' '.$datos[2] ;
        return $fechaNueva;
    }
    
}

?>