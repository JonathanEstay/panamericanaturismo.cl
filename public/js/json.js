/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */
function JSON() {
    this.J_nombre = '';
    this.J_div = '';
}

JSON.prototype.getNombre = function () {
    return this.J_nombre;
};
JSON.prototype.setNombre = function (nombre) {
    this.J_nombre = nombre;
};

JSON.prototype.getDiv = function () {
    return this.J_div;
};
JSON.prototype.setDiv = function (div) {
    this.J_div = div;
};



JSON.prototype.getHash = function () {
    
    formData="&__JSON__=466deec76ecdf5fca6d38571f6324d54";
    contentType = 'application/x-www-form-urlencoded';
    processData = true;
    $.ajax({
            url: BASE_URL_JS + 'json/getHash',
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
            success: function (RS)
            {                
                $.post(BASE_URL_JS + "json/checkPayment",
                {
                    __PAYMENT__ : RS
                }, function (dataRS)
                {
                    $("#" + JSON.prototype.getDiv()).html(dataRS);
                    endLoad();
                    /*$('#btnAceptarPRG').delay(2000).fadeIn(100);
                    $('#btnAceptarPRG').animate({
                        'display': 'block'
                    });*/
                });
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
    
};