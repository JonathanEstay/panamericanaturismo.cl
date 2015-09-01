<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class bloqueoDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getBloqueos($cod)
    {
        $sql='SELECT notas FROM bloqueos WHERE record_c = "'.$cod.'"';
        $datos= $this->_db->consulta($sql);
        
        if($this->_db->numRows($datos)>0)
        {
            $objetosBloqueos= array();
            $arrayBloqueos= $this->_db->fetchAll($datos);
            
            foreach ($arrayBloqueos as $dfDB)
            {
                $objBloq= new bloqueoDTO();

                $objBloq->setNotas(trim($dfDB['notas']));
                
                $objetosBloqueos[]= $objBloq;
            }
            
            return $objetosBloqueos;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getDetBloq($codBloq, $nFile)
    {
        $sql = 'SELECT nompax, rut, CONVERT(Nvarchar(10), fchild,103) as fchild, ninfant, rut_inf, CONVERT(Nvarchar(10), finfant, 103) as finfant, '
                . 'tp, tipo_pax, CONVERT(Nvarchar(10), fecha_pag, 103) as fecha_pag, horarobot '
                . 'FROM det_bloq '
                . 'WHERE record_c = "'.$codBloq.'" and num_file = '.$nFile;
        //echo $sql;
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosDetBloq= array();
            $arrayDetBloq= $this->_db->fetchAll($datos);
            
            foreach ($arrayDetBloq as $detB)
            {
                $objDetB= new detalleBloqueoDTO();
                
                $objDetB->setNomPax(trim($detB['nompax']));
                $objDetB->setRut(trim($detB['rut']));
                $objDetB->setFChild(trim($detB['fchild']));
                $objDetB->setNInfant(trim($detB['ninfant']));
                $objDetB->setRutInf(trim($detB['rut_inf']));
                $objDetB->setFInfant(trim($detB['finfant']));
                $objDetB->setTp(trim($detB['tp']));
                $objDetB->setTipoPax(trim($detB['tipo_pax']));
                $objDetB->setFechaPag(trim($detB['fecha_pag']));
                $objDetB->setHoraRobot(trim($detB['horarobot']));
                
                $objetosDetBloq[]= $objDetB;
            }
            
            return $objetosDetBloq;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getPackages($cod)
    {
        $sql='SELECT * FROM packages WHERE codigo = "'.$cod.'" ';
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $objPackages= new bloqueoDTO();
                
                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));
                
                $objetosPack[]= $objPackages;
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function getIncluye($idPRG)
    {
        $sql="exec WEB_TraeDetalle '".$idPRG."' ";
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosInc= array();
            $arrayIncluye= $this->_db->fetchAll($datos);
            
            foreach ($arrayIncluye as $incDB)
            {
                $objIncluye= new incluyeDTO();
                
                $objIncluye->setCodigo(trim($incDB['codsvr']));
                $objIncluye->setNombre(trim($incDB['nombre']));
                $objIncluye->setCiudad(trim($incDB['ciudadHotel']));
                $objIncluye->setNoches((int)trim($incDB['Noches']));
                
                $objetosInc[]= $objIncluye;
            }
            
            return $objetosInc;
        }
        else
        {
            return false;
        }
    }
    
    public function getAdmProgramas($ciudad=0, $codProg=0)
    {
        $and='';
        $sql='SELECT P.id, P.nombre, P.codigo, C.nombre AS nombreC
            FROM h2h_programa P
            JOIN ciudad	C ON (C.codigo = P.Ciudad)
            WHERE ';
        if(!empty($ciudad))
        {
            $sql.=' C.nombre = "'.trim($ciudad).'" ';
            $and=' AND ';
        }

        if(!empty($codProg))
        {
            $sql.=$and.' P.codigo="'.$codProg.'" ';
        }

        $sql.='ORDER BY P.nombre ASC ';
        
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $objPackages= new bloqueoDTO();
                
                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));
                $objPackages->setId(trim($packDB['id']));
                $objPackages->setCiudad(trim($packDB['nombreC']));
                
                $objetosPack[]= $objPackages;
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function TS_GET_BLOQUEOS_PROG($sql, $inc=false)
    {
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $hotel= array();
                $codHotel= array();
                $PA= array();
                $TH= array();
                $codTH= array();
                $cat= array();
                $ciudad= array();
                $incluye= array();
                $valorHab= array();
                
                
                $objPackages= new bloqueoDTO();
                
                /*echo "ERROR: " . $packDB['Error']; echo "<br>";
                echo "Linea: " . $packDB['Linea'];echo "<br>";
                echo "Mensaje: " . $packDB['Mensaje']; exit;*/
                if(trim(isset($packDB['Error'])))
                {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                }
                else
                {
                    $objPackages->setId(trim($packDB['idPRG']));
                    $objPackages->setNombre(trim($packDB['nombrePRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    $objPackages->setTramo(trim($packDB['Tramo']));
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    //echo$packDB['itinerarioVuelo'];exit;
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    
                    /* VALOR HABITACION */
                    for ($i=1; $i<=3; $i++)
                    {
                        $valorHab[]=trim($packDB['vHab_'.$i]);
                    }
                    $objPackages->setValorHab($valorHab);
                    /* VALOR HABITACION */
                    
                    
                    /* HOTELES */
                    for($i=1; $i<=5; $i++)
                    {
                        if(trim($packDB['hotel_'.$i])) {
                            $hotel[]=trim($packDB['hotel_'.$i]);
                            $codHotel[]=trim($packDB['codHotel_'.$i]);
                            $PA[]=trim($packDB['PlanAlimenticio_'.$i]);
                            $TH[]=trim($packDB['TipoHabitacion_'.$i]);
                            $codTH[]=trim($packDB['codTipoHabitacion_'.$i]);
                            $cat[]=trim($packDB['cat_'.$i]);
                            $ciudad[]=trim($packDB['ciudad_'.$i]);
                        }
                    }
                    
                    $objPackages->setHoteles($hotel);
                    $objPackages->setCodHoteles($codHotel);
                    $objPackages->setPA($PA);
                    $objPackages->setTH($TH);
                    $objPackages->setCodTH($codTH);
                    $objPackages->setCat($cat);
                    $objPackages->setCiudad($ciudad);
                    /* HOTELES */
                    
                    if($inc)
                    {
                        $incluye[]= $this->getIncluye(trim($packDB['idPRG']));
                        $objPackages->setIncluye($incluye);
                    }
                    //$objPackages->setXXXX(trim($packDB['xxxxx']));
                }
                
                $objetosPack[]= $objPackages;
                //sleep(1);
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    
    public function TS_GET_BLOQUEOS_PROG_DETALLE($sql, $inc=false)
    {
        
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $hotel= array();
                $codHotel= array();
                $PA= array();
                $TH= array();
                $codTH= array();
                $cat= array();
                $ciudad= array();
                $incluye= array();
                $valorHab= array();
                
                
                $objPackages= new bloqueoDTO();
                
                /*echo "ERROR: " . $packDB['Error']; echo "<br>";
                echo "Linea: " . $packDB['Linea'];echo "<br>";
                echo "Mensaje: " . $packDB['Mensaje']; exit;*/
                if(trim(isset($packDB['Error'])))
                {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                }
                else
                {
                    $objPackages->setId(trim($packDB['idPRG']));
                    //$objPackages->setNombre(trim($packDB['nombrePRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    $objPackages->setTramo(trim($packDB['Tramo']));
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    
                    /* VALOR HABITACION */
                    for ($i=1; $i<=3; $i++)
                    {
                        $valorHab[]=trim($packDB['vHab_'.$i]);
                    }
                    $objPackages->setValorHab($valorHab);
                    /* VALOR HABITACION */
                    
                    
                    /* HOTELES */
                    for($i=1; $i<=5; $i++)
                    {
                        if(trim($packDB['hotel_'.$i])) {
                            $hotel[]=trim($packDB['hotel_'.$i]);
                            $codHotel[]=trim($packDB['codHotel_'.$i]);
                            $PA[]=trim($packDB['PlanAlimenticio_'.$i]);
                            $TH[]=trim($packDB['TipoHabitacion_'.$i]);
                            $codTH[]=trim($packDB['codTipoHabitacion_'.$i]);
                            $cat[]=trim($packDB['cat_'.$i]);
                            $ciudad[]=trim($packDB['ciudad_'.$i]);
                        }
                    }
                    
                    $objPackages->setHoteles($hotel);
                    $objPackages->setCodHoteles($codHotel);
                    $objPackages->setPA($PA);
                    $objPackages->setTH($TH);
                    $objPackages->setCodTH($codTH);
                    $objPackages->setCat($cat);
                    $objPackages->setCiudad($ciudad);
                    /* HOTELES */
                    
                    if($inc)
                    {
                        $incluye[]= $this->getIncluye(trim($packDB['idPRG']));
                        $objPackages->setIncluye($incluye);
                    }
                    //$objPackages->setXXXX(trim($packDB['xxxxx']));
                }
                
                $objetosPack[]= $objPackages;
                //sleep(1);
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    
    public function TS_GET_BLOQUEOS_PROG_ID($sql)
    {
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $hotel= array();
                $codHotel= array();
                $PA= array();
                $TH= array();
                $codTH= array();
                $cat= array();
                $ciudad= array();
                $incluye= array();
                $valorHab= array();
                
                
                $objPackages= new bloqueoDTO();
                
                /*echo "ERROR: " . $packDB['Error']; echo "<br>";
                echo "Linea: " . $packDB['Linea'];echo "<br>";
                echo "Mensaje: " . $packDB['Mensaje']; exit;*/
                if(trim(isset($packDB['Error'])))
                {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                }
                else
                {
                    $objPackages->setId(trim($packDB['idPRG']));
                    $objPackages->setCodigo(trim($packDB['codigoPRG']));
                    $objPackages->setNombre(trim($packDB['nombrePRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    $objPackages->setTramo(trim($packDB['Tramo']));
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    
                    /* VALOR HABITACION */
                    for ($i=1; $i<=3; $i++)
                    {
                        $valorHab[]=trim($packDB['vHab_'.$i]);
                    }
                    $objPackages->setValorHab($valorHab);
                    /* VALOR HABITACION */
                    
                    
                    /* HOTELES */
                    for($i=1; $i<=5; $i++)
                    {
                        if(trim($packDB['hotel_'.$i])) {
                            $hotel[]=trim($packDB['hotel_'.$i]);
                            $codHotel[]=trim($packDB['codHotel_'.$i]);
                            $PA[]=trim($packDB['PlanAlimenticio_'.$i]);
                            $TH[]=trim($packDB['TipoHabitacion_'.$i]);
                            $codTH[]=trim($packDB['codTipoHabitacion_'.$i]);
                            $cat[]=trim($packDB['cat_'.$i]);
                            $ciudad[]=trim($packDB['ciudad_'.$i]);
                        }
                    }
                    
                    $objPackages->setHoteles($hotel);
                    $objPackages->setCodHoteles($codHotel);
                    $objPackages->setPA($PA);
                    $objPackages->setTH($TH);
                    $objPackages->setCodTH($codTH);
                    $objPackages->setCat($cat);
                    $objPackages->setCiudad($ciudad);
                    /* HOTELES */
                    
                    
                }
                
                $objetosPack[]= $objPackages;
                //sleep(1);
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getNotaProg($id)
    {
        $sql="SELECT REPLACE(convert(varchar(MAX), nota), Char(13), '<br />') as nota "
            . "FROM h2h_Programa WHERE Id=".$id;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            $objPackages= new bloqueoDTO();
            
            $objPackages->setNota(trim($arrayPackages[0]['nota']));
            $objetosPack[]= $objPackages;
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function getItinerarioVuelo($idProg)
    {
        $sql='SELECT P.*, REPLACE(convert(varchar(MAX), notas), Char(13), "<br />") as notas
            FROM bloqueos B 
            JOIN h2h_programaOpc PO ON (B.record_c = PO.record_c)
            JOIN h2h_programa P ON (P.Id = PO.idProg) 
            WHERE P.Id = ' . $idProg;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            $objPackages= new bloqueoDTO();
            
            $objPackages->setItiVuelo(trim($arrayPackages[0]['notas']));
            $objetosPack[]= $objPackages;
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function getNotaOpc($idOpc)
    {
        $sql="SELECT REPLACE(convert(varchar(MAX), nota), Char(13), '<br />') as nota "
            . "FROM h2h_ProgramaOpc WHERE IdOpc=$idOpc";
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            $objPackages= new bloqueoDTO();
            
            $objPackages->setNotaOpc(trim($arrayPackages[0]['nota']));
            $objetosPack[]= $objPackages;
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function validaPrograma($id, $idOpc)
    {
        $sql='SELECT P.codigo, P.nombre
            FROM h2h_programaOpc PO
            JOIN h2h_programa P ON (PO.IdProg=P.Id)
            WHERE P.Id=' . $id . ' AND PO.IdOpc='.$idOpc;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            $objPackages= new bloqueoDTO();
            
            $objPackages->setCodigo(trim($arrayPackages[0]['codigo']));
            $objPackages->setNombre(trim($arrayPackages[0]['nombre']));
            
            $objetosPack[]= $objPackages;
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    public function exeSQL($sql)
    {
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            return $this->_db->fetchAll($datos);
        }
        else
        {
            return false;
        }
    }
}