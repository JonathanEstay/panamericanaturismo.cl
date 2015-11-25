<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="<?php echo CHARSET; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"  />
    <title><?php if(isset($this->titulo)){ echo $this->titulo; }?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <!-- Esta etiqueta le indica al navegador el ancho que debe usar para la pagina web -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ORISTRAVEL">
    <meta name="author" content="Tsyacom">

    <script src="<?php echo $_layoutParams['ruta_js']; ?>jquery-1.10.2.min.js"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-70684426-1', 'auto');
        ga('send', 'pageview');
    </script>
    
    
    <link href="<?php echo $_layoutParams['ruta_css']; ?>styles.min.css" rel="stylesheet" >
    <link rel="shortcut icon" href="<?php echo $_layoutParams['ruta_img']; ?>favicon.ico">
    
    <!-- <link href='<?php echo $_layoutParams['ruta_css']; ?>google-fonts.css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'> -->
     <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>


    
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="js/excanvas.min.js"></script>
	<![endif]-->


    <link rel='stylesheet' type='text/css' href='<?php echo $_layoutParams['ruta_css']; ?>jquery.pnotify.default.css' /> 
    <link rel='stylesheet' type='text/css' href='<?php echo $_layoutParams['ruta_css']; ?>skylo.css' /> 
    <link rel='stylesheet' type='text/css' href='<?php echo $_layoutParams['ruta_css']; ?>jqueryui.css' /> 
    <link rel='stylesheet' type='text/css' href='<?php echo $_layoutParams['ruta_css']; ?>prettify.css' /> 
    <link rel='stylesheet' type='text/css' href='<?php echo $_layoutParams['ruta_css']; ?>toggles.css' /> 
    <link rel="stylesheet" type="text/css"href="<?php echo $_layoutParams['ruta_css']; ?>tip-darkgray/tip-darkgray.css" />
    <script type="text/javascript">
        var BASE_URL_JS = "<?php echo BASE_URL; ?>";
        var CONTROLLER_JS = "<?php echo Session::get('SESS_CONTROLLER'); ?>";
        var RUTA_IMG_JS = "<?php echo $_layoutParams['ruta_img']; ?>";
        var segundos = <?php echo date('s')+1; ?>;
        var minutos = <?php echo date('i'); ?>;
        var hora = <?php echo date('H'); ?>; 

        function digiClock() {
            segundos++;
            if (segundos === 60) {
                segundos = 0;
                minutos++;
                if (minutos === 60) {
                    minutos = 0;
                    hora++;
                    if (hora === 24) {
                        hora = 0;
                    }
                }
            }
            if(segundos>9) { ceroSeg = ''; } else { ceroSeg = '0'; }
            if(minutos>9) { ceroMin = ''; } else { ceroMin = '0'; }
            if(hora>9) { ceroHor = ''; } else { ceroHor = '0'; }
            $("#divClock").html(ceroHor + hora + ":" + ceroMin + minutos + ":" + ceroSeg + segundos);
        }

        $(document).ready(function()  
        {
           setInterval('digiClock()', 1000);  
        });
    </script>
    
</head>

<body style=" background-color: #e8eff7;padding-top: 0px;">

    
    <div id="page-container" style="width: 1080px; margin:0 auto; " >
        <?php if(Session::get('sess_iframe')){ ?>
            <iframe  frameborder="0"width="100%" height="171"  src="<?php echo$this->url;?>"scrolling="no" ></iframe>
            
            <?php if(!Session::get('sess_boton_pago')){ ?>
            <div  style="position: absolute; top: 180px; right: 13%" >
                <a style="<?php if(Session::get('Autenticado')) echo 'display:none;';?>cursor: pointer;text-decoration:none;" id="loginInNav"onClick="loginSide('<?php echo BASE_URL; ?>login/logForm','<?php echo $this->form;?>');"><i><img style="width: 10px; " src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>iniciar sesi&oacute;n</span></a>
            <a id="loginOutNav"style="<?php if(!Session::get('Autenticado'))echo 'display: none;';?>cursor: pointer;text-decoration:none;" onClick="loginOutNav('<?php echo BASE_URL; ?>system/salir','<?php echo $this->form;?>');"><i><img style="width: 10px;" src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>cerrar sesi&oacute;n</span></a>
            </div>
            <?php } ?>
        <?php } else { ?>
            <div class="navbar navbar-inverse navbar-fixed-top"  style="background-image: url(<?php echo $_layoutParams['ruta_img']; ?>banner_tc.png); background-size: 100%; background-repeat: no-repeat; width: 1080px; margin:0 auto; height:55px;" ></div>
        
            <?php if(!Session::get('sess_boton_pago')){ ?>
            <div  style="position: absolute; top: 80px; right: 13%" >
                <a style="<?php if(Session::get('Autenticado')) echo 'display:none;';?>cursor: pointer;text-decoration:none;" id="loginInNav"onClick="loginSide('<?php echo BASE_URL; ?>login/logForm','<?php echo $this->form;?>');"><i><img style="width: 10px; " src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>iniciar sesi&oacute;n</span></a>
            <a id="loginOutNav"style="<?php if(!Session::get('Autenticado'))echo 'display: none;';?>cursor: pointer;text-decoration:none;" onClick="loginOutNav('<?php echo BASE_URL; ?>system/salir','<?php echo $this->form;?>');"><i><img style="width: 10px;" src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>cerrar sesi&oacute;n</span></a>
            </div>
            <?php } ?>
       <?php } ?>

            
            
            
            
        <div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?php if(Session::get('sess_codigo_cliente_url') == '3f7a2611ee08c6645796463e0bb1ae7f'){ ?>
                        <div class="modal-header">
                            <h4 class="modal-title" id="tituloFormSearch">&nbsp;&nbsp;</h4>
                        </div>

                        <div class="modal-body" id="divPopupSearch">
                            <table align="center">
                                <tr>
                                    <td align="center">
                                        <img src="<?php echo $_layoutParams['ruta_img']; ?>v2_publicidad.png" width="90%">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <h3>Si no <b>viajas</b> ahora es por que no quieres... <img src="<?php echo $_layoutParams['ruta_img']; ?>avion_search.png"></h3>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td><img src="<?php echo $_layoutParams['ruta_img']; ?>loading.gif"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <center>
                                <a class="btn btn-primary" href="<?php echo BASE_URL . Session::get('SESS_CONTROLLER') . '/index/' . $this->form; ?>" id="btnAceptarSearch" style="display:none">Volver a reservar</a>
                            </center>
                        </div>
                    <?php } else { ?>
                        <div class="modal-body" id="divPopupSearch" style="padding:1px;">
                            <img src="<?php echo $_layoutParams['ruta_img']; ?>logo_loading.png" style="width:100%; display:block;margin:0 auto 0 auto;">
                        </div>
                    <?php } ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>