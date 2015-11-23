<?php

/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 10 de octubre de 2014
 */



$pRP_error=false;
$pRP_sqlDetalle=null;

$pRP_sqlDetalle="exec TS_BLOQUEOS_CREA_FILE '".Session::get('sess_id_agen')."', '".Session::get('sess_clave_usuario')."', "; 

//echo str_replace('TS_GET_BLOQUEOS_PROG', 'TS_GET_BLOQUEOS_PROG_ALL', Session::get('sess_sql_TraeProg')); exit;
$pRP_var_getProgramas= $programa->exeSQL(str_replace('TS_GET_BLOQUEOS_PROG', 'TS_GET_BLOQUEOS_PROG_ALL', Session::get('sess_sql_TraeProg')));

if($pRP_var_getProgramas)
{
    foreach($pRP_var_getProgramas as $pRP_columPRG)
    {
        $pRP_nombrePRG= trim($pRP_columPRG["nombrePRG"]);
        if(!empty($pRP_nombrePRG) && trim($pRP_columPRG["idPRG"])==Session::get('sessRP_idPrograma'))
        {   //PROGRAMAS
            $pRP_codigoPRG= trim($pRP_columPRG["codigoPRG"]);
        }
        else
        {   //OPCIONES
            if(trim($pRP_columPRG["idOpcion"])==Session::get('sessRP_rdbOpc'))
            {
                //$pRP_fechaSalida= str_replace('/', '-', trim($pRP_columPRG["desde"]));
                $pRP_fechaSalida= Functions::invertirFecha(trim($pRP_columPRG["desde"]), '/', '-');
                $pRP_clave= trim($pRP_columPRG["clave"]);
                $pRP_codBloqueo= trim($pRP_columPRG["record_c"]);

                $pRP_sqlDetalle.="'".$pRP_fechaSalida."', '".$pRP_codigoPRG."', '".$pRP_codBloqueo."'";
                $pRP_vHab_1_Row= trim($pRP_columPRG["vHab_1"]);
                $pRP_vHab_2_Row= trim($pRP_columPRG["vHab_2"]);
                $pRP_vHab_3_Row= trim($pRP_columPRG["vHab_3"]);


                $tipoHab_Row[0]= trim($pRP_columPRG["tipoHab_1"]);
                if(trim($pRP_columPRG["tipoHab_2"])!=''){ $tipoHab_Row[1]= trim($pRP_columPRG["tipoHab_2"]); $cantidadVHAB=1;}
                if(trim($pRP_columPRG["tipoHab_3"])!=''){ $tipoHab_Row[2]= trim($pRP_columPRG["tipoHab_3"]); $cantidadVHAB=2;}	

                if(!empty($tipoHab_Row[2]))
                {
                    $vHab_rowEnv= $tipoHab_Row[0]."&&".$tipoHab_Row[1]."&&".$tipoHab_Row[2];
                }
                else if(!empty($tipoHab_Row[1]))
                {
                    $vHab_rowEnv= $tipoHab_Row[0]."&&".$tipoHab_Row[1];
                }
                else
                {
                    $vHab_rowEnv= $tipoHab_Row[0];
                } 




                $pRP_monedaSP= trim($pRP_columPRG["moneda"]);
                //$pRP_monedaSPView= $functions->formatoMoneda($pRP_monedaSP);

                $pRP_totalVenta= ($pRP_vHab_1_Row+$pRP_vHab_2_Row+$pRP_vHab_3_Row);
                //$pRP_valorOpcionView= $functions->formatoValor($pRP_monedaSP, $pRP_valorOpcion);


                for($i=0; $i<5; $i++)
                {
                    $pRP_arrayHotelesOpcion[$i]=NULL;
                }

                $pRP_cntHoteles=0;
                for($i=0; $i<5; $i++)
                {
                    if(trim($pRP_columPRG["hotel_".($i+1)])!='')
                    {
                        ++$pRP_cntHoteles;

                        $pRP_sqlDetalle.=", '".trim($pRP_columPRG["codHotel_".($i+1)])."', 
                        '".Functions::invertirFecha(trim($pRP_columPRG["fechaIn_".($i+1)]), '/', '-')."', 
                        '".trim($pRP_columPRG["noches_".($i+1)])."', 
                        '".trim($pRP_columPRG["codTipoHabitacion_".($i+1)])."', 
                        '".trim($pRP_columPRG["codPlanAlimenticio_".($i+1)])."', 
                        '".trim($pRP_columPRG["convenio_".($i+1)])."' ";
                    }
                    else
                    {
                        $pRP_sqlDetalle.=", '', '', '', '', '', '' ";
                    }
                }
            }
        }
    }
}
else
{
    $pRP_error=true;
    $pRP_msg='Ha ocurrido un erro al momento de reservar [pRP 1]';
}






$pRP_sqlDetalle.=", '".Session::get("sess_BP_cntHab")."', '".Session::get("sess_BP_Adl_1")."', '".Session::get("sess_BP_Chd_1")."', '".Session::get("sess_BP_Inf_1")."' ";


if(Session::get("sess_BP_cntHab")==3)
{
    $pRP_sqlDetalle.=", '".Session::get("sess_BP_Adl_2")."', '".Session::get("sess_BP_Chd_2")."', '".Session::get("sess_BP_Inf_2")."', 
                                        '".Session::get("sess_BP_Adl_3")."', '".Session::get("sess_BP_Chd_3")."', '".Session::get("sess_BP_Inf_3")."' ";
}
else if(Session::get("sess_BP_cntHab")==2)
{
    $pRP_sqlDetalle.=", '".Session::get("sess_BP_Adl_2")."', '".Session::get("sess_BP_Chd_2")."', '".Session::get("sess_BP_Inf_2")."', '0', '0', '0' ";
}
else
{
    $pRP_sqlDetalle.=", '0', '0', '0', '0', '0', '0' ";
}




