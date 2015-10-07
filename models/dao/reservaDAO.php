<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class reservaDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getReservas($desde, $hasta, $tipo, $spAcceso, $cUsuario)
    {
        $sql='SELECT a.*, 
                (SELECT TOP 1 cod_pak FROM det_file where num_file = A.num_file) as cod_pak,
                (SELECT top 1 record_c FROM det_bloq where num_file = A.num_file) as record_c 
                
            FROM  (SELECT agencia, num_file, nompax, totventa, estado, 
            totpag, usuario, moneda,
            CONVERT(VARCHAR(10), fecha, 103) as fecha, 
            CONVERT(VARCHAR(10), f_viaje, 103) as f_viaje, 
            fecha as fecha2, 
            f_viaje as f_viaje2, 
            ROW_NUMBER() OVER ';
		
        if($tipo==1)
        {
            $sql.=' (ORDER BY fecha) as row';
        }
        elseif($tipo==2)
        {
            $sql.=' (ORDER BY f_viaje) as row';
        }

        $sql.=' FROM file_ WHERE 1=1';






        if(trim($spAcceso) != 'S')
        {
            $sql.=' AND usuario = "'.$cUsuario.'" ';
        }
        else
        {
            $sql.=' AND ope = "WEB" ';
        }



        if($tipo==1)
        {
            $sql.=' AND fecha BETWEEN "'.$desde.'" AND "'.$hasta.'" ';
        }
        elseif($tipo==2)
        {
            $sql.=' AND f_viaje BETWEEN "'.$desde.'" AND "'.$hasta.'" ';
        }


        $sql.=' ) a ';


        if($tipo==1)
        {
            $sql.=' ORDER BY fecha2, num_file ASC';
        }
        elseif($tipo==2)
        {
            $sql.=' ORDER BY f_viaje2, num_file ASC';
        }
        //echo $sql; //exit;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosReserva= array();
            $arrayReservas= $this->_db->fetchAll($datos);
            
            foreach ($arrayReservas as $rDB){
                $objReserva= new reservaDTO();
                
                $objReserva->setAgencia(trim($rDB['agencia']));
                $objReserva->setFile(trim($rDB['num_file']));
                $objReserva->setNomPax(trim($rDB['nompax']));
                $objReserva->setTotVenta(intval($rDB['totventa']));
                $objReserva->setEstado(trim($rDB['estado']));
                $objReserva->setTotPag(intval($rDB['totpag']));
                $objReserva->setUsuario(trim($rDB['usuario']));
                $objReserva->setMoneda(trim($rDB['moneda']));
                $objReserva->setFecha(trim($rDB['fecha']));
                $objReserva->setFViaje(trim($rDB['f_viaje']));
                $objReserva->setFecha2(trim($rDB['fecha2']));
                $objReserva->setFViaje2(trim($rDB['f_viaje2']));
                $objReserva->setRow(trim($rDB['row']));
                $objReserva->setCodPak(trim($rDB['cod_pak']));
                $objReserva->setRecordC(trim($rDB['record_c']));
                
                $objetosReserva[]=$objReserva;
            }
            
            return $objetosReserva;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getReservas_TEST($desde, $hasta, $tipo, $spAcceso, $cUsuario)
    {
        $sql='SELECT a.*, 
                (SELECT TOP 1 cod_pak FROM det_file where num_file = A.num_file) as cod_pak,
                (SELECT top 1 record_c FROM det_bloq where num_file = A.num_file) as record_c 
                
            FROM  (SELECT agencia, num_file, nompax, totventa, estado, 
            totpag, usuario, moneda,
            CONVERT(VARCHAR(10), fecha, 103) as fecha, 
            CONVERT(VARCHAR(10), f_viaje, 103) as f_viaje, 
            fecha as fecha2, 
            f_viaje as f_viaje2, 
            ROW_NUMBER() OVER ';
		
        if($tipo==1)
        {
            $sql.=' (ORDER BY fecha) as row';
        }
        elseif($tipo==2)
        {
            $sql.=' (ORDER BY f_viaje) as row';
        }

        $sql.=' FROM file_ ';






       
        //echo $sql; exit;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosReserva= array();
            $arrayReservas= $this->_db->fetchAll($datos);
            
            foreach ($arrayReservas as $rDB){
                $objReserva= new reservaDTO();
                
                $objReserva->setAgencia(trim($rDB['agencia']));
                $objReserva->setFile(trim($rDB['num_file']));
                $objReserva->setNomPax(trim($rDB['nompax']));
                $objReserva->setTotVenta(intval($rDB['totventa']));
                $objReserva->setEstado(trim($rDB['estado']));
                $objReserva->setTotPag(intval($rDB['totpag']));
                $objReserva->setUsuario(trim($rDB['usuario']));
                $objReserva->setMoneda(trim($rDB['moneda']));
                $objReserva->setFecha(trim($rDB['fecha']));
                $objReserva->setFViaje(trim($rDB['f_viaje']));
                $objReserva->setFecha2(trim($rDB['fecha2']));
                $objReserva->setFViaje2(trim($rDB['f_viaje2']));
                $objReserva->setRow(trim($rDB['row']));
                $objReserva->setCodPak(trim($rDB['cod_pak']));
                $objReserva->setRecordC(trim($rDB['record_c']));
                
                $objetosReserva[]=$objReserva;
            }
            
            return $objetosReserva;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getFile($nFile)
    {
        $sql='SELECT [num_file], [tipof], [n_coti], CONVERT(Nvarchar(10), fecha, 103) as fecha, '
            . 'CONVERT(Nvarchar(10), f_viaje, 103) as f_viaje, [npax], [agencia], [nompax], [naciona], [ope], '
            . '[ciudad], [pais], [moneda], [cambio], [comag], [tcomi], [estado], [neto], [ajuste], [tticket], '
            . '[totventa], [totalco], [totpag], [vage], [datos], [notas], [fecontab], [ftkt], [autmod], [estnul], '
            . '[efactu], [totfac], [tipred], [totnc], [cfinal], [tt], [vta_age], [au_mg_me], [promoto], [feccierre], '
            . '[diacierre], [montodesciva], [MRK], [vta_comagdes], [Referencia], [NegocioSigav], [atipoa], [Por_comi], '
            . '[Tipo_comi], [Por_comip], [Tipo_comip], [area], [id_nodo] '
            . 'FROM file_ '
            . 'WHERE num_file = '.$nFile;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosFile= array();
            $arrayObjFile= $this->_db->fetchAll($datos);
            
            foreach ($arrayObjFile as $fileDB)
            {
                $objFile= new reservaDTO();
                
                $objFile->setAgencia(trim($fileDB['agencia']));
                $objFile->setVage(trim($fileDB['vage']));
                $objFile->setNomPax(trim($fileDB['nompax']));
                $objFile->setNpax(trim($fileDB['npax']));
                $objFile->setFViaje(trim($fileDB['f_viaje']));
                $objFile->setMoneda(trim($fileDB['moneda']));
                $objFile->setTotVenta(trim($fileDB['totventa']));
                $objFile->setCambio(trim($fileDB['cambio']));
                $objFile->setComag(trim($fileDB['comag']));
                $objFile->setDatos(trim($fileDB['datos']));
                $objFile->setAjuste(trim($fileDB['ajuste']));
                $objFile->setTcomi(intval(trim($fileDB['tcomi'])));
                $objFile->setFecha(trim($fileDB['fecha']));
                
                $objetosFile[]= $objFile;
            }
            
            return $objetosFile;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getDetFile($nFile)
    {
         $sql= 'SELECT num_file, codigo, nombre, CONVERT(Nvarchar(10), in_, 103) as in_, CONVERT(Nvarchar(10), out, 103) as out, pax_s, pax_d, pax_t, pax_q, pax_c, pax_c2, pax_a, pax_i, pax_ca '
            . 'FROM det_file '
            . 'WHERE num_file = "'.$nFile.'" AND NOT(codigo = "CGO") '
            . 'ORDER BY lin ASC ';
         
         //echo $sql;  exit;
         $datos= $this->_db->consulta($sql);
         if($this->_db->numRows($datos)>0)
         {
             $objetosDetFile= array();
             $arrayDetFile= $this->_db->fetchAll($datos);
             
             foreach ($arrayDetFile as $dfDB)
             {
                 $objDF= new detalleReservaDTO();
                 
                 $objDF->setFile(trim($dfDB['num_file']));
                 $objDF->setCodigo(trim($dfDB['codigo']));
                 $habitacionNombre=trim($dfDB['nombre']);
                 $habitacionNombre=str_replace('SGL','SINGLE',$habitacionNombre);
                 $habitacionNombre=str_replace('DBL','DOBLE',$habitacionNombre);
                 $habitacionNombre=str_replace('TRL','TRIPLE',$habitacionNombre);
                 $objDF->setNombre($habitacionNombre);
                 $objDF->setIN(trim($dfDB['in_']));
                 $objDF->setOut(trim($dfDB['out']));
                 $objDF->setPaxS(intval(trim($dfDB['pax_s'])));
                 $objDF->setPaxD(intval(trim($dfDB['pax_d'])));
                 $objDF->setPaxT(intval(trim($dfDB['pax_t'])));
                 $objDF->setPaxQ(intval(trim($dfDB['pax_q'])));
                 $objDF->setPaxC1(intval(trim($dfDB['pax_c'])));
                 $objDF->setPaxC2(intval(trim($dfDB['pax_c2'])));
                 $objDF->setPaxA(intval(trim($dfDB['pax_a'])));
                 $objDF->setPaxI(intval(trim($dfDB['pax_i'])));
                 $objDF->setPaxCA(intval(trim($dfDB['pax_ca'])));
                 
                 $objetosDetFile[]=$objDF;
             }
             
             return $objetosDetFile;
         }
         else
         {
             return false;
         }
    }
    public function getCorreo($user) {
        $sql = "SELECT correo_ejecutivo,correo_vendedor FROM usuarios_h2h WHERE usuario ='$user'";
        $datos=$this->_db->consulta($sql);
        $correo = false;
        if($this->_db->numRows($datos)>0){
            $correo = new usuarioH2hDTO();
            $data = $this->_db->fetchAll($datos);
            foreach ($data as $d) {
                $correo->setCorreoEjecutivo(trim($d['correo_ejecutivo']));
                $correo->setCorreoVendedor(trim($d['correo_vendedor']));
            }
        }
        
        return $correo;
        
    }
}