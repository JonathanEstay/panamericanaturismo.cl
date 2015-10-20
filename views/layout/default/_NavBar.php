<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="<?php echo CHARSET; ?>" />
    <meta http-equiv="Content-Type" content="text/html;"  />
    <title><?php if(isset($this->titulo)){ echo $this->titulo; }?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <!-- Esta etiqueta le indica al navegador el ancho que debe usar para la pagina web -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="ORISTRAVEL">
    <meta name="author" content="The Red Team">
    
    <script src="<?php echo $_layoutParams['ruta_js']; ?>jquery-1.10.2.min.js"></script>
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

<body>




<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
    <!-- <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Menu"></a> -->
    

    
    <div class="navbar-header pull-left">
        <a href="<?php echo BASE_URL . 'system'; ?>">
            <img src="<?php echo $_layoutParams['ruta_img']; ?>logo.png" height="48" style="margin-left:20px;">
        </a>
    </div>
    
    <ul class="nav navbar-nav pull-right toolbar">
        
        
        <li class="dropdown">
            
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
                <img src="<?php echo $_layoutParams['ruta_img']; ?>closed_blanco.png" height="24" />
            </a>
           
            <ul class="dropdown-menu userinfo arrow" style="width:300px">
                
                <li class="username">
                    <a href="#">
                        <div><h5>Hola, <b><?php echo Session::get('sess_nombre');  ?></b>!</h5></div>
                    </a>
                </li>
                
                <li class="userlinks">
                    <ul class="dropdown-menu">
                        <!-- <li><a href="#">Usuario: <i class="pull-right"><b>jestay</b></i></a></li> -->
                        <li><a href="#">Usuario: <b><?php echo Session::get('sess_clave_usuario');  ?></b></a></li>
                        <li><a href="#">Perfil: <b><?php echo Session::get('level');  ?></b></a></li>
                        <li><a href="#">Cliente: <b><?php echo Session::get('sess_agencia'); /*Session::get('level');*/  ?></b></a></li>
                        
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL . 'system/salir' ?>" class="text-right">Cerrar sesi&oacute;n</a></li>
                    </ul>
                </li>
            </ul>

        </li>
        

        <li class="dropdown">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
                <img src="<?php echo $_layoutParams['ruta_img']; ?>info_blanco.png" width="24" />
            </a>
            <ul class="dropdown-menu messages arrow" style="width:300px">
                <li class="dd-header">
                    <span><?php echo ENT_NAME; ?></span>
                    <span><a href="<?php echo ENT_WEB; ?>" target="_blank"><?php echo ENT_WEB; ?></a></span>
                </li>


                <div class="scrollthis">
                    <li><a href="#">
                            <span class="time"><?php echo ENT_COMUNA; ?></span>
                            <img src="<?php echo $_layoutParams['ruta_img']; ?>home.png" />
                            <div>
                                <span class="name">Direcci&oacute;n</span>
                                <span class="msg"><?php echo ENT_DIREC; ?><br><?php echo ENT_CIUDAD . ' de ' . ENT_PAIS; ?></span>
                            </div>
                    </a></li>
                    <li><a href="#">
                            <img src="<?php echo $_layoutParams['ruta_img']; ?>fono.png" />
                            <div><span class="name">Telefono</span><span class="msg"><?php echo ENT_FONO; ?></span></div>
                    </a></li>
                </div>



                <li class="dd-footer">
                    <a href="mailto:<?php echo ENT_EMAIL; ?>?Subject=Consulta: " target="_top">
                        <?php echo ENT_EMAIL; ?>
                    </a>
                </li>
            </ul>
        </li>
        
        
        
        
        <li id="divTime" class="dropdown">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
                <img src="<?php echo $_layoutParams['ruta_img']; ?>fecha_hora.png" width="24" />
            </a>
            <ul class="dropdown-menu messages arrow" style="height: 100px">
                <li class="dd-header">
                    <span><?php echo Functions::traduceDia(); ?></span>
                    <span>&nbsp;</span>
                </li>


                <div class="scrollthis">
                    <li><a href="#">
                            <div>
                                <span class="name"><div id="divClock"></div></span>
                                <span class="msg"><?php echo date('d') . ' de ' . Functions::traduceMes() . ' de ' . date('Y'); ?></span>
                            </div>
                    </a></li>
                </div>
            </ul>
        </li>
        
        
        
        
        
        <li class="dropdown">
            <a id="menuContacto" href="javascript:;">
                <img src="<?php echo $_layoutParams['ruta_img']; ?>contac_w.png" width="24" />
            </a>
        </li>
        
        
        <!-- <li class="dropdown">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
                <img src="<?php echo $_layoutParams['ruta_img']; ?>carro_blanco.png" width="24" />
                <span class="badge">3</span>
            </a>
            <ul class="dropdown-menu notifications arrow">
                <li class="dd-header">
                    <span>Tiene (3) elementos en el carro</span>
                </li>
                <div class="scrollthis">
                    <li>
                        <a href="#" class="notification-warning">
                            <span class="time">2 hrs</span>
                            <i>S&nbsp;</i> 
                            <span class="msg">Servicio. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-order">
                            <span class="time">10 hrs</span>
                            <i>P&nbsp;</i> 
                            <span class="msg">Programa. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-failure">
                            <span class="time">12 hrs</span>
                            <i>H&nbsp;</i>
                            <span class="msg">Hotel. </span>
                        </a>
                    </li>
                </div>
                <li class="dd-footer"><a href="<?php echo BASE_URL . 'system/carro' ?>">Ir al carro de compras</a></li>
            </ul>
        </li> -->
        
    </ul>
             
</header>
    
    <div id="page-container" style="min-height: 600px; min-width: 950px;">
        
        
        
        
        
        
        
        
        <div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="tituloFormSearch">&nbsp;&nbsp;</h4>
                    </div>

                    <div class="modal-body" id="divPopupSearch">
                        
                        <table align="center">
                            <tr>
                                <td align="center">
                                    <?php if(Session::get('sess_codigo_cliente_url') == '3f7a2611ee08c6645796463e0bb1ae7f'){ ?>
                                        <img src="<?php echo $_layoutParams['ruta_img']; ?>logo_tc_search.png">
                                    <?php } else { ?>
                                        <img src="<?php echo $_layoutParams['ruta_img']; ?>logo.jpg"><br>
                                        <h3 style="color: #0082cb">Estamos buscando <i style="color: #ecb344; font-weight: bold;">las mejores alternativas</i> de viaje para usted.</h3>
                                    <?php } ?>
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
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>