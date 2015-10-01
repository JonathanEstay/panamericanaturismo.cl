<?php

/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 30 de septiembre de 2015
 */
$sql =null;
$error=false;
$CodOpOris='';

if(Session::get('sessRP_idPrograma')){
    $sql="exec H2H_CREA_FILE '".Session::get('sessRP_idPrograma')."'";
    if(Session::get('sessRP_rdbOpc')){
        $sql.=",'".Session::get('sessRP_rdbOpc')."'";
        
        $pRP_areaComentario= trim($_POST['rP_txtComentario']);
        
        $sql.=",'".$pRP_areaComentario."','".Session::get('sess_BP_fechaIn')."','".Session::get('sess_id_agen')."'";/*consultar id_agent*/
        
        $sql .=",'".$CodOpOris."','".Session::get("sess_BP_cntHab")."','".Session::get("sess_BP_Adl_1")."'";
        
        $sql.=",'".Session::get('sess_BP_edadChd_1_1')."','".Session::get('sess_BP_edadChd_2_1')."','".Session::get("sess_BP_Inf_1")."'";
        
        if(Session::get("sess_BP_cntHab")==3){
        
         $sql.=",'".Session::get("sess_BP_Adl_2")."','".Session::get('sess_BP_edadChd_2_1')."','".Session::get('sess_BP_edadChd_2_2')."'";   
         
         $sql.=",'".Session::get("sess_BP_Inf_2")."','".Session::get("sess_BP_Adl_3")."','".Session::get('sess_BP_edadChd_3_1')."'";
         
         $sql.=",'".Session::get('sess_BP_edadChd_3_2')."','".Session::get("sess_BP_Inf_3")."'";
        }
        else if(Session::get("sess_BP_cntHab")==2){
            
            $sql.=",'".Session::get("sess_BP_Adl_2")."','".Session::get('sess_BP_edadChd_2_1')."','".Session::get('sess_BP_edadChd_2_2')."'";
            
             $sql.=",'".Session::get("sess_BP_Inf_2")."','0','0','0','0'";
        }
        else{
           $sql.=",'0','0','0','0','0','0','0','0'";
        }
        
    }
    else
    {
        $error = true;
        $pRP_msg='no existe esa opcion de programa';
    }
}
else
{
    $error = true;
    $pRP_msg='no existe ese programa';
}

