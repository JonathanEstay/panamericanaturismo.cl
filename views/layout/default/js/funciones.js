// JavaScript Document
function methodSend(classFrm, php, btn, div) {
    if(typeof FormData === "undefined"){
        procesoEnviaFormIE(classFrm, php, div);
    } else {
        procesoEnviaForm(classFrm, php, btn, div);
    }
}
function valiPostFecha(form){
    
    
    var fecha = $("#mL_txtFechaIn_PRG").val();
    
    $.post(BASE_URL_JS+ CONTROLLER_JS +'/validadPostFe'+form,{fecha:fecha},function(){});
    
}




/*function procesoDetalleProg(classFrm,form)
{
        
        
            form ='/'+form;
        
        
	initLoad();

	$("#divPopupPRG").html("");
	var contentType = false;
        var processData = false;
    
        if(typeof FormData === "undefined"){
            //IE
            var formData = [];
            formData= formularioIE($("."+classFrm)[0]);
            contentType = 'application/x-www-form-urlencoded';
            processData = true;
        } else {
            var formData= new FormData($("."+classFrm)[0]);
        }
        
	//hacemos la peticion ajax  
	$.ajax({
		url: BASE_URL_JS + CONTROLLER_JS + '/detalle'+form,  
		type: 'POST',
		//Form data
		//datos del formulario
		data: formData,
                
		//necesario para subir archivos via ajax
		cache: false,
		contentType: contentType,
		processData: processData,
		//mientras enviamos el archivo
		beforeSend: function(){},
		//una vez finalizado correctamente
		success: function(data)
		{
                    $("#divPopupPRG").html(data);
                    endLoad();
		},
		
		//si ha ocurrido un error
		error: function()
		{
                    $("#divPopupPRG").html("Ha ocurrido un error");
		}
	});
}*/




function procesoEnviaForm(classFrm, php, btn, div)
{
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();
    
    //var formData= new FormData($("."+classFrm)[0]);
    var formData= new FormData(classFrm);
    
    
    //hacemos la peticion ajax  
    $.ajax({
        url: php,  
        type: 'POST',
        //Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){},
        //una vez finalizado correctamente
        success: function(data)
        {
            endLoad();
            if(data==='OK') {
                $("#"+div).delay(1500).queue(function(n)
                {
                    $("#"+div).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Proceso realizado con &eacute;xito.</div>');
                    n();
                });
            } else {	
                $('#mensajeWar').html(data);
                $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                $('#divAlertWar').animate({
                        'display': 'block'
                });

                $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                $('#divAlertWar').animate({
                                            'display': 'none'
                                        });

                $("#"+btn).delay(2000).queue(function(m)
                {
                    $("#"+btn).removeAttr("disabled");
                    m();
                });	
            }
        },

        //si ha ocurrido un error
        error: function()
        {
            endLoad();

            $('#mensajeWar').html('Error error');
            $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });

            $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
            $('#divAlertWar').animate({
                                        'display': 'none'
                                    });
        }
    });
}





