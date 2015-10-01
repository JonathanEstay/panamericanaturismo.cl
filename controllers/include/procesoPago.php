<?php

/*
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 30 de septiembre de 2015
 */
$sql = null;
$error = false;
$CodOpOris = '';
$usuario = 'tclub';

if (Session::get('sessRP_idPrograma')) {
    $sql = "exec H2H_CREA_FILE '" . Session::get('sessRP_idPrograma') . "'";
    if (Session::get('sessRP_rdbOpc')) {
        $sql.=",'" . Session::get('sessRP_rdbOpc') . "'";

        $pRP_areaComentario = trim($_POST['rP_txtComentario']);

        $sql.=",'" . $pRP_areaComentario . "','" . Session::get('sess_BP_fechaIn') . "','" . $usuario . "'"; /* consultar id_agent */

        $sql .=",'" . $CodOpOris . "','" . Session::get("sess_BP_cntHab") . "','" . Session::get("sess_BP_Adl_1") . "'";

        $sql.=",'" . Session::get('sess_BP_edadChd_1_1') . "','" . Session::get('sess_BP_edadChd_2_1') . "','" . Session::get("sess_BP_Inf_1") . "'";

        if (Session::get("sess_BP_cntHab") == 3) {

            $sql.=",'" . Session::get("sess_BP_Adl_2") . "','" . Session::get('sess_BP_edadChd_2_1') . "','" . Session::get('sess_BP_edadChd_2_2') . "'";

            $sql.=",'" . Session::get("sess_BP_Inf_2") . "','" . Session::get("sess_BP_Adl_3") . "','" . Session::get('sess_BP_edadChd_3_1') . "'";

            $sql.=",'" . Session::get('sess_BP_edadChd_3_2') . "','" . Session::get("sess_BP_Inf_3") . "'";
        } else if (Session::get("sess_BP_cntHab") == 2) {

            $sql.=",'" . Session::get("sess_BP_Adl_2") . "','" . Session::get('sess_BP_edadChd_2_1') . "','" . Session::get('sess_BP_edadChd_2_2') . "'";

            $sql.=",'" . Session::get("sess_BP_Inf_2") . "','0','0','0','0'";
        } else {
            $sql.=",'0','0','0','0','0','0','0','0'";
        }


        for ($i = 1; $i <= 10; $i++) {

            if ($i < Session::get('sessRP_cntPasajeros')) {

                $pRP_apellidoPAS = trim($_POST['rP_txtApe_' . $i]);
                $pRP_nombrePAS = trim($_POST['rP_txtNom_' . $i]);
                $pRP_rutPAS = trim($_POST['rP_txtRut_' . $i]);
                $pRP_tipoPAS = trim($_POST['rP_cmbTipoPax_' . $i]);
                $pRP_tratoPAS = trim($_POST['rP_cmbTratoPax_' . $i]);
                $pRP_tratoPAS = Functions::tratoPax($pRP_tratoPAS);

                $pRP_fechaNacPAS = trim($_POST['rP_FechaNac_' . $i]);

                if (empty($pRP_rutPAS)) {

                    $error = TRUE;
                    $pRP_msg = 'Debe ingresar un rut para el pasajero [' . $i . ']';
                    break;
                } else if (empty($pRP_nombrePAS)) {

                    $error = TRUE;
                    $pRP_msg = 'Debe ingresar un nombre para el pasajero [' . $i . ']';
                    break;
                } else if (empty($pRP_apellidoPAS)) {

                    $error = TRUE;
                    $pRP_msg = 'Debe ingresar un apellido para el pasajero [' . $i . ']';
                    break;
                } else if ($pRP_tipoPAS == 'C' && empty($pRP_fechaNacPAS)) {

                    $error = TRUE;
                    $pRP_msg = 'Debe ingresar la fecha de nacimiento del pasajero [' . $i . ']';
                    break;
                }

                if (!empty($pRP_fechaNacPAS)) {

                    $pRP_fechaNacPAS = Functions::invertirFecha($pRP_fechaNacPAS, '/', '-');
                }

                if ($this->getTexto('rP_txtRutInf_' . $i)) {
                    $pRP_rutINF = trim($_POST['rP_txtRutInf_' . $i]);
                    $pRP_nomINF = trim($_POST['rP_txtNomInf_' . $i]);
                    $pRP_apeINF = trim($_POST['rP_txtApeInf_' . $i]);
                    $pRP_nacINF = Functions::invertirFecha(trim($_POST['rP_FechaNacInf_' . $i]), '/', '-');
                } else {
                    $pRP_rutINF = '';
                    $pRP_nomINF = '';
                    $pRP_apeINF = '';
                    $pRP_nacINF = '';
                }

                $sql.=",'".$pRP_apellidoPAS."/".$pRP_nombrePAS."', '".$pRP_rutPAS."', '".$pRP_fechaNacPAS."', '".$pRP_tipoPAS."', '".$pRP_apeINF." ".$pRP_nomINF."', '".$pRP_rutINF."', '".$pRP_nacINF."', '".$pRP_tratoPAS."' ";
                
            } else{
                
                $sql.=", '', '', '', '', '', '', '', '' ";
            }
        }
        
        $sql.=",'".Session::get("sess_BP_Precio")."'";
    } else {
        $error = true;
        $pRP_msg = 'error al realizar reserva(codigo 30). Si el error persiste comuniquese con el administrador';
    }
} else {
    $error = true;
    $pRP_msg = 'error al realizar reserva(codigo 31). Si el error persiste comuniquese con el administrador';
}

