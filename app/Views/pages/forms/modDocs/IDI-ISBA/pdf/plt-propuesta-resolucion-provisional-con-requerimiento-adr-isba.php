<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;
use App\Models\MejorasExpedienteModel;
        
$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();
$mejorasSolicitud = new MejorasExpedienteModel();

$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('ADR-ISBA', $convocatoria);
$data['expediente'] = $expediente->where('id', $id)->first();

$data['ultimaMejora'] = $mejorasSolicitud->selectLastMejorasExpediente($id);
$ultimaMejora = explode("##",  $data['ultimaMejora']);

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
        $this->Image($image_file, 10, 10, 85, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$pdf->SetTitle("proposta de resolució provisional con requerimiento");
$pdf->SetSubject("proposta de resolució provisional con requerimiento");
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

$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: proposta de resolució provisional<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Codi SIA: ".$data['configuracionLinea']['codigoSIA']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 120, 40, $html, 0, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.antecedentes_tit') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.antecedentes_1_2_3_4'));
$parrafo_1 = str_replace("%FECHARESPRESIDI%", date_format(date_create($data['configuracionLinea']['fechaResPresidIDI']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%BOIBFECHA%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $parrafo_1);
$parrafo_1 = str_replace("%FECHASOLICITUD%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHA_NOTIFICACION_REQUERIMIENTO%", date_format(date_create($data['expediente']['fecha_requerimiento_notif']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHAENMIENDA%", date_format(date_create($data['expediente']['fecha_REC_enmienda']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_INTERESES%", money_format("%i ", $data['expediente']['intereses_ayuda_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_AVAL%", money_format("%i ", $data['expediente']['coste_aval_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_ESTUDIO%", money_format("%i ", $data['expediente']['gastos_aval_solicita_idi_isba']), $parrafo_1);
$parrafo_1 = str_replace("%NOMBRE_BANCO%", $data['expediente']['nom_entidad'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_PRESTAMO%", money_format("%i ", $data['expediente']['importe_prestamo']), $parrafo_1);
$parrafo_1 = str_replace("%FECHAFIRMARESDESESTIMIENTO%", date_format(date_create($data['expediente']['fecha_firma_resolucion_desestimiento']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$html = $parrafo_1;

if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $parrafo_1m = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , lang('isba_5_propuesta_resolucion_prov_favorable.antecedentes_m'));
    $parrafo_1m = str_replace("%REFRECM%", $ultimaMejora[3], $parrafo_1m);
    $html .= $parrafo_1m;
}
$html = "<ol>".$html."</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$parrafo_2 = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.antecedentes_6_9');
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_2);
$parrafo_2 = str_replace("%FECHAINFORME%", date_format(date_create($data['expediente']['fecha_infor_fav_desf']),"d/m/Y"), $parrafo_2);
if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $html = '<ol start="7">'.$parrafo_2.'</ol>';
} else {
    $html = '<ol start="6">'.$parrafo_2.'</ol>';
}
$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_2 = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.fundamentosDeDerecho_tit');
$html = $parrafo_2;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_3 = str_replace("%FECHAENMIENDA%", date_format(date_create($data['expediente']['fecha_REC_enmienda']),"d/m/Y") , lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.fundamentosDeDerechoTxt'));
$html =$parrafo_3;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$parrafo_4 = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.fundamentosDeDerechoTxt_8_9');
$html = '<ol start="6">'.$parrafo_4.'</ol>';
$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_5 = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.propuestaresoluciondef_tit');
$html = $parrafo_5;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_6 = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.propuestaresoluciondefTxt');
$html = $parrafo_6;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_7 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.propuestaresoluciondef_1_2_3'));
$parrafo_7 = str_replace("%IMPORTE_INTERESES%", money_format("%i ", $data['expediente']['intereses_ayuda_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTE_AVAL%", money_format("%i ", $data['expediente']['coste_aval_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%IMPORTE_ESTUDIO%", money_format("%i ", $data['expediente']['gastos_aval_solicita_idi_isba']), $parrafo_7);
$parrafo_7 = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_idi_isba']),"d/m/Y") , $parrafo_7);
$parrafo_7 = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $parrafo_7);
$parrafo_7 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_7);
$parrafo_7 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_7);
$html = $parrafo_7;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
/* $pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); */

$parrafo_8 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importe_ayuda_solicita_idi_isba']), lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.propuestaresoluciondef_4_5'));
$html = '<ol start="4">'.$parrafo_8.'</ol>';
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$firma = lang('isba_6_propuesta_resolucion_prov_favorable_con_requerimiento.firma');
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_prop_res_provisional_con_requerimiento_adr_isba.pdf', 'F');