/*function procesoReservaPRG(classFrm, php, btn, div,form,urlCon)
{
    form='/'+form;
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();

    for(rP=1; rP>=1; rP++)
    {
        //tipoPas= document.getElementById("tipo_bloq_"+i);
        txtPasaporte= document.getElementById("rP_chkPas_"+rP);
        txtRut= document.getElementById("rP_txtRut_"+rP);
        if(txtRut!=null)
        {
            if(txtPasaporte.checked==false)
            {
                if(txtRut.value.replace(/^\s+|\s+$/g,"")=='')
                {
                    alertError(btn, 'Debe ingresar un rut', 2000);
                    txtRut.focus();
                    return false;
                    break;
                }
                else
                {
                    statusRut= Rut(txtRut, txtRut.value);
                    if(statusRut!=true)
                    {
                        alertError(btn, 'El rut es incorrecto', 2000);
                        txtRut.select();
                        return false;
                        break;
                    }
                }
            }
            else
            {
                if(txtRut.value.replace(/^\s+|\s+$/g,"")=='')
                {
                    alertError(btn, 'Debe ingresar un rut', 2000);
                    txtRut.focus();	
                    return false;
                    break;
                }
            }

            if($.trim($("#rP_txtNom_"+rP).val())=='')
            {
                alertError(btn, 'Debe ingresar un nombre', 2000);
                $("#rP_txtNom_"+rP).focus();
                return false;
                break;
            }

            if($.trim($("#rP_txtApe_"+rP).val())=='')
            {
                alertError(btn, 'Debe ingresar un apellido', 2000);
                $("#rP_txtApe_"+rP).focus();
                return false;
                break;
            }


            if($("#rP_cmbTipoPax_"+rP).val()=='C')
            {
                if($.trim($("#rP_FechaNac_"+rP).val())=='')
                {
                    alertError(btn, 'Debe ingresar una fecha de nacimiento para el Child', 2000);
                    $("#rP_FechaNac_"+rP).focus();
                    return false;
                    break;
                }
            }



            txtPasaporteInf= document.getElementById("rP_chkPasInf_"+rP);
            txtRutInf= document.getElementById("rP_txtRutInf_"+rP);
            if(txtRutInf!=null)
            {
                if(txtPasaporteInf.checked==false)
                {
                    if(txtRutInf.value.replace(/^\s+|\s+$/g,"")=='')
                    {
                        alertError(btn, 'Debe ingresar un rut para el infant', 2000);
                        txtRutInf.focus();	
                        return false;
                        break;
                    }
                    else
                    {
                        statusRutInf= Rut(txtRutInf, txtRutInf.value);
                        if(statusRutInf!=true)
                        {
                            alertError(btn, 'El rut del infant es incorrecto', 2000);
                            txtRutInf.select();
                            return false;
                            break;
                        }
                    }
                }
                else
                {
                    if(txtRutInf.value.replace(/^\s+|\s+$/g,"")=='')
                    {
                        alertError(btn, 'Debe ingresar un rut para el infant', 2000);
                        txtRutInf.focus();	
                        return false;
                        break;
                    }
                }


                if($.trim($("#rP_txtNomInf_"+rP).val())=='')
                {
                    alertError(btn, 'Debe ingresar un nombre para el infant', 2000);
                    $("#rP_txtNomInf_"+rP).focus();
                    return false;
                    break;
                }

                if($.trim($("#rP_txtApeInf_"+rP).val())=='')
                {
                    alertError(btn, 'Debe ingresar un apellido para el infant', 2000);
                    $("#rP_txtApeInf_"+rP).focus();
                    return false;
                    break;
                }



                if($.trim($("#rP_FechaNacInf_"+rP).val())=='')
                {
                    alertError(btn, 'Debe ingresar una fecha de nacimiento para el Infant', 2000);
                    $("#rP_FechaNacInf_"+rP).focus();
                    return false;
                    break;
                }
            }


        }
        else
        {
            break;
        }
    }
	
	
	
	
	
	
    /*Proceso Valida rut*/
    /*var txtRutNew1, txtRutNew2;
    for(x=1; x<rP; x++) {
        txtRutNew1= document.getElementById("rP_txtRut_"+x);
        for(y=1; y<rP; y++) {
            if(x != y) {
                txtRutNew2= document.getElementById("rP_txtRut_"+y);
                if(txtRutNew1.value==txtRutNew2.value) {
                    alertError(btn, 'El rut del pasajero['+x+'] se repite con el del pasajero['+y+'].', 3000);
                    txtRutNew1.select();
                    return false;
                    break;
                }
            }
        }
    }
    /* --- */
	
	
	
	
	
	
    
    
    
   /* var contentType = false;
    var processData = false;

    if(typeof FormData === "undefined"){
        //IE
        var formData = [];
        formData= formularioIE($("."+classFrm)[0]);
        contentType = 'application/x-www-form-urlencoded';
        processData = true;
    } else {
        var formData= new FormData($("."+classFrm)[0]);
    }
	
	
    
   
    //hacemos la petición ajax 
    fadeIn('condicionesPopup');
    $.ajax({
     url:urlCon,
     success:function(data){
            endLoad();
            $("#divPopupCon").html(data);
            $('#aceptarCondiciones').click(function(){
               initLoad();
           if($('#checkCondiciones').is(':checked')){
               fadeOut('condicionesPopup');
               $.ajax({
            url: php+form,  
            type: 'POST',
            //Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: contentType,
            processData: processData,
            //mientras enviamos el archivo
            beforeSend: function(){},
            //una vez finalizado correctamente
            success: function(data)
            {
                $("#checkCondiciones").attr('checked', false);
                var myArrayData= data.split('&');
                if($.trim(myArrayData[0])=='OK')
                {
                    $('#btnCerrar1PRG').delay( 100 ).fadeOut( 100 );
                    $('#btnCerrar1PRG').animate({
                                                'display': 'none'
                                            });
                                            
                    //alert('TODO OK'); return false;
                    
                    $("#"+div).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Estamos abriendo la carta confirmaci&oacute;n, espere un momento...</div>');
                    $.post( BASE_URL_JS + CONTROLLER_JS + "/cartaConfirmacion"+form, 
                    {
                        CR_n_file: myArrayData[1],
                        CR_cod_prog: myArrayData[2],
                        CR_cod_bloq: myArrayData[3]
                        
                    }, function(dataRS)
                    {
                        $("#"+div).html(dataRS);
                        endLoad();

                        $('#btnAceptarPRG').delay( 2000 ).fadeIn( 100 );
                        $('#btnAceptarPRG').animate({
                                'display': 'block'
                        });
                    });
                    
                   

                }
                else
                { 	
                    alertError(btn, data, 5000);
                }
            },

            //si ha ocurrido un error
            error: function()
            {
                endLoad();

                $('#mensajeWar').html('Error error');
                $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                $('#divAlertWar').animate({
                        'display': 'block'
                });

                $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                $('#divAlertWar').animate({
                                            'display': 'none'
                                        });
            }
    });
               
           }else{
               alertError("aceptarCondiciones","Debe aceptar las condiciones",4000);
                        endLoad();
               $("#"+btn).prop('disabled',false);
               
           }
            });
        }
    });
        
    
}*/



