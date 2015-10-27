<?php
function traerNombreHabitacion($cod_hab)
{
    $sql = "SELECT nombre FROM tipoh WHERE codigo = '".$cod_hab."';";
    $res = mssql_query($sql);
    if(mssql_num_rows($res) > 0)
    {
        $row = mssql_fetch_array($res);
        return $row["nombre"];
    }
    else
        return "";
}

function traerNombrePlanAlim($cod_pa)
{
	$sql = "SELECT nombre FROM palimt WHERE codigo = '".$cod_pa."';";
	$res = mssql_query($sql);
	if(mssql_num_rows($res) > 0)
	{
            $row = mssql_fetch_array($res);
            return $row["nombre"];
	}
	else
            return "";
}

// include ("../permiso.php");
//include("../conex/mysql.conex.php");
// include('fpdf.php');
// include('pdf_html.php');

$num_file = $numFile;

// 1.- Sacar el tipo de la tabla [FILE_]
$sql = "SELECT TOP 1 tipof, ope, nompax, moneda, cambio, atipoa, agencia FROM file_ WHERE num_file = '".$num_file."';";
$res = mssql_query($sql);
$row2 = mssql_fetch_array($res);
$tipof = $row2["tipof"];
$vendedor = $row2["ope"];
$nompax = $row2["nompax"];
$moneda = $row2["moneda"];
$cambio = $row2["cambio"];
$atipoa = $row2["atipoa"];
$agencia = $row2["agencia"];

// Extra.- Traer nombre Operador CTS
$sql = "SELECT TOP 1 nombre FROM opects WHERE codigo = '".$vendedor."'; ";
$res = mssql_query($sql);
$row4 = mssql_fetch_array($res);
$nombre_opects = $row4["nombre"];

// 2.- Comprobar si fue generado el Voucher para este "numero de file". //
$sql = "SELECT * FROM vouchea WHERE file_ = '".$tipof."-".$num_file."' and ctr_anu <> 'N' ORDER BY numdoc ASC ";
$res = mssql_query($sql);

