<link href="<?php echo $_layoutParams['ruta_css']; ?>custom-theme/jquery-ui-1.10.4.custom.css" rel="stylesheet">

<script>
$(function()
{
    $( "#mL_txtFechaIn" ).datepicker({
        minDate: +1,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        onSelect: function( selectedDate ){
                $( "#mL_txtFechaOut" ).datepicker( "option", "minDate", selectedDate );
        }
    });

    $( "#mL_txtFechaOut" ).datepicker({
        minDate: +1,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        onSelect: function( selectedDate ) {
                $( "#mL_txtFechaIn" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});

</script>

<style>
    .colorText:hover{color: #0088CC; font-size: 13px;}
</style>

<nav id="page-leftbar" role="navigation" style="position:fixed;">

    <!-- BEGIN SIDEBAR MENU -->
    <ul class="acc-menu" id="sidebar">
        
        
        
        <li>
            <a href="javascript:;"><i><img src="<?php echo $_layoutParams['ruta_img']; ?>programa.png" /></i> <span>Programas</span> <span  style="float: right;"><img src="<?php echo $_layoutParams['ruta_img']; ?>down.png" width="12px" /></span></a>
            <ul class="acc-menu">
                <li>
                    <form id="frmBuscarProgramas" method="post" action="<?php echo BASE_URL; ?>system/buscarProgramas">
                     	
                        <select name="mL_txtCiudadDestino" id="mL_txtCiudadDestino" class="form-control" >
                            <option value="0">Seleccione destino</option>
                            <?php 
                            if($this->objCiudades!=false)
                            { 
                                for($i=0; $i<$this->objCiudadesCNT; $i++)
                                {
                                    $mL_codigoCiuPRG= trim($this->objCiudades[$i]->getCodigo());
                                    $mL_nombreCiuPRG= trim($this->objCiudades[$i]->getNombre());
                                    $mL_nombreCiudadPRG = $mL_nombreCiuPRG." (".$mL_codigoCiuPRG.")";

                                    if(Session::get('sess_BP_ciudadDes')==$mL_nombreCiuPRG)
                                    {
                                    ?>
                                        <option value="<?php echo $mL_nombreCiuPRG; ?>" selected="selected"><?php echo $mL_nombreCiudadPRG; ?></option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option value="<?php echo $mL_nombreCiuPRG; ?>"><?php echo $mL_nombreCiudadPRG; ?></option>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        
                     	<table width="100%" id="tblFormBusqueda" style="margin-top:5px;">
                            <tr>
                            	<td width="30%"><span style="padding-left:10px;">Fecha In:</span></td>
                                <td>
                                	<!-- style="background:#d2d3d6;" -->
                                	<input type="text" class="form-control" id="mL_txtFechaIn" name="mL_txtFechaIn" value="<?php echo $this->ML_fechaIni; ?>">
                                </td>
                            </tr>
                            <tr>
                            	<td><span style="padding-left:10px;">Fecha Out:</span></td>
                                <td>
                                	<input type="text" class="form-control" id="mL_txtFechaOut" name="mL_txtFechaOut" value="<?php echo $this->ML_fechaFin; ?>">
                                </td>
                            </tr>
                            
                           <tr>
                            	<td><span style="padding-left:10px;">Hotel:</span></td>
                                <td>
                                	<input class="form-control" type="text" id="mL_txtHotel" name="mL_txtHotel" placeholder="Nombre del hotel" autocomplete="off">
                                </td>
                            </tr>
                            
                            <tr>
                            	<td><span style="padding-left:10px;">Habitaci&oacute;n:</span></td>
                                <td>
                                    <select name="mL_cmbHab_P" id="mL_cmbHab" class="form-control" onchange="habitaciones('ML_tblHab_P', this.value)">
                                        <option value="0">Seleccione</option>
                                        <?php 
                                        for($i=1; $i<=3; $i++)
                                        {
                                            if(Session::get('sess_pBP_cntHab')==$i)
                                            {?>
                                            <option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } 
                                        } ?>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td colspan="2">
                                    
                                    <div id="ML_tblHab_P_1" style="display: <?php if(Session::get('sess_pBP_cntHab') > 0){ echo "block"; }else{ echo "none"; }?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        <tr>
                                          <td>Adultos</td>
                                          <td>
                                          <select name="mL_cmbAdultos_1" id="mL_cmbAdultos_1">
                                            <?php
                                                for($x=1;$x<=6;$x++)
                                                { 
                                                    if(Session::get('sess_pBP_Adl_1') == $x)
                                                    { ?>
                                                    <option selected="selected" value="<?php echo Session::get('sess_pBP_Adl_1'); ?>"><?php echo Session::get('sess_pBP_Adl_1'); ?></option>
                                                    <?php 
                                                  }
                                                  else
                                                  { ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                            <?php }
                                                } ?>
                                          </select>                          </td>
                                          <td>Edad C1</td>
                                          <td>
                                          <select id="mL_edadChild_1_1" name="mL_edadChild_1_1" <?php if(Session::get('sess_pBP_Chd_1')>=1){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_edadChd_1_1') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_edadChd_1_1'); ?>"><?php echo Session::get('sess_pBP_edadChd_1_1'); ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select>
                                          </td>
                                      </tr>
                                        <tr>
                                          <td>Child</td>
                                          <td><select name="mL_child_1" id="mL_child_1" onchange="habilitaEdadChild(this.value,1);">
                                            <?php if(Session::get('sess_pBP_Chd_1') == ""){Session::get('sess_pBP_Chd_1', 0);}
                                                  for($x=0;$x<=2;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_Chd_1') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_Chd_1'); ?>"><?php echo Session::get('sess_pBP_Chd_1'); ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select>
                                          </td>                    	  
                                          
                                          <td>Edad C2</td>
                                          <td><select id="mL_edadChild_2_1" name="mL_edadChild_2_1" <?php if(Session::get('sess_pBP_Chd_1')==2){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_edadChd_2_1') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_edadChd_2_1'); ?>"><?php echo Session::get('sess_pBP_edadChd_2_1'); ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                      </tr>
                                      
                                      
                                        <tr>
                                          <td>Infant</td>
                                          <td colspan="3">
                                          <select name="mL_inf_1" id="mL_inf_1">
                                            <?php if(trim(Session::get('sess_pBP_Inf_1')) == ""){Session::get('sess_pBP_Inf_1', 0);}
                                              for($x=0;$x<=1;$x++){ ?>
                                              <?php if(Session::get('sess_pBP_Inf_1') == $x){ ?>
                                              <option selected="selected" value="<?php echo Session::get('sess_pBP_Inf_1'); ?>"><?php echo Session::get('sess_pBP_Inf_1'); ?></option>
                                              <?php }else{ ?>                          
                                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                              <?php }  } ?>
                                          </select>
                                          </td>                    	  
                                        </tr>
                                      
                                    </table>
                                    </div>      
                                    
                                    
                                    
                                    
                                    
                                    <div id="ML_tblHab_P_2" style="display: <?php if(Session::get('sess_pBP_cntHab') > 1){ echo "block"; }else{ echo "none"; }?>">
                                    <li class="divider"></li>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        <tr>
                                          <td>Adultos</td>
                                          <td>
                                          <select name="mL_cmbAdultos_2" id="mL_cmbAdultos_2">
                                            <?php for($x=1;$x<=6;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_Adl_2') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_Adl_2'); ?>"><?php echo Session::get('sess_pBP_Adl_2'); ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                            <?php }  } ?>
                                          </select>                          </td>
                                          <td>Edad C1</td>
                                          <td><select id="mL_edadChild_1_2" name="mL_edadChild_1_2" <?php if(Session::get('sess_pBP_Chd_2')>=1){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_edadChd_1_2') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_edadChd_1_2'); ?>"><?php echo Session::get('sess_pBP_edadChd_1_2'); ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                      </tr>
                                        <tr>
                                          <td>Child</td>
                                          <td><select name="mL_child_2" id="mL_child_2" onchange="habilitaEdadChild(this.value,2);">
                                            <?php if(trim(Session::get('sess_pBP_Chd_2')) == ""){Session::get('sess_pBP_Chd_2', 0);}
                                                  for($x=0;$x<=2;$x++){ ?>
                                                  <?php if(Session::get('sess_pBP_Chd_2') == $x){ ?>
                                                  <option selected="selected" value="<?php echo Session::get('sess_pBP_Chd_2'); ?>"><?php echo $_SESSION["sess_pBP_Chd_2"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x;  ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>                           
                                          </select>                          </td>                    	  
                                          <td>Edad C2</td>
                                          <td><select id="mL_edadChild_2_2" name="mL_edadChild_2_2" <?php if($_SESSION["sess_pBP_Chd_2"]==2){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_edadChd_2_2"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_edadChd_2_2"]; ?>"><?php echo $_SESSION["sess_pBP_edadChd_2_2"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                      </tr>
                                      
                                      
                                      
                                      
                                      <tr>
                                          <td>Infant</td>
                                          <td colspan="3"><select name="mL_inf_2" id="mL_inf_2">
                                            <?php if(trim($_SESSION["sess_pBP_Inf_2"]) == ""){$_SESSION["sess_pBP_Inf_2"]=0;}
                                                  for($x=0;$x<=1;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_Inf_2"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_Inf_2"]; ?>"><?php echo $_SESSION["sess_pBP_Inf_2"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select>
                                          </td>                    	  
                                      </tr>
                                      
                                    </table>
                                    </div>      
                                    
                                    
                                    
                                    
                                    <div id="ML_tblHab_P_3" style="display: <?php if($_SESSION["sess_pBP_cntHab"] > 2){ echo "block"; }else{ echo "none"; }?>">
                                    <li class="divider"></li>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        <tr>
                                          <td>Adultos</td>
                                          <td>
                                          <select name="mL_cmbAdultos_3" id="mL_cmbAdultos_3">
                                            <?php for($x=1;$x<=6;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_Adl_3"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_Adl_3"]; ?>"><?php echo $_SESSION["sess_pBP_Adl_3"]; ?></option>
                                                  <?php }else{ ?>
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                            <?php }  } ?>
                                          </select></td>
                                          <td>Edad C1</td>
                                          <td><select id="mL_edadChild_1_3" name="mL_edadChild_1_3" <?php if($_SESSION["sess_pBP_Chd_3"]>=1){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_edadChd_1_3"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_edadChd_1_3"]; ?>"><?php echo $_SESSION["sess_pBP_edadChd_1_3"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x;  ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                      </tr>
                                        <tr><td>Child</td>
                                          <td><select name="mL_child_3" id="mL_child_3" onchange="habilitaEdadChild(this.value,3);">
                                            <?php if(trim($_SESSION["sess_pBP_Chd_3"]) == ""){$_SESSION["sess_pBP_Chd_3"]=0;}
                                                  for($x=0;$x<=2;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_Chd_3"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_Chd_3"]; ?>"><?php echo $_SESSION["sess_pBP_Chd_3"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                          
                                          <td>Edad C2</td>
                                          <td><select id="mL_edadChild_2_3" name="mL_edadChild_2_3" <?php if($_SESSION["sess_pBP_Chd_3"]==2){}else{ echo "disabled='disabled'"; }?> >
                                                  <?php for($x=2;$x<=12;$x++){ ?>
                                                  <?php if($_SESSION["sess_pBP_edadChd_2_3"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_edadChd_2_3"]; ?>"><?php echo $_SESSION["sess_pBP_edadChd_2_3"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select></td>
                                      </tr>
                                      
                                      
                                      
                                      
                                      <tr>
                                          <td>Infant</td>
                                          <td colspan="3">
                                          <select name="mL_inf_3" id="mL_inf_3">
                                            <?php if(trim($_SESSION["sess_pBP_Inf_3"]) == "")
                                                  {
                                                      $_SESSION["sess_pBP_Inf_3"]=0; 
                                                  }
                                                      for($x=0;$x<=1;$x++)
                                                      { 
                                                    ?>
                                                  <?php if($_SESSION["sess_pBP_Inf_3"] == $x){ ?>
                                                  <option selected="selected" value="<?php echo $_SESSION["sess_pBP_Inf_3"]; ?>"><?php echo $_SESSION["sess_pBP_Inf_3"]; ?></option>
                                                  <?php }else{ ?>                          
                                                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                  <?php }  } ?>
                                          </select>
                                          </td>                    	  
                                      </tr>
                                    </table>
                                    </div>
                                    
                                    
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td colspan="2" align="right">
                                	<input type="button"  id="btnBuscarProgramas" class="btn btn-primary" style="margin-right:5px" value="Buscar">
                                </td>
                            </tr>
                        </table>

            </form>
                </li>
            </ul>
        </li>
        
        
        <li class="divider"></li>
        
        
        <?php if(Session::accesoView('Admin')){ ?>
        <li <?php if($this->currentMenu==1){ ?>class="active"<?php } ?>>
            <a id="menuConsRes" href="javascript:;">
                <i><img src="<?php echo $_layoutParams['ruta_img']; ?>right.png" width="12px" /></i>
                <span>Consultar Reserva</span>
            </a>
        </li>
        <?php } ?>
        

        <?php if(Session::accesoView('Admin')){ ?>
        <li <?php if($this->currentMenu==2 || $this->currentMenu==3 || $this->currentMenu==4){ ?>class="open active hasChild"<?php } ?>>
            <a href="javascript:;">
                <i>&nbsp;</i>
                <span>Administraci&oacute;n</span> <span  style="float: right;"><img src="<?php echo $_layoutParams['ruta_img']; ?>down.png" width="12px" /></span>
            </a>
            <ul class="acc-menu" <?php if($this->currentMenu==2 || $this->currentMenu==3 || $this->currentMenu==4){ ?>style="display: block;"<?php } ?>>
                <li <?php if($this->currentMenu==2){ ?>class="active"<?php } ?>><a id="menuHoteles" href="javascript:;"><span>Hoteles</span></a></li>
                <li <?php if($this->currentMenu==3){ ?>class="active"<?php } ?>><a id="menuAdminProg" href="javascript:;"><span>Programas</span></a></li>
                <li <?php if($this->currentMenu==4){ ?>class="active"<?php } ?>><a id="menuImagenes" href="javascript:;"><span>Logo Clientes</span></a></li>
            </ul>
        </li>
        <?php } ?>
        
        
        <?php if(Session::accesoView('Admin')){ ?>
        <li <?php if($this->currentMenu==5){ ?>class="active"<?php } ?>>
            <a id="menuContacto" href="javascript:;">
                <i><img src="<?php echo $_layoutParams['ruta_img']; ?>right.png" width="12px" /></i>
                <span>Cont&aacute;ctenos</span>
            </a>
        </li>
        <?php } ?>
        
    </ul>
    <!-- END SIDEBAR MENU -->

</nav>

<div class="ui-pnotify " id="divAlertExito" style="width: 300px; right: 25px; top: 25px; opacity: 1; display: none; cursor: auto;">
	<div class="alert ui-pnotify-container alert-success ui-pnotify-shadow" style="min-height: 16px;">
        <h4 class="ui-pnotify-title">Terminado</h4>
		<div class="ui-pnotify-text"><img src="<?php echo $_layoutParams['ruta_img']; ?>ok.png" width="32" border="0" /> Proceso realizado con &eacute;xito.</div>
    </div>
</div>

<div class="ui-pnotify " id="divAlertWar" style="width: 300px; right: 25px; top: 25px; opacity: 1; display: none; cursor: auto;">
	<div class="alert ui-pnotify-container alert-danger ui-pnotify-shadow" style="min-height: 16px;">
        <h4 class="ui-pnotify-title">&iexcl;Atenci&oacute;n!</h4>
        <div class="ui-pnotify-text" id="mensajeWar"></div>
    </div>
</div>

<div class="ui-pnotify " id="divAlertInfo" style="width: 300px; right: 25px; top: 25px; opacity: 1; display: none; cursor: auto;">
	<div class="alert ui-pnotify-container alert-info ui-pnotify-shadow" style="min-height: 16px;">
        <div class="ui-pnotify-text">
        	<span class="fa fa-spin"><img src="<?php echo $_layoutParams['ruta_img']; ?>loading.png" width="32" border="0" /></span> Procesando, espere un momento.</div>
    </div>
</div>