function procesoCargaDiv(valor, div, php)
{
    $("#"+div).html('');
    if(valor!==0)
    {
        $.post(php, 
        {
            _PCD_: valor
        }, function(data)
        {
            $("#"+div).html(data);
        });
    }
}






function procesoConServ(classFrm, php, btn)
{
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();


    //alertError(btn, 'Error al tratar de confirmar ', 2000);
    //return false;

    /*for(rP=1; rP>=1; rP++)
    {
        txtPasaporte= document.getElementById("rP_chkPas_"+rP);
        txtRut= document.getElementById("rP_txtRut_"+rP);
        if(txtRut!=null)
        {
            if($.trim($("#rP_txtNom_"+rP).val())=='')
            {
                alertError(btn, 'Debe ingresar un nombre', 2000);
                $("#rP_txtNom_"+rP).focus();
                return false;
                break;
            }
        }
        else
        {
                break;
        }
    }*/


    var formData= new FormData($("."+classFrm)[0]);
    //hacemos la petición ajax  
    $.ajax({
            url: php,  
            type: 'POST',
            //Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){},
            //una vez finalizado correctamente
            success: function(data)
            {
                var myArrayData= data.split('&');
                if($.trim(myArrayData[0])=='OK')
                {
                    endLoad();

                    $('#divAlertExito').delay( 1000 ).fadeIn( 500 );
                    $('#divAlertExito').animate({
                            'display': 'block'
                    });

                    $('#divAlertExito').delay( 1000 ).fadeOut( 500 );
                    $('#divAlertExito').animate({
                                                            'display': 'none'
                                                    });
                }
                else
                { 	
                    alertError(btn, $.trim(myArrayData[1]), 5000);
                }
            },

            //si ha ocurrido un error
            error: function()
            {
                    endLoad();

                    $('#mensajeWar').html('Error error');
                    $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                    $('#divAlertWar').animate({
                            'display': 'block'
                    });

                    $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                    $('#divAlertWar').animate({
                                                            'display': 'none'
                                                    });
            }
    });
}


