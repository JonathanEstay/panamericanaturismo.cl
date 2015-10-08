<link href="<?php echo $_layoutParams['ruta_css']; ?>custom-theme/jquery-ui-1.10.4.custom.css" rel="stylesheet">





<?php if(!Session::get('sess_boton_pago')){ ?>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3GrwTVHvNgcEpC5lvfgFxUDY8oYw9THy";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
<?php } ?>




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
    
    
    <?php if(!WEB) { ?>
    
    $( "#mL_txtFechaIn_PRG" ).datepicker({
        minDate: +1,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
        firstDay: 1
    });
    <?php } ?>
});

</script>

<style>
    .colorText:hover{color: #0088CC; font-size: 13px;}
</style>

<nav id="page-leftbar" role="navigation" >

    
     <?php if(Session::get('sess_iframe')){$sty_tc=""; } else { $sty_tc="margin-top:55px;"; } ?>
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="acc-menu" id="sidebar" style="list-style:none; <?php echo $sty_tc; ?>">
        
        
        
        <li <?php if($this->currentMenu == 11){ echo 'class="hasChild open"'; } ?>>
            <a href="javascript:;"><i><img src="<?php echo $_layoutParams['ruta_img']; ?>bloqueo.png" /></i> <span>Bloqueos</span> <span  style="float: right;"><img src="<?php echo $_layoutParams['ruta_img']; ?>down.png" width="12px" /></span></a>
            <ul class="acc-menu" style="<?php if($this->currentMenu == 11){ echo 'display: block;'; }else{ echo 'display: none;'; } ?>">
                <li style="max-height: 500px; overflow-y: scroll;">
                    <form id="frmBuscarBloqueos" method="post" action="<?php echo BASE_URL; ?>bloqueos/buscar/<?php echo $this->form;?>">
                     	
                        <select name="mL_txtCiudadDestino" id="mL_txtCiudadDestino" class="form-control" onchange="actualizaSalidas();">
                            <option value="0">Seleccione destino</option>
                            <?php 
                            if($this->objCiudades)
                            { 
                                foreach($this->objCiudades as $objCiu)
                                {
                                    //$mL_codigoCiuPRG= trim($this->objCiudades[$i]->getCodigo());
                                    $mL_nombreCiuPRG= $objCiu->getNombre();
                                    //$mL_nombreCiudadPRG = $mL_nombreCiuPRG." (".$mL_codigoCiuPRG.")";

                                    if(Session::get('sess_BP_ciudadDes')==$mL_nombreCiuPRG)
                                    {
                                    ?>
                                        <option value="<?php echo $mL_nombreCiuPRG; ?>" selected="selected"><?php echo $mL_nombreCiuPRG; ?></option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option value="<?php echo $mL_nombreCiuPRG; ?>"><?php echo $mL_nombreCiuPRG; ?></option>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        
                     	<table width="100%" id="tblFormBusqueda" style="margin-top:5px;">
                            <tr>
                            	<td width="30%"><span style="padding-left:10px;">Salidas:</span></td>
                                <td>
                                    <select name="mL_cmbSalidas" id="mL_cmbSalidas" class="form-control" >
                                        <option value="0">Seleccione</option>
                                        <?php 
                                        /*if($this->objCiudades)
                                        { 
                                            foreach($this->objCiudades as $objCiu)
                                            {
                                                //$mL_codigoCiuPRG= trim($this->objCiudades[$i]->getCodigo());
                                                $mL_nombreCiuPRG= $objCiu->getNombre();
                                                //$mL_nombreCiudadPRG = $mL_nombreCiuPRG." (".$mL_codigoCiuPRG.")";

                                                if(Session::get('sess_BP_ciudadDes')==$mL_nombreCiuPRG)
                                                {
                                                ?>
                                                    <option value="<?php echo $mL_nombreCiuPRG; ?>" selected="selected"><?php echo $mL_nombreCiuPRG; ?></option>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                    <option value="<?php echo $mL_nombreCiuPRG; ?>"><?php echo $mL_nombreCiuPRG; ?></option>
                                                <?php
                                                }
                                            }
                                        }*/
                                        ?>
                                    </select>
                                    <input type="hidden" maxlength="10" class="form-control" id="mL_txtFechaIn" name="mL_txtFechaIn" value="<?php echo $this->ML_fechaIni; ?>">
                                    <input type="hidden" maxlength="10" class="form-control" id="mL_txtFechaOut" name="mL_txtFechaOut" value="<?php echo $this->ML_fechaFin; ?>">
                                </td>
                            </tr>
                            <!-- <tr>
                            	<td><span style="padding-left:10px;">Fecha Out:</span></td>
                                <td>
                                     
                                </td>
                            </tr> -->
                            
                           <!-- <tr>
                            	<td><span style="padding-left:10px;">Hotel:</span></td>
                                <td>
                                    <input class="form-control" type="text" id="mL_txtHotel" name="mL_txtHotel" placeholder="Nombre del hotel" autocomplete="off">
                                </td>
                            </tr> -->
                            
                            <tr>
                            	<td><span style="padding-left:10px;">Habitaci&oacute;n:</span></td>
                                <td>
                                    <select name="mL_cmbHab" id="mL_cmbHab" class="form-control" onchange="habitaciones('ML_tblHab_B', this.value)">
                                        <option value="0">Seleccione</option>
                                        <?php 
                                        for($i=1; $i<=3; $i++)
                                        {
                                            if(Session::get('sess_BP_cntHab')==$i)
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
                                    
                                    
                                    
                                    <?php for($i=1; $i<=3; $i++)
                                    {
                                        $display='display:none;';
                                        if(Session::get('sess_BP_cntHab')>=$i){ $display= 'display:block;'; }?>
                                    <div id="ML_tblHab_B_<?php echo $i; ?>" style="<?php echo $display; ?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td>Adultos</td>
                                                <td>
                                                    <select name="mL_cmbAdultos_<?php echo $i; ?>" id="mL_cmbAdultos_<?php echo $i; ?>">
                                                      <?php
                                                          for($x=1; $x<=6; $x++)
                                                          { 
                                                              if(Session::get('sess_BP_Adl_' . $i) == $x)
                                                              { ?>
                                                              <option selected="selected" value="<?php echo Session::get('sess_BP_Adl_' . $i); ?>"><?php echo Session::get('sess_BP_Adl_' . $i); ?></option>
                                                              <?php 
                                                            }
                                                            else
                                                            { ?>                          
                                                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                      <?php }
                                                          } ?>
                                                    </select>                          
                                                </td>
                                                <td>Edad 1</td>
                                                <td>
                                                    <select id="mL_edadChild_1_<?php echo $i; ?>" name="mL_edadChild_1_<?php echo $i; ?>" <?php if(Session::get('sess_BP_Chd_' . $i)>=1){}else{ echo "disabled='disabled'"; }?> >
                                                    <?php
                                                    for($x=2;$x<=12;$x++)
                                                    {
                                                        if(Session::get('sess_BP_edadChd_1_' . $i) == $x)
                                                        {?>
                                                    <option selected="selected" value="<?php echo Session::get('sess_BP_edadChd_1_' . $i); ?>"><?php echo Session::get('sess_BP_edadChd_1_' . $i); ?></option>
                                                    <?php
                                                        }
                                                        else
                                                        {?>                          
                                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                    <?php }  
                                                    } ?>
                                                    </select>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Ni&ntilde;os</td>
                                                <td>
                                                    <select name="mL_child_<?php echo $i; ?>" id="mL_child_<?php echo $i; ?>" onchange="habilitaEdadChild(this.value, <?php echo $i; ?>, 'mL_edadChild');">
                                                    <?php 
                                                        for($x=0; $x<=2; $x++)
                                                        {
                                                            if(Session::get('sess_BP_Chd_' . $i) == $x)
                                                            {?>
                                                        <option selected="selected" value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                        <?php }else{ ?>                          
                                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                        <?php }
                                                        }?>
                                                    </select>
                                                </td>                    	  

                                                <td>Edad 2</td>
                                                <td>
                                                    <select id="mL_edadChild_2_<?php echo $i; ?>" name="mL_edadChild_2_<?php echo $i; ?>" <?php if(Session::get('sess_BP_Chd_' . $i)==2){}else{ echo "disabled='disabled'"; }?> >
                                                        <?php
                                                        for($x=2; $x<=12; $x++)
                                                        {
                                                            if(Session::get('sess_BP_edadChd_2_' . $i) == $x)
                                                            { ?>
                                                        <option selected="selected" value="<?php echo Session::get('sess_BP_edadChd_2_' . $i); ?>"><?php echo Session::get('sess_BP_edadChd_2_' . $i); ?></option>
                                                        <?php }else{ ?>                          
                                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Infant</td>
                                                <td colspan="3">
                                                    <select name="mL_inf_<?php echo $i; ?>" id="mL_inf_<?php echo $i; ?>">
                                                      <?php
                                                        for($x=0; $x<=1; $x++)
                                                        {
                                                            if(Session::get('sess_BP_Inf_' . $i) == $x)
                                                            {?>
                                                        <option selected="selected" value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                        <?php }else{ ?>                          
                                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </td>                    	  
                                            </tr>

                                        </table>
                                        <li class="divider"></li>
                                    </div>      
                                    <?php } ?>
                                    
                                    
                                    
                                    
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td colspan="2" align="right">
                                	<input type="button"  id="btnBuscarBloqueos" class="btn btn-primary" style="margin-right:5px" value="Buscar">
                                </td>
                            </tr>
                        </table>

            </form>
                </li>
            </ul>
        </li>
        
        
        <?php if(!WEB) { ?>
        <!-- OCULTO HASTA PASO A PRODUCCION -->
        <li <?php if($this->currentMenu == 22){ echo 'class="hasChild open"'; } ?>>
            <a href="javascript:;"><i><img src="<?php echo $_layoutParams['ruta_img']; ?>programa.png" /></i> <span>Programas</span> <span  style="float: right;"><img src="<?php echo $_layoutParams['ruta_img']; ?>down.png" width="12px" /></span></a>
            <ul class="acc-menu" style="<?php if($this->currentMenu == 22){ echo 'display: block;'; }else{ echo 'display: none;'; } ?>">
                <li style="max-height: 500px; overflow-y: scroll;">
                    <form id="frmBuscarProgramas" method="post" action="<?php echo BASE_URL; ?>programas/buscar/<?php echo $this->form;?>">
                     	
                        <select name="mL_txtCiudadDestino_PRG" id="mL_txtCiudadDestino_PRG" class="form-control" >
                            <option value="0">Seleccione destino</option>
                            <?php 
                            if($this->objCiudadesPRG) {
                                
                                foreach($this->objCiudadesPRG as $objCiu) {
                                    
                                    //$mL_codigoCiuPRG= trim($this->objCiudades[$i]->getCodigo());
                                    $mL_nombreCiuPRG= $objCiu->getNombre();
                                    //$mL_nombreCiudadPRG = $mL_nombreCiuPRG." (".$mL_codigoCiuPRG.")";

                                    if(Session::get('sess_BP_ciudadDes_PRG')==$objCiu->getCodigo())
                                    {
                                    ?>
                                        <option value="<?php echo $objCiu->getCodigo(); ?>" selected="selected"><?php echo $mL_nombreCiuPRG; ?></option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option value="<?php echo $objCiu->getCodigo(); ?>"><?php echo $mL_nombreCiuPRG; ?></option>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        
                     	<table width="100%" id="tblFormBusqueda" style="margin-top:5px;">
                            <tr>
                            	<td width="40%">Fecha In:</td>
                                <td>
                                    <input type="text" class="form-control" id="mL_txtFechaIn_PRG" name="mL_txtFechaIn_PRG" value="<?php echo $this->ML_fechaIni_PRG; ?>">
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
        <?php } ?>
        
        
        <li class="divider"></li>
        <input type="hidden" id="valPost" name="valPost" value="<?php echo $this->ML_fechaIni_PRG; ?>" >
        
        <!--<?php if(Session::accesoView('Admin')){ ?>
        <li <?php if($this->currentMenu==1){ ?>class="active"<?php } ?>>
            <a id="menuConsRes" href="javascript:;">
                <i><img src="<?php echo $_layoutParams['ruta_img']; ?>buscar.png" width="24px" /></i>
                <span>Consultar Reserva</span>
            </a>
        </li>
        <?php } ?>
        

        <?php if(Session::accesoView('Admin')){ ?>
        <li <?php if($this->currentMenu==2 || $this->currentMenu==3 || $this->currentMenu==4){ ?>class="open active hasChild"<?php } ?>>
            <a href="javascript:;">
                <i><img src="<?php echo $_layoutParams['ruta_img']; ?>adm.png" width="24px" /></i>
                <span>Administraci&oacute;n</span> <span  style="float: right;"><img src="<?php echo $_layoutParams['ruta_img']; ?>down.png" width="12px" /></span>
            </a>
            <ul class="acc-menu" <?php if($this->currentMenu==2 || $this->currentMenu==3 || $this->currentMenu==4){ ?>style="display: block;"<?php } ?>>
                <li <?php if($this->currentMenu==2){ ?>class="active"<?php } ?>><a id="menuHoteles" href="javascript:;"><span>Hoteles</span></a></li>
                <li <?php if($this->currentMenu==3){ ?>class="active"<?php } ?>><a id="menuAdminProg" href="javascript:;"><span>Programas</span></a></li>
                <li <?php if($this->currentMenu==4){ ?>class="active"<?php } ?>><a id="menuImagenes" href="javascript:;"><span>Logo Clientes</span></a></li>
            </ul>
        </li>
        <?php } ?>-->
        
        
        
        
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




<script>
    // cada vez que se cambia el valor del combo
    function actualizaSalidas(){

        // obtenemos el valor seleccionado
        var ciudad = $("#mL_txtCiudadDestino").val();

        // si es 0, no es un país
        
        if(ciudad != 0)
        {
            var datos = {
                ciudad : $("#mL_txtCiudadDestino").val()  
            };
            $.post(BASE_URL_JS + "system/getSalidas", datos, function(ciudades) {

                // obtenemos el combo de ciudades
                var $comboCiudades = $("#mL_cmbSalidas");

                // lo vaciamos
                $comboCiudades.empty();
                
                $comboCiudades.append("<option>Seleccione</option>");
                // iteramos a través del arreglo de ciudades
                $.each(ciudades, function(index, salida) {
                    // agregamos opciones al combo
                    //alert( index + ": " + cuidad );
                    if('<?php echo $this->ML_fechaIni; ?>' == salida){
                        if('<?php echo Session::get('sess_BP_ciudadDes');?>'==ciudad){
                        $comboCiudades.append("<option value='" + salida + "' selected='selected'>" + salida + "</option>");
                    }else{
                        $comboCiudades.append("<option value='" + salida + "'>" + salida + "</option>");
                    }
                    } else {
                        $comboCiudades.append("<option value='" + salida + "'>" + salida + "</option>");
                    }
                    //$comboCiudades.append("<option>" + cuidad.nombre + "</option>");
                });
                
            }, 'json');
        }
        else
        {
            // limpiamos el combo e indicamos que se seleccione un país
            var $comboCiudades = $("#mL_cmbSalidas");
            $comboCiudades.empty();
            $comboCiudades.append("<option>Seleccione</option>");
        }
    }
    
    
    // cada vez que se cambia el valor del combo
    $("#mL_cmbSalidas").change(function() {
        $("#mL_txtFechaIn").val($(this).val());
        $("#mL_txtFechaOut").val($(this).val());
    });
    
    actualizaSalidas();
</script>