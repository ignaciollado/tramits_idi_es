<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>
<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
    //obtengo los datos de la convocatoria
    use App\Models\ConfiguracionModel;
    $configuracion = new ConfiguracionModel();
    $data['configuracion'] = $configuracion->where('convocatoria_activa', 2)->first();
    //obtengo los datos de la solicitud
    use App\Models\ExpedientesModel;
    $expediente = new ExpedientesModel();
    $data['expediente'] = $expediente->where('id', $id)->first();
    //obtengo los datos del documento
    $db = \Config\Database::connect();
	$query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=".$id." AND convocatoria='".$convocatoria."' AND tipo_tramite='".$programa."'");
    foreach ($query->getResult() as $row)
        {
        $nif = $row->cifnif_propietario;
        }
        
    $session = session();
        if ($session->has('logged_in')) {  
           $pieFirma =  $session->get('full_name');
        }
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_idi_conselleria_ils.jpg';
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
        $this->Image($image_file, 38, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
        $this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("RESOLUCIÓN DE CONCESIÓN ILS");
$pdf->SetSubject("RESOLUCIÓN DE CONCESIÓN ILS");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, CAIB");	

$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: resolució de concessió<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
$html .= "Codi SIA: ".$data['configuracion']['codigoSIA']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 120, 40, $html, 0, 1, 1, true, 'J', true);
$pdf->SetFont('helvetica', '', 11);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_ils_resolucion_concesion_sin_req_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('message_lang.doc_ils_resolucion_concesion_sin_req_antecedentes') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_1 = lang('message_lang.doc_ils_resolucion_concesion_sin_req_p1');
$html = "<ol>";
$html .= "<li>". $parrafo_1 ."</li>";
$html .= "<br>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , lang('message_lang.doc_ils_resolucion_concesion_sin_req_p2'));
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_2);
$parrafo_2 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_2);
$parrafo_2 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_2);
$html .= "<li>". $parrafo_2 ."</li>";
$html .= "<br>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_3 = str_replace("%FECHAINFORMEFAV%", date_format(date_create($data['expediente']['fecha_infor_fav']),"d/m/Y") ,lang('message_lang.doc_ils_resolucion_concesion_sin_req_p3'));
$html .= "<li>". $parrafo_3 ."</li>";
$html .= "</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$resolucion = lang('message_lang.doc_ils_resolucion_concesion_sin_req_resolucion');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $resolucion ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$resolucion_1 = lang('message_lang.doc_ils_resolucion_concesion_sin_req_resolucion_1');
$resolucion_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $resolucion_1);
$resolucion_1 = str_replace("%NIF%", $data['expediente']['nif'], $resolucion_1);
$resolucion_1 = str_replace("%FECHADESDECONCESION%", date_format(date_create($data['expediente']['fecha_adhesion_ils']),"d/m/Y"), $resolucion_1);
$dateTo =  date_add(date_create($data['expediente']['fecha_adhesion_ils']), date_interval_create_from_date_string("2 years") );
$resolucion_1 = str_replace("%FECHAHASTACONCESION%", date_format($dateTo,"d/m/Y"), $resolucion_1);

$html = "<ol>";
$html .= "<li>". $resolucion_1 ."</li>";
$html .= "<br>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion_2 = lang('message_lang.doc_ils_resolucion_concesion_sin_req_resolucion_2');
$html .= "<li>". $resolucion_2 ."</li>";
$html .= "<br>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion_3 = lang('message_lang.doc_ils_resolucion_concesion_sin_req_resolucion_3');
$html .= "<li>". $resolucion_3 ."</li>";
$html .= "</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.jpg';
$pdf->Image($image_file, 15, 15, '', '40', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 25);
$recursos = lang('message_lang.doc_ils_resolucion_concesion_sin_req_inter_recursos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $recursos ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos_texto = lang('message_lang.doc_ils_resolucion_concesion_sin_req_inter_recursos_texto');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $recursos_texto ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$firma = lang('message_lang.doc_ils_resolucion_concesion_sin_req_firma');
$firma = str_replace("%BOIBNUM%", $data['configuracion']['num_BOIB'], $firma);
$firma = str_replace("%DIRECTORGENERAL%", $data['configuracion']['directorGeneralPolInd'] , $firma);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $firma ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');
// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_resolucion_concesion_adhesion_ils.pdf', 'F');
