<?php

$arrayHtml = array();
$prob = array();
$prob2 = array();
$email = array();

foreach ($hotel as $val) {
    $prob[] = $val->getProve();
}
foreach (array_unique($prob) as $b) {

    $prob2[] = $b;
}
$cont = 0;
foreach ($hotel as $key => $h) {
    if (isset($prob2[$cont]) && $prob2[$cont] == $h->getProve()) {
        if ($cont > 0) {
            foreach ($nodosHTML as $nombreNodo => $valorNodo):
                $mC_HTML = str_replace('{' . $nombreNodo . '}', $valorNodo, $mC_HTML);
            endforeach;
            $arrayHtml[] = $mC_HTML;
        }

        $mC_HTML = '';
        $mC_HTML = file_get_contents(ROOT . 'views' . DS . 'programas' . DS . 'centerBox' . DS . 'mailHotel.phtml');
        $nodosHTML['ciudad'] = $ciudad;
        $nodosHTML['fecha'] = Functions::convertirFechaCarta($h->getDia());
        $nodosHTML['to'] = $h->getNombre();
        $nodosHTML['toDirec'] = $h->getDireccion();
        $nodosHTML['hora'] = $h->getHoraDia();
        $nodosHTML['todCiudad'] = $h->getCiudad();
        $nodosHTML['pasajero'] = $h->getNomPax();
        $nodosHTML['file'] = $h->getFile();
        $nodosHTML['solicitud'] = $solicitud;
        $nodosHTML['logo'] = $logo;
        $nodosHTML['correoProveedor'] = $correo;
        $nodosHTML['fonoProveedor'] = $fono;
        $nodosHTML['nombreProveedor'] = $nombre;
        $habitacion = '';
        $nodosHTML['glosa'] = '';
        $nodosHTML['convenio'] = '';
        $email[]=$h->getEmail();
        $cont++;
    }
    $totalPax = $h->getPax_s() + $h->getPax_d() + $h->getPax_t() + $h->getPax_q() + $h->getPax_c() + $h->getPax_c2() + $h->getPax_ca();
    if ($h->getCodigo() == 'HTL') {
        if ($h->getPax_s() > 0) {
            $habitacion.='0' . $h->getPax_s() . ' Single(s) ';
        }
        if ($h->getPax_d() > 0) {
            
            if($habitacion !=''){
                $habitacion .=' + ';
            }
            $habitacion.='0' . $h->getPax_d() / 2 . ' Doble(s) ';
        }
        if ($h->getPax_t() > 0) {
            
            if($habitacion !=''){
                $habitacion .=' + ';
            }
            $habitacion.='0' . $h->getPax_t() / 3 . " Triple(s) ";
        }
        if ($h->getPax_q() > 0) {
            
            if($habitacion !=''){
                $habitacion .=' + ';
            }
            $habitacion.='0' . $h->getPax_q() / 4 . " Quadruple(s) ";
        }
        $totalchild = $h->getPax_c() + $h->getPax_c2();
        if ($totalchild > 0) {
            
            if($habitacion !=''){
                $habitacion .=' + ';
            }
            $habitacion.='0' . $totalchild . " Child(s) ";
        }
        if ($h->getPax_ca() > 0) {
            
            if($habitacion !=''){
                $habitacion .=' + ';
            }
            $habitacion.=' 01 Departamento(s) ';
        }

        $nodosHTML['glosa'] .= '<tr>'
                . '<td colspan="3"><strong><label style="font-size:25px;">'
                . '&middot;</label></strong> ' . $habitacion . ' / ' . $h->getTipoH() . '  htl ' . $h->getHtl() . ' / ' . $h->getPa() . ' </td>'
                . ' </tr>'
                . '<tr>'
                . '<td colspan="3">&nbsp;&nbsp;&nbsp;IN: ' . $h->getIn_() . '  / OUT: ' . $h->getOut() . ' - ' . $totalPax . ' Pax(s)</td>'
                . ' </tr>'
                . '<tr>'
                . '<td colspan="3">&nbsp;&nbsp;&nbsp;(' . $estado . ')</td></tr>';
        if($h->getConvenio()!=''){
        $nodosHTML['glosa'].='
                   <tr>
                   <td colspan="3">&nbsp;&nbsp;&nbsp; Tarifa: &nbsp;' . $h->getConvenio() . '
                   </td>
                   </tr>';
        }
        $habitacion = '';
    } else {
        $fechaIN = '';
        $fechaOut = '';
        if ($h->getIn_() != '' && $h->getIn_() != '01/01/1900') {
            $fechaIN = ' ' . $h->getIn_();
        }
        if ($h->getOut() != '' && $h->getOut() != '01/01/1900') {
            $fechaOut = '  - ' . $h->getOut();
        }

        $vuelo = '';
        if ($h->getVuelo() != '') {
            $vuelo = ' IN: ' . $h->getVuelo();
        }
        $hora = '';
        if ($h->getHora() != '') {
            $hora = ' HORA: ' . $h->getHora();
        }
        $nodosHTML['glosa'] .= '<tr>'
                . '<td colspan="3"><strong><label style="font-size:25px;">'
                . '&middot;</label></strong>' . $fechaIN . $fechaOut . '  ' . $h->getGlosa() . '  - ' . $totalPax . ' Pax(s) '. $vuelo . ' ' . $hora . '</td></tr>';
    }



    if (count($hotel) == $key + 1) {
        foreach ($nodosHTML as $nombreNodo => $valorNodo):
            $mC_HTML = str_replace('{' . $nombreNodo . '}', $valorNodo, $mC_HTML);
        endforeach;
        $arrayHtml[] = $mC_HTML;
    }
}

?>