function alertError(btn, msg, time)
{
	endLoad();
				
	$('#mensajeWar').html(msg);
	$('#divAlertWar').delay( 1000 ).fadeIn( 500 );
	$('#divAlertWar').animate({
		'display': 'block'
	});
	
	$('#divAlertWar').delay( time ).fadeOut( 500 );
	$('#divAlertWar').animate({
                                    'display': 'none'
                                });
					
	$("#"+btn).delay(2500).queue(function(m)
	{
		$("#"+btn).removeAttr("disabled");
		m();
	});		
}


function initLoad()
{
    $('#divAlertInfo').fadeIn( 500 );
    $('#divAlertInfo').animate({
                            'display': 'block'
                        });
}

function endLoad()
{
    $('#divAlertInfo').delay( 100 ).fadeOut( 500 );
    $('#divAlertInfo').animate({
                                'display': 'none'
                            });
}


function validaReserva(classFrm, php, div, divTit, titulo)
{
	initLoad();

	$("#"+div).html("");
	$("#"+divTit).html(titulo);
	
    
        var contentType = false;
        var processData = false;
    
        if(typeof FormData === "undefined"){
            //IE
            var formData = [];
            formData= formularioIE($("."+classFrm)[0]);
            contentType = 'application/x-www-form-urlencoded';
            processData = true;
        } else {
            var formData= new FormData($("."+classFrm)[0]);
        }
        
        
        
        
        
        
        
        
        
	//hacemos la peticion ajax  
	$.ajax({
		url: php,  
		type: 'POST',
		//Form data
		//datos del formulario
		data: formData,
		//necesario para subir archivos via ajax
		cache: false,
		contentType: contentType,
		processData: processData,
		//mientras enviamos el archivo
		beforeSend: function(){},
		//una vez finalizado correctamente
		success: function(data)
		{
                    $("#"+div).html(data);
                    endLoad();
		},
		
		//si ha ocurrido un error
		error: function()
		{
                    $("#"+div).html("Ha ocurrido un error");
		}
	});
}



function fadeIn(id){
    $('#' + id).fadeIn( 900 );
    $('#' + id).animate({
                            'display': 'block'
                        });
}

function fadeOut(id) {
    $('#' + id).fadeOut( 1000 );
    $('#' + id).animate({
                            'display': 'none'
                        }); 
}
/*function abrirForm(cant,php,sgl,dbl,tpl,pf,moneda,Opc,form,hab,hot,plan){
    
    var valor = $("#ValiFormLogin").val();
    
   $("#tituloPopup" ).html('Detalle');
     
   if(valor === '1'){
        fadeIn('detallePopup');
        $('#divPopupIn').css('overflow-y', 'scroll');
        Programa.prototype.pasajerosProg(cant,'divPopupIn',php,sgl,dbl,tpl,pf,moneda,Opc,form,hab,hot,plan);
        
    }else{
        
        fadeIn('loginPopup');
        $('#divLoginIn').css('overflow-y', 'scroll');
        Programa.prototype.pasajerosProg(cant,'divLoginIn',php,sgl,dbl,tpl,pf,moneda,Opc,form,hab,hot,plan);
        
        
    }
   
    
}*/






function buscarCiudad(ciudad, frmBus, ob, id)
{

    var span= document.getElementById(ob);
    var length = ciudad.length;

    if(length >= 3)
    {
        $.post("process/procesoObtieneCiudad.php", 
        {
            post_ciudad: ciudad, 
            post_frmBus: frmBus,
            post_span: ob,
            post_idTxt: id
        }, function(data){
            $("#"+ob).html(data);
            $("#"+span).css("display", "block");
        });
    }
    else
    {
        $("#"+span).css("display", "none");
        ciudad= '';
            $.post("process/procesoObtieneCiudad.php", { post_ciudad: ciudad, post_frmBus: frmBus }, function(data){
            $("#"+ob).html(data);
        });
    }
}

function divLogin(php)
{
    
    $.ajax({
        url:php,
        type:'post',
        success:function(data){
            $("#divLoginStatusIn").html(data);
        }
    });
}






function habitaciones(table, num)
{
    for(var x=1;x<=3;x++)
    {
        $("#"+table+'_'+x).css("display", "none");
    }

    for(var x=1;x<=num;x++)
    {
        var id=table+'_'+x;
        mostrado=0;
        if($('#'+id).css('display') === 'block')
        {
            mostrado=1;
            $('#'+id).css('display', 'none');
        }
        if(mostrado!==1)
        {
            $('#'+table+'_'+x).fadeIn( 1000 );
            $('#'+table+'_'+x).animate({
                    'display': 'block'
            });
        }		
    }
}