if(mssql_num_rows($res) <= 0)
{
	$sql = " SELECT codigo, nombre, noches, tipoh, pa, ";
	$sql.= " convn, codser, ";
	$sql.= " linea, nconf, provee, ";
	$sql.= " Convert(varchar, in_, 106) as in_ ,";
	$sql.= " Convert(varchar, out, 106) as out ,";
	$sql.= " Convert(varchar, in_, 102) as in2, ";
	$sql.= " Convert(varchar, out, 102) as out2, ";
	$sql.= " pax_s, pax_d, pax_t, pax_q, pax_a, pax_i, pax_ca, pax_c, pax_c2 ";
	$sql.= " FROM det_file WHERE num_file = '".$num_file."' ";
	$sql.= " AND borra <> 'N' ";
	$sql.= " AND codigo <> 'CGO' AND codigo<>'COD' ";
	
        
	$res2 = mssql_query($sql);
	while($row = mssql_fetch_array($res2))
	{
		// Detalles para la GLOSA.
		$glosa1 = "";
		$glosa2 = ""; 
		$glosa3 = "";
		$suma_numpax = 0;
		
		// Cantidad de pasajeros (en general)
		$simple = 0;
		$doble = 0;
		$triple = 0;
		$cuadruple = 0;
		$adicional = 0;
		$adicional2 = 0;
		$child = 0;
		$child2 = 0;
		$infant = 0;
		
		// Guardar datos.
		$fecha_in = $row["in2"];
		$fecha_out = $row["out2"];
		$convenio = $row["convn"];
		$linea = $row["linea"];
		$nconf = $row["nconf"];
		$provee = $row["provee"];
		$codigo_detfile = $row["codigo"];
		$cod_ser = "";
		if($row["codigo"] == "HTL")
			$cod_ser = $row["codser"];
		
		// Calulcar cantidad de pasajeros
		if($row["pax_s"] <> "" && $row["pax_s"] <> "0")		// Pasajero simple.
			$simple = (int) $row["pax_s"];
		
		if($row["pax_d"] <> "" && $row["pax_d"] <> "0")		// Pasajero Doble
			$doble = (int) $row["pax_d"];
		
		if($row["pax_t"] <> "" && $row["pax_t"] <> "0")		// Pasajero Triple
			$triple = (int) $row["pax_t"];
		
		if($row["pax_q"] <> "" && $row["pax_q"] <> "0")		// Pasajero Cuadruple
			$cuadruple = (int) $row["pax_q"];
		
		if($row["pax_c"] <> "" && $row["pax_c"] <> "0")		// Pasajero Child 1
			$child = (int) $row["pax_c"];
		
		if($row["pax_c2"] <> "" && $row["pax_c2"] <> "0")	// Pasajero Child 2
			$child2 = (int) $row["pax_c2"];
		
		if($row["pax_i"] <> "" && $row["pax_i"] <> "0")		// Pasajero Infant
			$infant = (int) $row["pax_c2"];
		
		if($row["pax_a"] <> "" && $row["pax_a"] <> "0")		// Pasajero Adicional
			$adicional = (int) $row["pax_a"];
		
		if($row["pax_ca"] <> "" && $row["pax_ca"] <> "0")	// Pasajero Departamento
			$adicional2 = (int) $row["pax_ca"];
		
		$suma_numpax = $simple + $doble + $triple + $cuadruple + $child + $child2 + $infant + $adicional + $adicional2;	// Sumar valores
		if($row["codigo"] == "HTL")
		{
			// 2.1.- Noches de alojamiento
			$glosa1 = "0".$row['noches']." Noche(s) de Alojamiento";
			
			// 2.2.- Calcular y traer los pasajeros / Tipo de habitación / Plan Alimenticio
			$glosa2 = "";
			if($simple <> 0)		// Pasajero simple.
				$glosa2 = $glosa2."0".$simple." Single Room + ";
			
			if($doble <> 0)		// Pasajero Doble
				$glosa2 = $glosa2."0".$doble." Doble Room + ";
			
			if($triple <> 0)		// Pasajero Triple
				$glosa2 = $glosa2."0".$triple." Triple Room + ";
			
			if($cuadruple <> 0)	// Pasajero Cuadruple
				$glosa2 = $glosa2."0".$cuadruple." Cuadruple Room + ";
			
			if($child <> 0)		// Pasajero Child 1
				$glosa2 = $glosa2."0".$child." Child + ";
			
			if($child2 <> 0)	// Pasajero Child 2
				$glosa2 = $glosa2."0".$child2." Child 2 + ";
			
			if($infant <> 0)		// Pasajero Infant
				$glosa2 = $glosa2."0".$infant." Infant + ";
			
			if($adicional <> 0)		// Pasajero Adicional
				$glosa2 = $glosa2."0".$adicional." Adicional + ";
			
			if($adicional2 <> 0)	// Pasajero Adicional 2
				$glosa2 = $glosa2."01 Departamento + ";
			
			$longitud = strlen($glosa2);
			$glosa2 = substr($glosa2,0 , $longitud - 3);
			$glosa2.= "/".traerNombreHabitacion($row['tipoh'])."/".traerNombrePlanAlim($row['pa']);
			
			// 2.3.- Fecha de entrada y salida.
			$glosa3 = "IN: ".str_replace(' ', '-', $row['in_'])." / OUT: ".str_replace(' ', '-', $row['out']);
		}
		else
		{
                    
                    
                        
			$glosa1 = "";
			if($row['in_'])
			{
				$glosa1.= (str_replace(' ', '-', $row['in_']))." ";
			}
			$glosa1.= $row['nombre'];
			
			$glosa2 = "N° Pax: ".$suma_numpax;
			
			$glosa3 = "";
                    
		}
		$glosa_total = $glosa1 ."<br>".$glosa2."<br>".$glosa3;
		
		$sql = "SELECT folioimp FROM satbfol WHERE tipo = 'VOU'; ";
		$res = mssql_query($sql);
		$row3 = mssql_fetch_array($res);
		$folioimp = $row3['folioimp'];
		
		/**/
		$sql = "SELECT * FROM vouchea where numdoc='".$folioimp."' ";

		$res = mssql_query($sql);

		if(mssql_num_rows($res) <= 0)
		{
		/**/
			$sql_final = " INSERT INTO vouchea (numdoc, file_, fecha, numpax, fechain, ";	// 1
			$sql_final.= " fechaout, vendedor, rut, neto, convenio, ";						// 2
			$sql_final.= " depto, nompax, ctr_anu, centrali, codhtl, ";						// 3
			$sql_final.= " provee, suc, nombre2, imp, moneda, ";							// 4
			$sql_final.= " tipos, valconci, cambio, marca, tcambioa, ";						// 5
			$sql_final.= " ctr_mail, linea, codsicon, ctr_cbl, codser, ";					// 6
			$sql_final.= " old_provee, glosa, nconf, tipo) ";								// 7
			
			$sql_final.= " VALUES ('".$folioimp."', '".$tipof."-".$num_file."', '".date("Y-m-d")."', '".$suma_numpax."', '".$fecha_in."', ";	// 1
			$sql_final.= " '".$fecha_out."', '".$vendedor."', '', '', '".$convenio."', ";	// 2
			$sql_final.= " '".$atipoa."', '".$nompax."', '', '', '".$cod_ser."', ";	// 3
			$sql_final.= " '".$provee."', '0', '0', 'S', '".$moneda."', ";	// 4
			$sql_final.= " '".$codigo_detfile."', '0', '".$cambio."', '', '0', ";	// 5
			$sql_final.= " '', '".$linea."', '0', '', '0', ";	// 6
			$sql_final.= " '', '".$glosa_total."', '".str_replace("<br>", "'+CHAR(13)+'", $nconf)."', 'VO' )";	// 7
			
			mssql_query($sql_final);
			  
		}
		
		$sql = "UPDATE satbfol SET folioimp = (folioimp+1) WHERE tipo = 'VOU';";
		mssql_query($sql);
		
	}
}
else
{
	
}

