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


Programa.prototype.pasajerosProg = function(valor, div2, php, sgl, dbl, tpl, pf, mon, opc,form) {

    form='/'+form;
    
    if(valor) {
        $.post(php+form, {
            _PP_: valor,
            _SGL_: sgl,
            _DBL_: dbl,
            _TPL_: tpl,
            _PF_: pf,
            _MON_: mon,
            _OPC_: opc
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




Programa.prototype.procesoEnviaFormProg = function (classFrm, php, btn, div,form)
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