function habilitaEdadChild(id,hab, chd)
{
    
    
    var i, x;
    status_1 = new Array (true, false, false); 
    status_2 = new Array (true, true, false); 

    for(i=0; i<3; i++) {
        if(id==i) {
            for(x=1; x<4; x++) {
                if(hab==x) {
                    
                    $("#" + chd +  "_1_"+x).prop('disabled', status_1[i]);
                    $("#" + chd +  "_2_"+x).prop('disabled', status_2[i]);
                }
            }
        }
    }
}

function soloRut(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    //alert(charCode);
    if ((charCode >= 48 && charCode<= 57) || (charCode == 45) || (charCode == 107) || (charCode == 75)){
            return true;
    }else{ 
            return false;
    }
}


function checkServ(idChk, nConf, fPPago)
{   
    if($("#"+idChk).is(':checked')) {  
        if($.trim($("#"+nConf).val())==="" && $.trim($("#"+fPPago).val())==="")
        {
            $("#"+idChk).prop("checked", "");
        }
    } else {  
        if($.trim($("#"+nConf).val())!=="" || $.trim($("#"+fPPago).val())!=="")
        {
            $("#"+idChk).prop("checked", "checked");
        }
    }
}

function muestraOculta(id, estado)
{
    if(estado===1)
    {
        $('#'+id).delay( 10 ).fadeIn( 500 );
        $('#'+id).animate({
                'display': 'block'
        });
    }
    else
    {
        $('#'+id).delay( 10 ).fadeOut( 500 );
        $('#'+id).animate({
                            'display': 'none'
                        });
    }
}

function abrePopup(div, docPHP, idTitulo, titulo, val,form)
{
    form = '/'+form;
    
    initLoad();
    $("#" + div).html('');
    $("#" + idTitulo ).html(titulo);
    $.post(docPHP+form, 
    {
        varCenterBox: val
    }, function(data)
    {
        $("#" + div).html(data);
        endLoad();
    });
}


function abrePopupHab(div, docPHP, idTitulo, titulo, val, hot,form)
{
    form='/'+form;
    
    initLoad();
    $("#" + div).html('');
    $("#" + idTitulo ).html(titulo);
    $.post(docPHP+form, 
    {
        varCenterBox: val,
        varCenterBoxH: hot
    }, function(data)
    {
        $("#" + div).html(data);
        endLoad();
    });
}

function openForm(div, docPHP, idTitulo, titulo, val, hot,form){
    
    var valor = $("#ValiFormLogin").val();
    
    
    form='/'+form;
    initLoad(valor);
   
       
   if(valor === '1'){
       $("#divPopupPRG").html('');
       $("#tituloFormPRG").html(titulo);
       $.post(docPHP+form, 
        {
        varCenterBox: val,
        varCenterBoxH: hot
        }, function(data)
        {
        $("#divPopupPRG").html(data);
        endLoad();
        });
        }else{
            
        
        fadeIn('loginPopup');
        $("#divLoginIn").html('');
       
        $.post(docPHP+form, 
         {
            varCenterBox: val,
            varCenterBoxH: hot
         }, function(data)
         {
        $("#divLoginIn").html(data);
        endLoad();
        
        });
        
        
    }
    
}

function loginSide(docPHP,form){
    form='/'+form;
        fadeIn('loginPopup');
        $("#divLoginIn").html('');
       
        $.post(docPHP+form, 
         function(data)
         {
        $("#divLoginIn").html(data);
        endLoad();
        
        });
    
}

function loginOutNav(docPHP,form){
    form='/'+form;     
        $.post(docPHP+form, 
         function()
         {
             window.location.reload();
        endLoad();
        
        });
    
}

