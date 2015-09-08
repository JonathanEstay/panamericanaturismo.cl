/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 10 de octubre de 2014
 */

//Clase programa
function Programa() {
    this.P_nombre = ''; 
}

Programa.prototype.getNombre = function() {
  return this.P_nombre;
};
Programa.prototype.setNombre = function(nombre) {
  this.P_nombre = nombre;
};


Programa.prototype.validaPasaporte = function(id, rut, passport) {
    if($("#"+id).is(':checked')) {
        $('#' + rut).delay( 20 ).fadeOut( 50 );
        $('#' + rut).animate({
                            'display': 'none'
                        });
        $('#' + passport).delay( 80 ).fadeIn( 50 );
        $('#' + passport).animate({
                'display': 'block'
        });
    } else {
        $('#' + passport).delay( 20 ).fadeOut( 50 );
        $('#' + passport).animate({
                            'display': 'none'
                        });
        $('#' + rut).delay( 80 ).fadeIn( 50 );
        $('#' + rut).animate({
                'display': 'block'
        });
    }
};


Programa.prototype.pasajerosProg = function(valor, div2, php, sgl, dbl, tpl, pf, mon, opc,form,hab,hot,plan) {

    form='/'+form;
    
    
    
    if(valor) {
        $.post(php+form, {
            _PP_: valor,
            _SGL_: sgl,
            _DBL_: dbl,
            _TPL_: tpl,
            _PF_: pf,
            _MON_: mon,
            _OPC_: opc,
            _HAB_: hab,
            _HOT_:hot,
            _PLAN_:plan
        }, function(data) {
            $('#' + div2).html(data);
            $('#' + div2).delay( 100 ).fadeIn( 400 );
            $('#' + div2).animate({
                    'display': 'block'
            });
            
        });
    } else {
        $('#' + div2).delay( 100 ).fadeIn( 400 );
        $('#' + div2).animate({
                'display': 'block'
        });
    }
};

Programa.prototype.procesoDetallePasajeros = function(classFrm, php, btn, div,form)
{
    
    form='/'+form;
    
    $("#"+btn).attr('disabled', 'disabled');
    initLoad();
    
    if($("#DP_cmbHab").val() === '0') {
        endLoad();
        $('#mensajeWar').html('Debe seleccionar la cantidad de habitaciones.');
        $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
        $('#divAlertWar').animate({
                'display': 'block'
        });

        $('#divAlertWar').delay( 3000 ).fadeOut( 500 );
        $('#divAlertWar').animate({
                                    'display': 'none'
                                });
        $("#"+btn).delay(2000).queue(function(m)
        {
            $("#"+btn).removeAttr("disabled");
            m();
        });
        return false;
    }

    
    
    
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
           
            $("#" + div).html(data);
            endLoad();
        },

        //si ha ocurrido un error
        error: function()
        {
            $("#" + div).html("Ha ocurrido un error");
        }
    });
};




Programa.prototype.procesoEnviaFormProg = function (classFrm, php, btn, div,form,urlCon)
{
    form='/'+form;
    
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();

    
    
    
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
    
    fadeIn('condicionesPopup');
    
    //hacemos la peticion ajax
    
     $.ajax({
     url:urlCon,
     success:function(data){
            $("#divPopupCon").html(data);
            endLoad();
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
            
            if($.trim(myArrayData[0]) === 'OK')
            {
                $('#btnCerrar1PRG').delay( 100 ).fadeOut( 100 );
                $('#btnCerrar1PRG').animate({
                                            'display': 'none'
                                        });

                //alert('TODO OK'); return false;
                fadeOut('detallePopup');
                $("#"+div).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Estamos abriendo la carta confirmaci&oacute;n, espere un momento...</div>');
                $.post( BASE_URL_JS + CONTROLLER_JS + "/cartaConfirmacion"+form, 
                {
                    __sucessful__: myArrayData[1]

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
                    }
                        
                    });
                    
                }            
            });
    
}

//se cambian funciones de funciones.js a programas.js
Programa.prototype.methodSend = function (classFrm, php, btn, div) {
    if(typeof FormData === "undefined"){
        Programa.prototype.procesoEnviaFormIE(classFrm, php, div);
    } else {
        Programa.prototype.procesoEnviaForm(classFrm, php, btn, div);
    }
}

Programa.prototype.procesoEnviaForm = function(classFrm, php, btn, div)
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

Programa.prototype.procesoEnviaFormIE = function(form, action_url, div_id) {
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

Programa.prototype.abrirForm = function(cant,php,sgl,dbl,tpl,pf,moneda,Opc,form,hab,hot,plan){
    
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
   
    
}

Programa.prototype.procesoDetalleProg = function(classFrm,form)
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
}



//Programa.prototype.validaPasaporte();

/*function crearPersona(){
    var persona1 = new Programa();
    persona1.setNombre("Jonathan Estay");
    alert(persona1.getNombre());
    
    var persona2 = new Programa();
    persona2.setNombre("Sergio Orellana");
    alert(persona2.getNombre());
}*/

//crearPersona();