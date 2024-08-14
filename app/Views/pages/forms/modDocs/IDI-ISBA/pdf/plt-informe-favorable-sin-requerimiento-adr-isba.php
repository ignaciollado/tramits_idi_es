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
foreach ($query->getResult() as $row) {
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
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 10, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (ADR Balears) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("INFORME FAVORABLE SIN REQUERIMIENTO");
$pdf->SetSubject("INFORME FAVORABLE SIN REQUERIMIENTO");
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

// ------------------------------------------ Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ----------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: informe favorable<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
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
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('isba_3_informe_favorable_sin_requerimiento.intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('isba_3_informe_favorable_sin_requerimiento.hechos_tit') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1_2 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('isba_3_informe_favorable_sin_requerimiento.hechos_1_2_3_4'));
$parrafo_1_2 = str_replace("%CONVO%", $convocatoria, $parrafo_1_2);
$parrafo_1_2 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $parrafo_1_2);
$parrafo_1_2 = str_replace("%FECHASOLICITUD%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $parrafo_1_2);
$parrafo_1_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1_2);
$parrafo_1_2 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1_2);
$parrafo_1_2 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_prestamo']), $parrafo_1_2);
$parrafo_1_2 = str_replace("%IMPORTE_INTERESES%", $data['expediente']['intereses_ayuda_solicita_idi_isba'], $parrafo_1_2);
$parrafo_1_2 = str_replace("%IMPORTE_AVAL%", $data['expediente']['coste_aval_solicita_idi_isba'], $parrafo_1_2);
$parrafo_1_2 = str_replace("%IMPORTE_APERTURA%", $data['expediente']['gastos_aval_solicita_idi_isba'], $parrafo_1_2);
/* if ($ultimaMejora[2] && $ultimaMejora[3]) { */
    $parrafo_1_2 = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , $parrafo_1_2);
    $parrafo_1_2 = str_replace("%REFRECM%", $ultimaMejora[3], $parrafo_1_2);
    $html = $parrafo_1_2;
/* } */

/* $html .= $parrafo_1_2; */
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
// $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', 'url', 'align', false (resize), 300 (dpi), 'align (L (left) C (center) R (righ)', false, false, 0, $fitbox, false, false);
// align: T (top), M (middle), B (bottom), N (next line)
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 30);
$parrafo_pre = lang('isba_3_informe_favorable_sin_requerimiento.conclusion_tit');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_pre ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_conclusion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('isba_3_informe_favorable_sin_requerimiento.conclusionTxt'));
$parrafo_conclusion = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_conclusion);
$parrafo_conclusion = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_prestamo']), $parrafo_conclusion);
$parrafo_conclusion = str_replace("%IMPORTE_INTERESES%", $data['expediente']['intereses_ayuda_solicita_idi_isba'], $parrafo_conclusion);
$parrafo_conclusion = str_replace("%IMPORTE_AVAL%", $data['expediente']['coste_aval_solicita_idi_isba'], $parrafo_conclusion);
$parrafo_conclusion = str_replace("%IMPORTE_APERTURA%", $data['expediente']['gastos_aval_solicita_idi_isba'], $parrafo_conclusion);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_conclusion ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$firma = lang('isba_3_informe_favorable_sin_requerimiento.firma');
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_informe_favorable_sin_requerimiento_adr_isba.pdf', 'F');