function detectedCollapsed(id, opciones, idProg,form)
{
    form='/'+form;
    
    if($( "#" + id ).hasClass( "in" ) === false) {
        if($.trim($("#" + opciones).html()) === '') {
            initLoad();
            $.post(BASE_URL_JS + CONTROLLER_JS + '/opciones'+form, 
            {
                __id__: idProg
            }, function(data)
            {
                $("#" + opciones).html(data);
                endLoad();
            });
        }
        //alert("AJAX");
    } /*else {
        $("#" + opciones).html('');
        //alert("NADA");
    }*/
}





function formularioIE(oFormElement) {
    var oField, sFieldType, nFile, sSearch = "";
    for (var nItem = 0; nItem < oFormElement.elements.length; nItem++) {
        oField = oFormElement.elements[nItem];
        if (!oField.hasAttribute("name")) {
            continue;
        }
        sFieldType = oField.nodeName.toUpperCase() === "INPUT" ? oField.getAttribute("type").toUpperCase() : "TEXT";
        if (sFieldType === "FILE") {
            alert("FiLE");
            for (nFile = 0; nFile < oField.files.length; sSearch += "&" + escape(oField.name) + "=" + escape(oField.files[nFile++].name))
                ;
        } else if ((sFieldType !== "RADIO" && sFieldType !== "CHECKBOX") || oField.checked) {
            sSearch += "&" + escape(oField.name) + "=" + escape(oField.value);
        }
    }

    return sSearch;
}







function procesoEnviaFormIE(form, action_url, div_id) {
    //Enviar formulario Internet Explorer
    
    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");
 
    // Add to document...
    form.parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";

    iframeId = document.getElementById("upload_iframe");
 

    // Add event...
    var eventHandler = function () {
 
            if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
            else iframeId.removeEventListener("load", eventHandler, false);
 
            // Message from server...
            if (iframeId.contentDocument) {
                content = iframeId.contentDocument.body.innerHTML;
            } else if (iframeId.contentWindow) {
                content = iframeId.contentWindow.document.body.innerHTML;
            } else if (iframeId.document) {
                content = iframeId.document.body.innerHTML;
            }
 
            
            endLoad();
            if(content==='OK') {
                //alert('Todo ok');
                $("#"+div_id).delay(1500).queue(function(n)
                {
                    $("#"+div_id).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Proceso realizado con &eacute;xito.</div>');
                    n();
                });
            } else {
                $('#mensajeWar').html(content);
                $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                $('#divAlertWar').animate({
                        'display': 'block'
                });

                $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                $('#divAlertWar').animate({
                                            'display': 'none'
                                        });
            }
            //document.getElementById(div_id).innerHTML = content;
 
            // Del the iframe...
            setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        };
 
 
    
    if (iframeId.addEventListener) {
        iframeId.addEventListener("load", eventHandler, true);
    } else if (iframeId.attachEvent) { 
        iframeId.attachEvent("onload", eventHandler); 
    }
 
    // Set properties of form...
    form.setAttribute("target", "upload_iframe");
    form.setAttribute("action", action_url);
    form.setAttribute("method", "post");
    
    //form.setAttribute("enctype", "multipart/form-data");
    //form.setAttribute("encoding", "multipart/form-data");
 
    // Submit the form...
    form.submit();
    initLoad();
}












    /*BEGIN: Busqueda de Bloqueos */
    $('#btnBuscarBloqueos').on('click',function()
    {
        var mL_Error=0;
        $("#btnBuscarBloqueos").attr('disabled', 'disabled');
       
        
        
        if($('#mL_txtCiudadDestino').val() != 0)
        {
            
            if($('#mL_txtFechaIn').val() !==""  && $('#mL_txtFechaOut').val() !=="")
           {
            
                if($('#mL_txtFechaIn').val().length == 10 && $('#mL_txtFechaOut').val().length == 10)
                {
               
           var f_inicio = $('#mL_txtFechaIn').val();
           var f_termino = $('#mL_txtFechaOut').val();
            var resultado = 0;
    resultado = restaFechas(f_inicio,f_termino);
           
                if(resultado >= 0)
                     {
                
            
                                if($('#mL_cmbHab').val() != 0)
                                {
                                    $(document).skylo('start');

                                    setTimeout(function(){
                                            $(document).skylo('set',50);
                                    },1000);

                                    setTimeout(function(){
                                            $(document).skylo('end');
                                    },1500);
                                    setTimeout(function(){
                                       document.getElementById('frmBuscarBloqueos').submit();
                                    },2500);
                                }
                                else
                                {
                                    mL_Error=1;
                                    $('#mensajeWar').html('Debe seleccionar la cantidad de habitaciones');
                                }
                       
                     }else{
                         mL_Error=1;
                                    $('#mensajeWar').html("La fecha In debe ser menor o igual a la fecha Out");
                     } 
            
                }else{
                       mL_Error=1;
                    $('#mensajeWar').html('Fecha invalida'); 
                    }
           }else{
              mL_Error=1;
                $('#mensajeWar').html('Debe seleccionar fechas in y out'); 
           }
        }
        else
        {
            mL_Error=1;
            $('#mensajeWar').html('Debe seleccionar una ciudad de destino');	
        }




        if( mL_Error==1 )
        {
            $('#divAlertWar').delay( 10 ).fadeIn( 500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });

            $('#divAlertWar').delay( 2000 ).fadeOut( 500 );
            $('#divAlertWar').animate({
                                        'display': 'none'
                                    });

            $("#btnBuscarBloqueos").delay(2000).queue(function(dis)
            {
                $("#btnBuscarBloqueos").removeAttr("disabled");
                dis();
            });	
        }
		
    });
    /*END: Busqueda de Bloqueos*/
    
   function restaFechas(f1,f2)

