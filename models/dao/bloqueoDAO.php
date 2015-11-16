<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class bloqueoDAO extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getBloqueos($cod) {
        $sql = 'SELECT notas FROM bloqueos WHERE record_c = "' . $cod . '"';
        $datos = $this->_db->consulta($sql);

        if ($this->_db->numRows($datos) > 0) {
            $objetosBloqueos = array();
            $arrayBloqueos = $this->_db->fetchAll($datos);

            foreach ($arrayBloqueos as $dfDB) {
                $objBloq = new bloqueoDTO();

                $objBloq->setNotas(trim($dfDB['notas']));

                $objetosBloqueos[] = $objBloq;
            }

            return $objetosBloqueos;
        } else {
            return false;
        }
    }

    public function getDetBloq($codBloq, $nFile) {
        $sql = 'SELECT nompax, rut, CONVERT(Nvarchar(10), fchild,103) as fchild, ninfant, rut_inf, CONVERT(Nvarchar(10), finfant, 103) as finfant, '
                . 'tp, tipo_pax, CONVERT(Nvarchar(10), fecha_pag, 103) as fecha_pag, horarobot '
                . 'FROM det_bloq '
                . 'WHERE record_c = "' . $codBloq . '" and num_file = ' . $nFile;

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosDetBloq = array();
            $arrayDetBloq = $this->_db->fetchAll($datos);
            $cant=0;
            foreach ($arrayDetBloq as $detB) {
                $objDetB = new detalleBloqueoDTO();

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
                
                if(trim($detB['rut_inf'])!=''){
                    $cant++;
                }
                $objDetB->setCantidadInf($cant);
                $objetosDetBloq[] = $objDetB;
            }
            return $objetosDetBloq;
        } else {
            return false;
        }
    }

    public function getPackages($cod) {
        $sql = 'SELECT * FROM packages WHERE codigo = "' . $cod . '" ';
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            foreach ($arrayPackages as $packDB) {
                $objPackages = new bloqueoDTO();

                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));

                $objetosPack[] = $objPackages;
            }

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function getIncluye($idPRG) {
        $sql = "exec WEB_TraeDetalle '" . $idPRG . "' ";
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosInc = array();
            $arrayIncluye = $this->_db->fetchAll($datos);

            foreach ($arrayIncluye as $incDB) {
                $objIncluye = new incluyeDTO();

                $objIncluye->setCodigo(trim($incDB['codsvr']));
                $objIncluye->setNombre(trim($incDB['nombre']));
                $objIncluye->setCiudad(trim($incDB['ciudadHotel']));
                $objIncluye->setNoches((int) trim($incDB['Noches']));

                $objetosInc[] = $objIncluye;
            }

            return $objetosInc;
        } else {
            return false;
        }
    }

    public function getAdmProgramas($ciudad = 0, $codProg = 0) {
        $and = '';
        $sql = 'SELECT P.id, P.nombre, P.codigo, C.nombre AS nombreC
            FROM h2h_programa P
            JOIN ciudad	C ON (C.codigo = P.Ciudad)
            WHERE ';
        if (!empty($ciudad)) {
            $sql.=' C.nombre = "' . trim($ciudad) . '" ';
            $and = ' AND ';
        }

        if (!empty($codProg)) {
            $sql.=$and . ' P.codigo="' . $codProg . '" ';
        }

        $sql.='ORDER BY P.nombre ASC ';


        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            foreach ($arrayPackages as $packDB) {
                $objPackages = new bloqueoDTO();

                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));
                $objPackages->setId(trim($packDB['id']));
                $objPackages->setCiudad(trim($packDB['nombreC']));

                $objetosPack[] = $objPackages;
            }

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function TS_GET_BLOQUEOS_PROG($sql, $inc = false) {
        //echo $sql; exit;
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            foreach ($arrayPackages as $packDB) {
                $hotel = array();
                $codHotel = array();
                $PA = array();
                $TH = array();
                $codTH = array();
                $cat = array();
                $ciudad = array();
                $incluye = array();
                $valorHab = array();
                $tipoHab = array();

                $objPackages = new bloqueoDTO();

                /* echo "ERROR: " . $packDB['Error']; echo "<br>";
                  echo "Linea: " . $packDB['Linea'];echo "<br>";
                  echo "Mensaje: " . $packDB['Mensaje']; exit; */
                if (trim(isset($packDB['Error']))) {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                } else {
                    $objPackages->setId(trim($packDB['idPRG']));
                    $objPackages->setNombre(trim($packDB['nombrePRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    $objPackages->setTramo(trim($packDB['Tramo']));
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    $objPackages->setNoches(trim($packDB['nochesPRG']));
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    $objPackages->setPrecioDesde(trim($packDB['precio_desde']));

                    $objPackages->setPdhotel(trim($packDB['pdhotel']));//
                    $objPackages->setPdtraslados(trim($packDB['pdtraslados']));//
                    $objPackages->setPdtkt_aereo(trim($packDB['pdtkt_aereo']));//
                    $objPackages->setPdseguro(trim($packDB['pdseguro_viaje']));//
                    
                    $plan = trim(trim($packDB['pdplan_alim'])); 
                    if ($plan === '1') {

                        $plan = 'All Inclusive';
                    }
                    if ($plan === '2') {

                        $plan = 'Media Pension';
                    }
                    if ($plan === '3') {

                        $plan = 'Desayuno';
                    }
                    if ($plan === '4') {

                        $plan = 'Pension Completa';
                    }

                    $objPackages->setPdplan($plan);


                    $ext = Functions::getExtensionImagen(ROOT . 'public' . DS . 'img' . DS . 'programas' . DS . 'upl_' . str_replace(' ', '_', trim($packDB['codigoPRG'])));
                    if ($ext) {
                        $objPackages->setImagen('upl_' . str_replace(' ', '_', trim($packDB['codigoPRG'])) . $ext);
                    } else {
                        $objPackages->setImagen('sin_foto.png');
                    }

                    /* VALOR HABITACION */
                    for ($i = 1; $i <= 3; $i++) {
                        $valorHab[] = trim($packDB['vHab_' . $i]);
                        if (trim($packDB['tipoHab_' . $i]) != '') {
                            $tipoHab[] = str_replace('SGL', ' SINGLE ', 
                                    str_replace('DBL', ' DOBLE ', 
                                    str_replace('TPL', ' TRIPLE ',
                                    str_replace('QUA', ' QUADRUPLE ',
                                    str_replace('DEP', ' DEPARTAMENTO ',
                                    str_replace('CHD', ' CHILD ', 
                                    str_replace('CH2', ' CHILD ', trim($packDB['tipoHab_' . $i]))))))));
                        }
                    }

                    $objPackages->setValorHab($valorHab);
                    $objPackages->setTipoHab($tipoHab);
                    /* VALOR HABITACION */


                    /* HOTELES */
                    for ($i = 1; $i <= 5; $i++) {
                        if (trim($packDB['hotel_' . $i])) {
                            $hotel[] = trim($packDB['hotel_' . $i]);
                            $codHotel[] = trim($packDB['codHotel_' . $i]);
                            $PA[] = trim($packDB['PlanAlimenticio_' . $i]);
                            $TH[] = trim($packDB['TipoHabitacion_' . $i]);
                            $codTH[] = trim($packDB['codTipoHabitacion_' . $i]);
                            $cat[] = trim($packDB['cat_' . $i]);
                            $ciudad[] = trim($packDB['ciudad_' . $i]);
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

                    if ($inc) {
                        $incluye[] = $this->getIncluye(trim($packDB['idPRG']));
                        $objPackages->setIncluye($incluye);
                    }
                    //$objPackages->setXXXX(trim($packDB['xxxxx']));
                }

                $objetosPack[] = $objPackages;
                //sleep(1);
            }

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function TS_GET_BLOQUEOS_PROG_DETALLE($sql, $inc = false) {
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            foreach ($arrayPackages as $packDB) {
                $hotel = array();
                $codHotel = array();
                $PA = array();
                $TH = array();
                $codTH = array();
                $cat = array();
                $ciudad = array();
                $incluye = array();
                $valorHab = array();
                $tipoHab = array();
                $planAli = array();


                $objPackages = new bloqueoDTO();

                /* echo "ERROR: " . $packDB['Error']; echo "<br>";
                  echo "Linea: " . $packDB['Linea'];echo "<br>";
                  echo "Mensaje: " . $packDB['Mensaje']; exit; */
                if (trim(isset($packDB['Error']))) {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                } else {
                    $objPackages->setId(trim($packDB['idPRG']));
                    $objPackages->setCodigo(trim($packDB['codigoPRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    $objPackages->setTramo(trim($packDB['Tramo']));
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    $objPackages->setRecordC(trim($packDB['record_c']));
                    $objPackages->setNoches(trim($packDB['nochesPRG']));


                    if (file_exists(ROOT . 'public' . DS . 'pdf' . DS . 'upl_' . str_replace(' ', '_', trim($packDB['codigoPRG'])) . '.pdf')) {
                        $objPackages->setPDF(BASE_URL . 'public/pdf/upl_' . str_replace(' ', '_', trim($packDB['codigoPRG'])) . '.pdf');
                        //$objPackages->setPDF(trim($packDB['codigoPRG']));
                    } else {
                        $objPackages->setPDF('');
                    }



                    /* VALOR HABITACION */
                    for ($i = 1; $i <= 3; $i++) {
                        $valorHab[] = trim($packDB['vHab_' . $i]);
                        if (trim($packDB['tipoHab_' . $i]) != '') {
                            $tipoHab[] = str_replace('SGL', ' SINGLE ', 
                                    str_replace('DBL', ' DOBLE ', 
                                    str_replace('TPL', ' TRIPLE ', 
                                    str_replace('QUA', ' QUADRUPLE ',
                                    str_replace('DEP', ' DEPARTAMENTO ',
                                    str_replace('CHD', ' CHILD ', 
                                    str_replace('CH2', ' CHILD ', trim($packDB['tipoHab_' . $i]))))))));
                        }
                    }

                    $objPackages->setValorHab($valorHab);
                    $objPackages->setTipoHab($tipoHab);
                    /* VALOR HABITACION */


                    /* HOTELES */
                    for ($i = 1; $i <= 5; $i++) {
                        if (trim($packDB['hotel_' . $i])) {
                            $hotel[] = trim($packDB['hotel_' . $i]);
                            $codHotel[] = trim($packDB['codHotel_' . $i]);
                            $PA[] = trim($packDB['PlanAlimenticio_' . $i]);
                            $TH[] = trim($packDB['TipoHabitacion_' . $i]);
                            $codTH[] = trim($packDB['codTipoHabitacion_' . $i]);
                            $cat[] = trim($packDB['cat_' . $i]);
                            $ciudad[] = trim($packDB['ciudad_' . $i]);
                            $planAli[] = trim($packDB['PlanAlimenticio_' . $i]);
                        }
                    }

                    $objPackages->setHoteles($hotel);
                    $objPackages->setCodHoteles($codHotel);
                    $objPackages->setPA($PA);
                    $objPackages->setTH($TH);
                    $objPackages->setCodTH($codTH);
                    $objPackages->setCat($cat);
                    $objPackages->setCiudad($ciudad);
                    $objPackages->setPlanAL($planAli);
                    /* HOTELES */

                    if ($inc) {
                        $incluye[] = $this->getIncluye(trim($packDB['idPRG']));
                        $objPackages->setIncluye($incluye);
                    }
                    //$objPackages->setXXXX(trim($packDB['xxxxx']));
                }

                $objetosPack[] = $objPackages;
                //sleep(1);
            }

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function TS_GET_BLOQUEOS_PROG_ID($sql, $inc = false) {
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            foreach ($arrayPackages as $packDB) {
                $hotel = array();
                $codHotel = array();
                $PA = array();
                $TH = array();
                $codTH = array();
                $cat = array();
                $ciudad = array();
                $incluye = array();
                $valorHab = array();
                $tipoHab = array();


                $objPackages = new bloqueoDTO();

                /* echo "ERROR: " . $packDB['Error']; echo "<br>";
                  echo "Linea: " . $packDB['Linea'];echo "<br>";
                  echo "Mensaje: " . $packDB['Mensaje']; exit; */
                if (trim(isset($packDB['Error']))) {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMSG(trim($packDB['Mensaje']));
                } else {
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
                    $objPackages->setNoches(trim($packDB['nochesPRG']));

                    /* VALOR HABITACION */
                    for ($i = 1; $i <= 3; $i++) {
                        $valorHab[] = trim($packDB['vHab_' . $i]);
                        if (trim($packDB['tipoHab_' . $i]) != '') {
                            $tipoHab[] = str_replace('SGL', ' SINGLE ', 
                                    str_replace('DBL', ' DOBLE ', 
                                    str_replace('TPL', ' TRIPLE ', 
                                    str_replace('QUA', ' QUADRUPLE ',
                                    str_replace('DEP', ' DEPARTAMENTO ',
                                    str_replace('CHD', ' CHILD ', 
                                    str_replace('CH2', ' CHILD ', trim($packDB['tipoHab_' . $i]))))))));
                        }
                    }
                    $objPackages->setValorHab($valorHab);
                    $objPackages->setTipoHab($tipoHab);
                    /* VALOR HABITACION */


                    /* HOTELES */
                    for ($i = 1; $i <= 5; $i++) {
                        if (trim($packDB['hotel_' . $i])) {
                            $hotel[] = trim($packDB['hotel_' . $i]);
                            $codHotel[] = trim($packDB['codHotel_' . $i]);
                            $PA[] = trim($packDB['PlanAlimenticio_' . $i]);
                            $TH[] = trim($packDB['TipoHabitacion_' . $i]);
                            $codTH[] = trim($packDB['codTipoHabitacion_' . $i]);
                            $cat[] = trim($packDB['cat_' . $i]);
                            $ciudad[] = trim($packDB['ciudad_' . $i]);
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

                    if ($inc) {
                        $incluye[] = $this->getIncluye(trim($packDB['idPRG']));
                        $objPackages->setIncluye($incluye);
                    }
                }

                $objetosPack[] = $objPackages;
                //sleep(1);
            }

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function getNotaProg($id) {
        $sql = "SELECT REPLACE(convert(varchar(MAX), nota), Char(13), '<br />') as nota "
                . "FROM h2h_Programa WHERE Id=" . $id;

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            $objPackages = new bloqueoDTO();

            $objPackages->setNota(trim($arrayPackages[0]['nota']));
            $objetosPack[] = $objPackages;

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function getItinerarioVuelo($idProg) {
        $sql = 'SELECT P.*, REPLACE(convert(varchar(MAX), notas), Char(13), "<br />") as notas
            FROM bloqueos B 
            JOIN h2h_programaOpc PO ON (B.record_c = PO.record_c)
            JOIN h2h_programa P ON (P.Id = PO.idProg) 
            WHERE P.Id = ' . $idProg;

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            $objPackages = new bloqueoDTO();

            $objPackages->setItiVuelo(trim($arrayPackages[0]['notas']));
            $objetosPack[] = $objPackages;

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function getNotaOpc($idOpc) {
        $sql = "SELECT REPLACE(convert(varchar(MAX), nota), Char(13), '<br />') as nota "
                . "FROM h2h_ProgramaOpc WHERE IdOpc=$idOpc";

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            $objPackages = new bloqueoDTO();

            $objPackages->setNotaOpc(trim($arrayPackages[0]['nota']));
            $objetosPack[] = $objPackages;

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function validaPrograma($id, $idOpc) {
        $sql = 'SELECT P.codigo, P.nombre
            FROM h2h_programaOpc PO
            JOIN h2h_programa P ON (PO.IdProg=P.Id)
            WHERE P.Id=' . $id . ' AND PO.IdOpc=' . $idOpc;

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            $objetosPack = array();
            $arrayPackages = $this->_db->fetchAll($datos);

            $objPackages = new bloqueoDTO();

            $objPackages->setCodigo(trim($arrayPackages[0]['codigo']));
            $objPackages->setNombre(trim($arrayPackages[0]['nombre']));

            $objetosPack[] = $objPackages;

            return $objetosPack;
        } else {
            return false;
        }
    }

    public function exeSQL($sql) {
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            return $this->_db->fetchAll($datos);
        } else {
            return false;
        }
    }

    public function getChild($idOpcion) {

        $sql = "SELECT echd,echd2 FROM h2h_ProgramaOpc WHERE idOpc = $idOpcion";

        $datos = $this->_db->consulta($sql);

        if ($this->_db->numRows($datos) > 0) {
            $respuesta = $this->_db->fetchAll($datos);
            $CH = new bloqueoDTO();
            foreach ($respuesta as $r) {
                $CH->setChd1(trim($r['echd']));
                $CH->setChd2(trim($r['echd2']));
            }
            return $CH;
        }
        return false;
    }

    public function H2H_CREA_FILE($sql) {
        $data = $this->_db->consulta($sql);
        $mensaje = false;
        if ($this->_db->numRows($data)) {
            $mensaje = new bloqueoDTO();
            $datos = $this->_db->fetchAll($data);
            foreach ($datos as $da) {
                $mensaje->setCodigo($da['CODIGO']);
                $mensaje->setMSG($da['MENSAJE']);
                $mensaje->setFile($da['FILE']);
            }
        }
        return $mensaje;
    }

    public function getFile($numFile) {
        $sql = "SELECT * FROM file_ WHERE num_file=$numFile";
        $data = $this->_db->consulta($sql);
        if ($this->_db->numRows($data) > 0) {
            return true;
        } else {

            return false;
        }
    }

    public function codigosProg($idProg, $idBloq) {
        $sql = 'SELECT TOP 1 P.codigo, PO.record_c
                FROM h2h_programaOpc PO
                JOIN h2h_programa P ON (P.Id = ' . $idProg . ')
                WHERE PO.IdOpc = ' . $idBloq;
        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {

            $objetosBloqueos = array();
            $arrayCod = $this->_db->fetchAll($datos);
            $objBloq = new bloqueoDTO();

            foreach ($arrayCod as $bloq) {

                $objBloq->setCodigo(trim($bloq['codigo']));
                $objBloq->setRecordC(trim($bloq['record_c']));

                $objetosBloqueos[] = $objBloq;
            }
            return $objetosBloqueos;
        }
        return false;
    }

    public function getDetHot($numFile) {

        $sql = "SELECT  COUNT (*) FROM det_bloq WHERE num_file = $numFile ";

        $dato = $this->_db->consulta($sql);

        if ($this->_db->numRows($dato) > 0) {
            $cantidad = $this->_db->fetchAll($dato);

            return $cantidad[0][0];
        } else {
            return false;
        }
    }

    public function getRecodC($idProg, $IdOpcion) {

        $sql = "SELECT record_c FROM h2h_ProgramaOpc WHERE IdProg =$idProg AND IdOpc=$IdOpcion";
        $id = false;

        $dato = $this->_db->consulta($sql);

        if ($this->_db->numRows($dato)) {

            $id = $this->_db->fetchAll($dato);
        }
        return $id;
    }

}
