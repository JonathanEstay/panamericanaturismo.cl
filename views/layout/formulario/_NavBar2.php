<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="<?php echo CHARSET; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"  />
    <title><?php if(isset($this->titulo)){ echo $this->titulo; }?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ORISTRAVEL">
    <meta name="author" content="The Red Team">

    <script src="<?php echo $_layoutParams['ruta_js']; ?>jquery-1.10.2.min.js"></script>
    <link href="<?php echo $_layoutParams['ruta_css']; ?>styles.min.css" rel="stylesheet" >
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
        <iframe  frameborder="0"width="100%" height="171"  src="<?php echo$this->url;?>"scrolling="no" ></iframe>
        
        
            <div  style="position: absolute; top: 180px; right: 13%" >
                <a style="cursor: pointer;text-decoration:none;" id="loginInNav"onClick="loginSide('<?php echo BASE_URL; ?>login/logForm','<?php echo $this->form;?>');"><i><img style="width: 10px; " src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>iniciar sesi&oacute;n</span></a>
            <a id="loginOutNav"style="display: none;cursor: pointer;text-decoration:none;" onClick="loginOutNav('<?php echo BASE_URL; ?>login/LoginOutNav','<?php echo $this->form;?>');"><i><img style="width: 10px;" src="<?php echo $_layoutParams['ruta_img']; ?>closed-negro-chico.png" /></i> <span>cerrar sesi&oacute;n</span></a>
            </div>
        
       