$sql = "SELECT numdoc, file_, fecha, numpax, fechain, fechaout, vendedor, rut, neto, convenio, depto, nompax, ctr_anu, centrali, codhtl, provee, suc, nombre2, imp, moneda, tipos, valconci, cambio, marca, tcambioa, ctr_mail, linea, codsicon, ctr_cbl, codser, old_provee, glosa, nconf, tipo ";
$sql.= "FROM [vouchea] WHERE file_ = '".$tipof."-".$num_file."' AND ctr_anu <> 'N' AND tipos <> 'TAS' AND glosa IS NOT NULL AND CONVERT(NVARCHAR(MAX),glosa) <>'' ORDER BY numdoc ASC";


$res = mssql_query($sql);
$contador = 0;

?>
<style>
    .tablita
    {
        font-family:Arial;
        font-size:12px;
    }
    .tabla_negra
    {
        font-family:Arial;
        font-size:12px;
        border:0.8px solid #000000;
    }
    .celda_negra
    {
        text-align:center;
        vertical-align:middle;
        border:0.8px solid #000000;
    }
	
</style>

<?php
while($row = mssql_fetch_array($res))
{
	$vou_codhtl = (int)$row["codhtl"];
	$vou_provee = $row["provee"];
	$vou_tiposer = $row["tipos"];
	$tmp_operad='';
	// Adquirir datos para obtener proveedor, o hotel.
	if(($vou_codhtl > 0 && $vou_tiposer = "HTL") ||	($vou_codhtl == $vou_provee && $vou_codhtl > 0)){
		$sql_desc = "SELECT * FROM hotel WHERE codigo = '".$vou_codhtl."';";
		$res_desc = mssql_query($sql_desc);
		$row_desc = mssql_fetch_array($res_desc);
		
		$desc_1 = $row_desc["hotel"];
		$desc_2 = $row_desc["direc"];
		$desc_3 = $row_desc["ciudad"];
		$desc_fono = $row_desc["fono"];
		$desc_fonoe = $row_desc["femergen"];
		$tmp_hotel = $row_desc["hotel"];
	}
	elseif($vou_codhtl == 0 && $vou_tiposer <> "HTL")
	{
		$sql_desc = "SELECT * FROM operad WHERE codigo = '".$vou_provee."';";
		$res_desc = mssql_query($sql_desc);
		$row_desc = mssql_fetch_array($res_desc);
		
		$desc_1 = $row_desc["nombre"];
		$desc_2 = $row_desc["direc"];
		$desc_3 = $row_desc["ciudad"];
		$desc_fono = $row_desc["fono"];
		$desc_fonoe = $row_desc["femergen"];
		$tmp_operad = $row_desc["nombre"];
	}
	
	// Obtener PRE-PAGO.
	if($row["codhtl"] == $row["provee"] || $row["codhtl"] == "0" || $row["codhtl"] == "")
	{
            $desc_empresa = ENT_NAME;
	}
	elseif($row["provee"] > 0)
	{
            $desc_empresa = $tmp_hotel;
	}
	else
	{
            $desc_empresa = $tmp_operad;
	}
	?>
    <table class="tabla_negra" cellpadding="0" cellspacing="0">
    <tr>
    	<td rowspan="2" class="celda_negra" style="text-align:center;">
        
        <div style="width:350px; margin-top:-15px; margin-bottom:10px;">
        <table style="text-align:left;" align="left">
        	<tr>
            	<td colspan="4" align="left">
                        <!-- No poner url Completa!! -->
                        <img src="<?php echo $ruta_img; ?>logo.jpg" height="86" />
                </td>
            </tr>
            <tr>
            

            	<td>Tel&eacute;fono: </td>
                <td align="left"><?php echo ENT_FONO ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n: </td>
                <td colspan="3"><?php echo ENT_DIREC ?>-<?php echo ENT_COMUNA ?>-<?php echo ENT_CIUDAD ?></td>
            </tr>
            
           <!-- <tr>
            

            	<td>Web:</td>
                <td align="left"><?php echo ENT_WEB ?></td>
                <td></td>
                <td></td>
            </tr> -->
        </table>	
        </div>
        
        </td>
        <td class="celda_negra" style="width:160px;">
       		Voucher: <strong><?php echo $row["numdoc"]; ?></strong>
        </td>
        <td class="celda_negra" style="width:160px;">
        	File: <strong><?php echo $numFile; ?></strong>
        </td>
    </tr>
    
    
    <tr>
    	<td colspan="2" height="100px" class="celda_negra">
            Issue Data: <strong><?php
            echo date("d-M-Y", strtotime($row["fecha"])); ?></strong>
        </td>
    </tr>
    
    
    
    <tr>
    	<td colspan="3" class="celda_negra">
        	<table id="tablita2" width="98%" style="font-family:Arial; font-size:12px; text-align:left;">
            	<tr>
                	<td width="10%">To:</td>
                    <td width="55%"><strong><?php echo $desc_1; ?></strong></td>
                    <td width="35%">Mr/Ms <strong><?php echo $row["nompax"]; ?></strong></td>
                </tr>
                <tr>
                	<td></td>
                    <td><div style="text-align:left; width:330px;"><strong><?php echo $desc_2; ?></strong></div></td>
                    <td>Passenger(s) <strong><?php echo $row["numpax"]; ?></strong></td>
                </tr>
                <tr>
                	<td></td>
                    <td colspan="2"><strong><?php echo $desc_3; ?></strong></td>
                </tr>
                <tr>
                	<td>Phone: </td>
                    <td colspan="2"><strong><?php echo $desc_fono; ?></strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; En caso de imprevisto en destino, comun&iacute;quese al fono: <strong><?php echo $desc_fonoe; ?></strong></td>
                    
                </tr>
            </table>
        </td>
    </tr>
    
    
    
    
    <tr>
    	<td colspan="3" align="center" class="celda_negra">
        	<table id="tablita2" style="font-family:Arial; font-size:12px; text-align:left; width:99%;">
            	<tr>
                	<td colspan="2" align="left">
                    <div style="width:450px;"><strong><?php echo str_replace("\n", "<br>", $row['glosa']); ?>
                    <!-- 06 Noche(s) de Alojamiento <br />1 Doble Room/STANDARD/TODO INCLUIDO <br />IN: 24-AGO-2013 - OUT: 30-AGO-2013-->
                    </strong></div></td>
                    
                    <td rowspan="3" style="text-align:right;">
                    <div style="width:150px; text-align:right; margin-top:-30px;">
                    	&nbsp; <?php 
						// Comprobar si tiene imagen asignada el CLIENTE
						$sql = "SELECT TOP 1 imagenv FROM agenc_na WHERE agencia = '".$agencia."';";
						$res_temp = mssql_query($sql);
						if(mssql_num_rows($res_temp) > 0)
						{
							$row_temp = mssql_fetch_array($res_temp);	
							if($row_temp["imagenv"] <> NULL && trim($row_temp["imagenv"]) <> "")
							echo '<img src="../logos_cliente/'.$row_temp["imagenv"].'" style="width:80px; height:60px;" />';	
						}
						?>
                    </div></td>
                    
                    
                </tr>
                <tr>
                	<td><div style="width:150px;">&nbsp;</div></td>
                    <td><div style="width:300px;">&nbsp;</div></td>
                </tr>
                <tr>
                	<td>Prepaid By: </td>
                    <td><strong><?php echo $desc_empresa; ?></strong></td>
                </tr>
                <tr valign="top">
                	<td>Conf. Number: </td>
                    <td><strong><?php echo $row["nconf"]; ?></strong></td>
                    <td><strong><?php echo $nombre_opects; ?></strong> <br /><?php echo ENT_NAME; ?></td>
                </tr>
            </table>
        <!-- <div style="width:750px;" align="center">&nbsp;</div> -->        </td>
    </tr>
    
    
</table>
<br />
<img src="<?php echo $ruta_img; ?>tijeras_derecha.jpg" style="width:20px; height:20px;"/>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <img src="<?php echo $ruta_img; ?>tijeras_izquierda.jpg" style="width:20px; height:20px;"/> 
<br /><br />
    <?php
}
?>