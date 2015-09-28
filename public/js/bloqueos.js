/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */
function Bloqueo() {
    this.B_nombre = '';
    this.B_aceptar_cond = false;
}

Bloqueo.prototype.getNombre = function () {
    return this.B_nombre;
};
Bloqueo.prototype.setNombre = function (nombre) {
    this.B_nombre = nombre;
};

Bloqueo.prototype.procesoReservaPRG = function (classFrm, php, btn, div, form, urlCon)
{
    initLoad();
    if (this.B_aceptar_cond) {
    form = '/' + form;
    $("#" + btn).attr('disabled', 'disabled');
    
    txtNombre_pago = document.getElementById("txtNombre_pago");
    if (txtNombre_pago !== null)
    {
        if($.trim($("#txtNombre_pago").val()) === ''){
            alertError(btn, 'Debe ingresar su nombre', 2000);
            $( "#txtNombre_pago" ).focus();
            return false;

        } else if($.trim($("#txtApellidos_pago").val()) === ''){
            alertError(btn, 'Debe ingresar su apellido', 2000);
            $( "#txtApellidos_pago" ).focus();
            return false;

        } else if($.trim($("#txtEmail_pago").val()) === ''){
            alertError(btn, 'Debe ingresar su email', 2000);
            $( "#txtEmail_pago" ).focus();
            return false;

        } else if($.trim($("#txtTelefono_pago").val()) === ''){
            alertError(btn, 'Debe ingresar su numero de telefono', 2000);
            $( "#txtTelefono_pago" ).focus();
            return false;

        }
    }

    for (rP = 1; rP >= 1; rP++)
    {
        //tipoPas= document.getElementById("tipo_bloq_"+i);
        txtPasaporte = document.getElementById("rP_chkPas_" + rP);
        txtRut = document.getElementById("rP_txtRut_" + rP);
        if (txtRut != null)
        {
            if (txtPasaporte.checked == false)
            {
                if (txtRut.value.replace(/^\s+|\s+$/g, "") == '')
                {
                    alertError(btn, 'Debe ingresar un rut', 2000);
                    txtRut.focus();
                    return false;
                    break;
                }
                else
                {
                    statusRut = Rut(txtRut, txtRut.value);
                    if (statusRut != true)
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
                if (txtRut.value.replace(/^\s+|\s+$/g, "") == '')
                {
                    alertError(btn, 'Debe ingresar un rut', 2000);
                    txtRut.focus();
                    return false;
                    break;
                }
            }

            if ($.trim($("#rP_txtNom_" + rP).val()) == '')
            {
                alertError(btn, 'Debe ingresar un nombre', 2000);
                $("#rP_txtNom_" + rP).focus();
                return false;
                break;
            }

            if ($.trim($("#rP_txtApe_" + rP).val()) == '')
            {
                alertError(btn, 'Debe ingresar un apellido', 2000);
                $("#rP_txtApe_" + rP).focus();
                return false;
                break;
            }


            if ($("#rP_cmbTipoPax_" + rP).val() == 'C')
            {
                if ($.trim($("#rP_FechaNac_" + rP).val()) == '')
                {
                    alertError(btn, 'Debe ingresar una fecha de nacimiento para el Child', 2000);
                    $("#rP_FechaNac_" + rP).focus();
                    return false;
                    break;
                }
            }



            txtPasaporteInf = document.getElementById("rP_chkPasInf_" + rP);
            txtRutInf = document.getElementById("rP_txtRutInf_" + rP);
            if (txtRutInf != null)
            {
                if (txtPasaporteInf.checked == false)
                {
                    if (txtRutInf.value.replace(/^\s+|\s+$/g, "") == '')
                    {
                        alertError(btn, 'Debe ingresar un rut para el infant', 2000);
                        txtRutInf.focus();
                        return false;
                        break;
                    }
                    else
                    {
                        statusRutInf = Rut(txtRutInf, txtRutInf.value);
                        if (statusRutInf != true)
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
                    if (txtRutInf.value.replace(/^\s+|\s+$/g, "") == '')
                    {
                        alertError(btn, 'Debe ingresar un rut para el infant', 2000);
                        txtRutInf.focus();
                        return false;
                        break;
                    }
                }


                if ($.trim($("#rP_txtNomInf_" + rP).val()) == '')
                {
                    alertError(btn, 'Debe ingresar un nombre para el infant', 2000);
                    $("#rP_txtNomInf_" + rP).focus();
                    return false;
                    break;
                }

                if ($.trim($("#rP_txtApeInf_" + rP).val()) == '')
                {
                    alertError(btn, 'Debe ingresar un apellido para el infant', 2000);
                    $("#rP_txtApeInf_" + rP).focus();
                    return false;
                    break;
                }



                if ($.trim($("#rP_FechaNacInf_" + rP).val()) == '')
                {
                    alertError(btn, 'Debe ingresar una fecha de nacimiento para el Infant', 2000);
                    $("#rP_FechaNacInf_" + rP).focus();
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
    var txtRutNew1, txtRutNew2;
    for (x = 1; x < rP; x++) {
        txtRutNew1 = document.getElementById("rP_txtRut_" + x);
        for (y = 1; y < rP; y++) {
            if (x != y) {
                txtRutNew2 = document.getElementById("rP_txtRut_" + y);
                if (txtRutNew1.value == txtRutNew2.value) {
                    alertError(btn, 'El rut del pasajero[' + x + '] se repite con el del pasajero[' + y + '].', 3000);
                    txtRutNew1.select();
                    return false;
                    break;
                }
            }
        }
    }
    /* --- */









    var contentType = false;
    var processData = false;

    if (typeof FormData === "undefined") {
        //IE
        var formData = [];
        formData = formularioIE($("." + classFrm)[0]);
        contentType = 'application/x-www-form-urlencoded';
        processData = true;
    } else {
        var formData = new FormData($("." + classFrm)[0]);
    }




    //hacemos la petición ajax 


    endLoad();


    

        $.ajax({
            url: php + form,
            type: 'POST',
            //Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: contentType,
            processData: processData,
            //mientras enviamos el archivo
            beforeSend: function () {
            },
            //una vez finalizado correctamente
            success: function (data)
            {
                //$("#checkCondiciones").attr('checked', false);
                var myArrayData = data.split('&');
                if ($.trim(myArrayData[0]) === 'OK')
                {
                    $('#btnCerrar1PRG').delay(100).fadeOut(100);
                    $('#btnCerrar1PRG').animate({
                        'display': 'none'
                    });

                    if($.trim(myArrayData[4])==='66d70610b684db4b9d2417f6da614a60') {
                        JSON.prototype.setDiv(div);
                        JSON.prototype.getHash();
                        alertError(btn, 'jojo', 2000);
                    } else {
                        $("#" + div).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Estamos abriendo la carta confirmaci&oacute;n, espere un momento...</div>');
                        $.post(BASE_URL_JS + CONTROLLER_JS + "/cartaConfirmacion" + form,
                        {
                            CR_n_file: myArrayData[1],
                            CR_cod_prog: myArrayData[2],
                            CR_cod_bloq: myArrayData[3]

                        }, function (dataRS)
                        {
                            $("#" + div).html(dataRS);
                            endLoad();

                            $('#btnAceptarPRG').delay(2000).fadeIn(100);
                            $('#btnAceptarPRG').animate({
                                'display': 'block'
                            });
                        });
                    }
                    



                }
                else
                {
                    alertError(btn, data, 5000);
                }
            },
            //si ha ocurrido un error
            error: function ()
            {
                endLoad();

                $('#mensajeWar').html('Error error');
                $('#divAlertWar').delay(1000).fadeIn(500);
                $('#divAlertWar').animate({
                    'display': 'block'
                });

                $('#divAlertWar').delay(5000).fadeOut(500);
                $('#divAlertWar').animate({
                    'display': 'none'
                });
            }
        });
    }else{
        alertError("aceptarCondiciones", "Debe aceptar las condiciones", 4000);
        endLoad();
    }


};

Bloqueo.prototype.abrirCondiciones = function (urlCon) {
    
        fadeIn('condicionesPopup');
        $.post(urlCon,
                {
                    __sucessful__: 1
                }, function (data)
        {
            $("#divPopupCon").html(data);
            endLoad();
        });
    
};

Bloqueo.prototype.aceptarCondiciones= function (){
    
    if(!this.B_aceptar_cond) {
        if ($('#checkCondiciones').is(':checked')) {
            fadeOut('condicionesPopup');
            this.B_aceptar_cond = true;
        } else {
            alertError("aceptarCondiciones", "Debe aceptar las condiciones", 4000);
            this.B_aceptar_cond = false;
        }
    }else{
        this.B_aceptar_cond = false;
    }
};