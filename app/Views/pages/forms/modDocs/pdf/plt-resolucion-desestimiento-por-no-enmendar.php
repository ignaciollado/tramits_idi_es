<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>
<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;
/* use App\Models\MejorasExpedienteModel; */

$language = \Config\Services::language();
$language->setLocale("ca");

$modelConfig = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();
/* $mejorasSolicitud = new MejorasExpedienteModel(); */

$data['configuracion'] = $modelConfig->configuracionGeneral();
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('XECS', $convocatoria);
$data['expediente'] = $expediente->where('id', $id)->first();

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

if ($data['expediente']['tipo_tramite'] == "Programa I") {
	$tipo_tramite = lang('message_lang.programaiDigital');
}
else if ($data['expediente']['tipo_tramite'] == "Programa II") {
	$tipo_tramite = lang('message_lang.programaiExporta');
}
else if ($data['expediente']['tipo_tramite'] == "Programa III actuacions corporatives") {
	$tipo_tramite = lang('message_lang.programaiSostenibilitatCorp');
}
else if ($data['expediente']['tipo_tramite'] == "Programa III actuacions producte") {
	$tipo_tramite = lang('message_lang.programaiSostenibilitatProd');
}
else if ($data['expediente']['tipo_tramite'] == "Programa IV") {
	$tipo_tramite = lang('message_lang.programaiGestio');
}

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 10, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetX(5);

        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
        $this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("AGENCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (ADR Balears) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("RESOLUCIÓN DE DESESTIMIENTO POR NO ENMENDAR");
$pdf->SetSubject("RESOLUCIÓN DE DESESTIMIENTO POR NO ENMENDAR");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, ADR Balears, GOIB");	

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
$fmt = new NumberFormatter( 'es_ES', NumberFormatter::CURRENCY );
// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: resolució desistiment<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
$html .= "Programa: " .$tipo_tramite."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Codi SIA: ".$data['configuracionLinea']['codigoSIA']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 9);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 100, 40, $html, 0, 1, 1, true, 'J', true);
$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('2_resolucion_desestimiento_por_no_enmendar.2_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". lang('2_resolucion_desestimiento_por_no_enmendar.2_antecedentes_tit') ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$antecedentes_1_2 = str_replace("%FECHARESPRESIDI%", date_format(date_create($data['configuracionLinea']['fechaResPresidIDI']),"d/m/Y"), lang('2_resolucion_desestimiento_por_no_enmendar.2_antecedentes_1_2'));
$antecedentes_1_2 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%CONVO%", $convocatoria, $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%BOIBFECHA%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%FECHASOL%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%NIF%", $data['expediente']['nif'], $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%IMPORTE%", $fmt->formatCurrency($data['expediente']['importeAyuda'], "EUR"), $antecedentes_1_2);
$antecedentes_1_2 = str_replace("%PROGRAMA%", $tipo_tramite, $antecedentes_1_2);
$html = $antecedentes_1_2;

if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $antecedentes_3_m = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , lang('2_resolucion_desestimiento_por_no_enmendar.2_antecedentes_3_m'));
    $antecedentes_3_m = str_replace("%NUMRECM%", $ultimaMejora[3], $antecedentes_3_m);
    $html .= $antecedentes_3_m;
}

$antecedentes_4_5 = str_replace("%DATANOTREQ%", date_format(date_create($data['expediente']['fecha_requerimiento_notif']),"d/m/Y") , lang('2_resolucion_desestimiento_por_no_enmendar.2_antecedentes_4_5'));
$antecedentes_4_5 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $antecedentes_4_5);
$antecedentes_4_5 = str_replace("%NIF%", $data['expediente']['nif'], $antecedentes_4_5);
$antecedentes_4_5 = str_replace("%IMPORTE%", $fmt->formatCurrency($data['expediente']['importeAyuda'], "EUR"), $antecedentes_4_5);
$antecedentes_4_5 = str_replace("%PROGRAMA%", $tipo_tramite, $antecedentes_4_5);
$html .= $antecedentes_4_5;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 30);
$req_fundamentos = lang('2_resolucion_desestimiento_por_no_enmendar.2_fundamentosDeDerecho_tit');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'><b>". $req_fundamentos ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$req_fundamentos_1 = lang('2_resolucion_desestimiento_por_no_enmendar.2_fundamentosDeDerechoTxt');
$html = $req_fundamentos_1;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 30);
$dicto = lang('2_resolucion_desestimiento_por_no_enmendar.2_dicto');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $dicto ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion = lang('2_resolucion_desestimiento_por_no_enmendar.2_resolucion_tit');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'><b>". $resolucion ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion = lang('2_resolucion_desestimiento_por_no_enmendar.2_resolucion');
$resolucion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'] , $resolucion);
$resolucion = str_replace("%NIF%", $data['expediente']['nif'] , $resolucion);
$html = $resolucion;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$recursos = lang('2_resolucion_desestimiento_por_no_enmendar.2_recursos_tit');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'><b>". $recursos ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos_1 = lang('2_resolucion_desestimiento_por_no_enmendar.2_recursos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $recursos_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$firma = lang('2_resolucion_desestimiento_por_no_enmendar.2_firma');
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $firma);
$firma = str_replace("%DGERENTE%", $data['configuracion']['directorGerenteIDI'], $firma);
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_res_desestimiento_por_no_enmendar.pdf', 'F');