//atipo - Moneda
$pRP_sqlDetalle.=", 'E', '".$pRP_monedaSP."' ";







//MAXIMO 10 PASAJEROS
for($i=1; $i<=10; $i++)
{
    if($i<Session::get('sessRP_cntPasajeros'))
    {
        $pRP_apellidoPAS= trim($_POST['rP_txtApe_'.$i]);
        $pRP_nombrePAS= trim($_POST['rP_txtNom_'.$i]);
        $pRP_rutPAS= trim($_POST['rP_txtRut_'.$i]);
        $pRP_tipoPAS= trim($_POST['rP_cmbTipoPax_'.$i]);
        $pRP_tratoPAS= trim($_POST['rP_cmbTratoPax_'.$i]);
        $pRP_tratoPAS= Functions::tratoPax($pRP_tratoPAS);

        $pRP_fechaNacPAS= trim($_POST['rP_FechaNac_'.$i]);

        if(empty($pRP_rutPAS))
        {
            throw new Exception('Debe ingresar un rut para el pasajero ['.$i.']');
        }
        else if(empty($pRP_nombrePAS))
        {
            throw new Exception('Debe ingresar un nombre para el pasajero ['.$i.']');
        }
        else if(empty($pRP_apellidoPAS))
        {
            throw new Exception('Debe ingresar un apellido para el pasajero ['.$i.']');
        }
        else if($pRP_tipoPAS=='C' && empty($pRP_fechaNacPAS))
        {
            throw new Exception('Debe ingresar la fecha de nacimiento del pasajero ['.$i.']');
        }

        if(!empty($pRP_fechaNacPAS))
        {
            //$pRP_fechaNacPAS= Functions::invertirFecha($pRP_fechaNacPAS, '/', '-');
            $pRP_fechaNacPAS= str_replace('/', '-', $pRP_fechaNacPAS);
        }

        if($this->getTexto('rP_txtRutInf_'.$i)){
            $pRP_rutINF= trim($_POST['rP_txtRutInf_'.$i]);
            $pRP_nomINF= trim($_POST['rP_txtNomInf_'.$i]);
            $pRP_apeINF= trim($_POST['rP_txtApeInf_'.$i]);
            if(trim($_POST['rP_FechaNacInf_'.$i])!='') {
                //$pRP_nacINF= Functions::invertirFecha(trim($_POST['rP_FechaNacInf_'.$i]), '/', '-');
                $pRP_nacINF= str_replace('/', '-', trim($_POST['rP_FechaNacInf_'.$i]));
            } else {
                throw new Exception('Debe ingresar la fecha de nacimiento del infant ['.$i.']');
            }
            
        } else {
            $pRP_rutINF= '';
            $pRP_nomINF= '';
            $pRP_apeINF= '';
            $pRP_nacINF='';
        }

        $pRP_sqlDetalle.=", '".$pRP_apellidoPAS."/".$pRP_nombrePAS."', '".$pRP_rutPAS."', '".$pRP_fechaNacPAS."', '".$pRP_tipoPAS."', '".$pRP_apeINF." ".$pRP_nomINF."', '".$pRP_rutINF."', '".$pRP_nacINF."', '".$pRP_tratoPAS."' ";	

    }
    else
    {
        $pRP_sqlDetalle.=", '', '', '', '', '', '', '', '' ";
    }
}








//Separador && 
$tempTiposHab=NULL;
for($i=0; $i<3; $i++)
{
    $tempTiposHab= explode("&&", trim($vHab_rowEnv));
    if(!empty($tempTiposHab[$i]))
    {
        $pRP_sqlDetalle.= ", '".$tempTiposHab[$i]."'"; 
    }
    else
    {
        $pRP_sqlDetalle.= ", ''"; 
    }
}


$pRP_areaComentario= trim($_POST['rP_txtComentario']);


$pRP_sqlDetalle.=", '".$pRP_clave."', '".$pRP_areaComentario."', '".$pRP_totalVenta."'";




if($this->getTexto('QA') == 'OK') {
    echo $pRP_sqlDetalle; exit;
}
//echo $pRP_sqlDetalle; exit;



//echo 'OK&192966&BL14IPC02A&2014IPC028';	exit;

$pRP_procesaReserva= $programa->exeSQL($pRP_sqlDetalle);
if($pRP_procesaReserva)
{
    foreach($pRP_procesaReserva as $pRP_rsReserva)
    {
        $pRP_codigo= trim($pRP_rsReserva["CODIGO"]);
        $pRP_mensaje= trim($pRP_rsReserva["MENSAJE"]);
        $pRP_file= trim($pRP_rsReserva["FILE"]);
    }
}

if($pRP_codigo==1)
{
    $n_file = $pRP_file;
    $cod_prog= $pRP_codigoPRG;
    $cod_bloq= $pRP_codBloqueo;
}
else
{
    $pRP_mensaje= addslashes($pRP_mensaje); 
    $pRP_error=true;
    $pRP_msg='Error al realizar su reserva. <br />[<b>Codigo</b>: '.$pRP_codigo.'] <br />[<b>Mensaje</b>: '.$pRP_mensaje.'] <br />[<b>N&deg; File</b>: '.$pRP_file.'] ';
}




/*if($pRP_error==TRUE)
{
    echo $pRP_msg;
}
else
{
    echo 'OK' . '&' . $pRP_file . '&' . $pRP_codigoPRG . '&' . $pRP_codBloqueo;
}*/
//echo 'OK' . '&' . '190306' . '&' . 'CH14FLN01-2' . '&' . '2014FLN019';