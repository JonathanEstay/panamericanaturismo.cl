<?php
class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;

/*
function Header()
{
    global $title;

    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Calculamos ancho y posición del título.
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    //Colores de los bordes, fondo y texto
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(220,50,50);
    //Ancho del borde (1 mm)
    $this->SetLineWidth(1);
    //Título
    $this->Cell($w,9,$title,1,1,'C',1);
    //Salto de línea
    $this->Ln(10);
}
*/

function Footer()
{
    //Posición a 1,5 cm del final
    $this->SetY(-15);
    //Arial itálica 8
    $this->SetFont('Arial','I',8);
    //Color del texto en gris
    $this->SetTextColor(128);
    //Número de página
	$var_temp= "Página";
    $this->Cell(0,10,mb_convert_encoding($var_temp, "ISO-8859-1", "UTF-8")." ".$this->PageNo(),0,0,'C');
}

function ChapterTitle($num,$label)
{
    //Arial 12
    $this->SetFont('Arial','',12);
    //Color de fondo
    $this->SetFillColor(200,220,255);
    //Título
    $this->Cell(0,6,"Capítulo $num : $label",0,1,'L',1);
    //Salto de línea
    $this->Ln(4);
}

function ChapterBody($file)
{
    //Leemos el fichero
    $f=fopen($file,'r');
    $txt=fread($f,filesize($file));
    fclose($f);
    //Times 12
    $this->SetFont('Times','',12);
    //Imprimimos el texto justificado
    $this->MultiCell(0,5,$txt);
    //Salto de línea
    $this->Ln();
    //Cita en itálica
    $this->SetFont('','I');
    $this->Cell(0,5,'(fin del extracto)');
}


function PrintChapter($num,$title,$file)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}

function PDF($orientation='P',$unit='mm',$format='A4')
{
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}

function WriteHTML($html)
{
    //Intérprete de HTML
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Etiqueta
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extraer atributos
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function SetCol($col)
{
    //Establecer la posición de una columna dada
    $this->col=$col;
    $x=10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Método que acepta o no el salto automático de página
    if($this->col<2)
    {
        //Ir a la siguiente columna
        $this->SetCol($this->col+1);
        //Establecer la ordenada al principio
        $this->SetY($this->y0);
        //Seguir en esta página
        return false;
    }
    else
    {
        //Volver a la primera columna
        $this->SetCol(0);
        //Salto de página
        return true;
    }
}

function OpenTag($tag,$attr)
{
    //Etiqueta de apertura
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    //Etiqueta de cierre
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}

function SetStyle($tag,$enable)
{
    //Modificar estilo y escoger la fuente correspondiente
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
    //Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

//Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(40,35,40,45);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//Tabla coloreada
function FancyTable($header,$data)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
    $w=array(40,35,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}

}
?>