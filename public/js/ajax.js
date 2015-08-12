/* 
 * Proyecto : oristravel.com
 * Autor    : Tsyacom Ltda.
 * Fecha    : Lunes, 28 de julio de 2014
 */

$(document).ready(function(){
    //una funcion
    var getCiudades = function()
    {   //(esta es la url hacia donde van los post), 
        //(las variables que enviamos),
        //(luego enviamos una funcion)
        //(luego lo que queremos que devuelva la funcion sea un "json")
        $.post('/oristravel.com/ajax/getCiudades', 'pais=' + $('#pais').val(), function(datos){
            $('#ciudad').html(''); //limpiar el select ciudades
            
            for(var i = 0; i < datos.length; i++)
            {
                $('#ciudad').append('<option value="' + datos[i].id + '">' + datos[i].ciudad + '</option>')
            }
            
        }, 'json');
    }
    
    $('#pais').change(function(){
        if(!$('#pais').val())
        {
            $('#ciudad').html('');
        }
        else
        {
            getCiudades;
        }
    });
    
});