{

var aFecha1 = f1.split('/');

 var aFecha2 = f2.split('/');

 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);

 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);

 var dif = fFecha2 - fFecha1;

var dias = Math.floor(dif / (1000 * 60 * 60 * 24));

 return dias;

} 
    
    
    
    /*BEGIN: Busqueda de Programas */
    $('#btnBuscarProgramas').on('click',function()
    {
        var mL_Error=0;
        $("#btnBuscarProgramas").attr('disabled', 'disabled');
        if($('#mL_txtCiudadDestino_PRG').val() != 0)
        {
            if($('#mL_cmbHab_PRG').val() != 0)
            {
                $(document).skylo('start');

                setTimeout(function(){
                        $(document).skylo('set',50);
                },1000);

                setTimeout(function(){
                        $(document).skylo('end');
                },1500);
                setTimeout(function(){
                   document.getElementById('frmBuscarProgramas').submit();
                },2500);
            }
            else
            {
                mL_Error=1;
                $('#mensajeWar').html('Debe seleccionar la cantidad de habitaciones');
            }
        }
        else
        {
            mL_Error=1;
            $('#mensajeWar').html('Debe seleccionar una ciudad de destino');	
        }




        if( mL_Error==1 )
        {
            $('#divAlertWar').delay( 10 ).fadeIn( 500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });

            $('#divAlertWar').delay( 2000 ).fadeOut( 500 );
            $('#divAlertWar').animate({
                                        'display': 'none'
                                    });

            $("#btnBuscarProgramas").delay(2000).queue(function(dis)
            {
                $("#btnBuscarProgramas").removeAttr("disabled");
                dis();
            });	
        }
		
    });
    /*END: Busqueda de Programas*/
    
    
    
    
    $('#menuConsRes').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'booking';
        },2500);
    });
    
    
    
    $('#menuHoteles').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'hoteles';
        },2500);
    });
    
    
    $('#menuAdminProg').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'programas/admin';
        },2500);
    });
    
    
    $('#menuImagenes').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'voucher';
        },2500);
    });
    
    
    $('#menuContacto').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'contacto';
        },2500);
    });
    
    
    
    /* ADMIN PROGRAMAS */
    $('#btnAdmProg').on('click',function(){
        
        if($('#AP_cmbCiudadDestino').val()==='0')
        {
            $('#divAlertWarProg').fadeIn( 1500 );
            $('#divAlertWarProg').animate({
                    'display': 'block'
            });
        }
        else
        {
            $("#btnAdmProg").attr('disabled', 'disabled');
            
            $(document).skylo('start');

            setTimeout(function(){
                    $(document).skylo('set',50);
            },1000);

            setTimeout(function(){
                    $(document).skylo('end');
            },1500);
            setTimeout(function(){
                    document.getElementById('frmAdmProg').submit();
            },2500);
        }
    });




