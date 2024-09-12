<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;
    
$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();

$language = \Config\Services::language();
$language->setLocale("ca");

$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('ADR-ISBA', $convocatoria);
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
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (ADR Balears) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("RESOLUCIÓN PAGO SIN REQUERIMIENTO");
$pdf->SetSubject("RESOLUCIÓN PAGO SIN REQUERIMIENTO");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ISBA, PIMES, ADR Balears, GOIB");	

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

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 12);
$html = "Document: resolució de pagament<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Codi SIA: ".$data['configuracionLinea']['codigoSIA']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 120, 40, $html, 0, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$intro = lang('isba_11_resolucion_pago_y_justificacion.intro');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('isba_11_resolucion_pago_y_justificacion.fets_tit') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 2);
$parrafo_1 = str_replace("%FECHARESPRESIDI%", date_format(date_create($data['configuracionLinea']['fechaResPresidIDI']),"d/m/Y"), lang('isba_11_resolucion_pago_y_justificacion.fets_1_2_3_4_5'));
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $parrafo_1);
$parrafo_1 = str_replace("%FECHAPUBBOIB%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%CONVO%", $convocatoria, $parrafo_1);
$parrafo_1 = str_replace("%FECHASOL%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$parrafo_1 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_INTERESES%", money_format("%i ", $data['expediente']['intereses_ayuda_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_AVAL%", money_format("%i ", $data['expediente']['coste_aval_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $parrafo_1);
$parrafo_1 = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_isba']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_ESTUDIO%", money_format("%i ", $data['expediente']['gastos_aval_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_NOTIFICACION_PR_PROV%", date_format(date_create($data['expediente']['fecha_not_propuesta_resolucion_prov']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_NOTIF_PRPROV%", date_format(date_create($data['expediente']['fecha_not_propuesta_resolucion_prov']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_PROP_RESOL_PROVISIONAL%", date_format(date_create($data['expediente']['fecha_firma_propuesta_resolucion_prov']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_PR_DEFINITIVA%", date_format(date_create($data['expediente']['fecha_firma_propuesta_resolucion_def']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_NOTIF_PRPDEF%", date_format(date_create($data['expediente']['fecha_not_propuesta_resolucion_def']),"d/m/Y"), $parrafo_1);
$html = $parrafo_1;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$currentY = $pdf->getY();
$pdf->setY($currentY + 30);

$parrafo_7 = str_replace("%FECHA_SEDE_JUSTIFICACION%", date_format(date_create($data['expediente']['fecha_REC_justificacion']),"d/m/Y"), lang('isba_11_resolucion_pago_y_justificacion.fets_7'));
$parrafo_7 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_7);
$parrafo_7 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_7);
$parrafo_7 = str_replace("%FECHA_RESOL_CONCE%", date_format(date_create($data['expediente']['fecha_firma_res']),"d/m/Y"), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTE_INTERESES%", money_format("%i ", $data['expediente']['intereses_ayuda_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTE_AVAL%", money_format("%i ", $data['expediente']['coste_aval_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTE_ESTUDIO%", money_format("%i ", $data['expediente']['gastos_aval_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_isba']),"d/m/Y"), $parrafo_7);
$parrafo_7 = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $parrafo_7);
$html = '<ol start="6">'.$parrafo_7.'</ol>';
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_2 = lang('isba_11_resolucion_pago_y_justificacion.fundamentosDeDerecho_tit');
$html = "<b>".$parrafo_2."</b>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_5 = lang('isba_11_resolucion_pago_y_justificacion.fundamentosDeDerechoTxt');
$html = $parrafo_5;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 20);
$parrafo_6 = lang('isba_11_resolucion_pago_y_justificacion.dicto');
$html = $parrafo_6;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_6 = lang('isba_11_resolucion_pago_y_justificacion.propuesta_tit');
$html = "<b>".$parrafo_6."</b>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$resolucion = lang('isba_11_resolucion_pago_y_justificacion.resolucion');
$resolucion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $resolucion);
$resolucion = str_replace("%NIF%", $data['expediente']['nif'], $resolucion);
$resolucion = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), $resolucion);
$resolucion = str_replace("%IMPORTE_INTERESES%", money_format("%i ", $data['expediente']['intereses_ayuda_solicita_idi_isba']), $resolucion);
$resolucion = str_replace("%IMPORTE_AVAL%", money_format("%i ", $data['expediente']['coste_aval_solicita_idi_isba']), $resolucion);
$resolucion = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_isba']),"d/m/Y"), $resolucion);
$resolucion = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $resolucion);
$resolucion = str_replace("%IMPORTE_ESTUDIO%", money_format("%i ", $data['expediente']['gastos_aval_solicita_idi_isba']), $resolucion);

$html = $resolucion;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$resolucion_4 = lang('isba_11_resolucion_pago_y_justificacion.recursos_tit');
$html = "<b>".$resolucion_4."</b>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion_5 = lang('isba_11_resolucion_pago_y_justificacion.recursos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $resolucion_5 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);

$firma = lang('isba_11_resolucion_pago_y_justificacion.firma');
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_res_pago_y_justificacion_adr_isba.pdf', 'F');
