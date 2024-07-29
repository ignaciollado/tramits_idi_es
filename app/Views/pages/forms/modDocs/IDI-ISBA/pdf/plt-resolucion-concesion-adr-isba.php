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
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('IDI-ISBA', $convocatoria);
$data['ultimaMejora'] = $mejorasSolicitud->selectLastMejorasExpediente($id);
$ultimaMejora = explode("##",  $data['ultimaMejora']);
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
$pdf->SetTitle("RESOLUCIÓN CONCESIÓN CON REQUERIMIENTO");
$pdf->SetSubject("RESOLUCIÓN CONCESIÓN CON REQUERIMIENTO");
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

$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html =  "Document: resolució de concessió<br>amb requeriment<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
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
$pdf->SetFont('helvetica', '', 11);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('isba_9_resolucion_concesion.intro'));
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". lang('isba_9_resolucion_concesion.fets_tit') ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('isba_9_resolucion_concesion.fets_1_2_3_4'));
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$parrafo_1 = str_replace("%BOIBFECHA%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $parrafo_1);
$parrafo_1 = str_replace("%FECHARESPRESIDI%", date_format(date_create($data['configuracionLinea']['fechaResPresidIDI']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%FECHASOLICITUD%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTEAYUDA%", $data['expediente']['importe_ayuda_solicita_idi_isba'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_INTERESES%", $data['expediente']['intereses_ayuda_solicita_idi_isba'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_AVAL%", $data['expediente']['coste_aval_solicita_idi_isba'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_ESTUDIO%", $data['expediente']['gastos_aval_solicita_idi_isba'], $parrafo_1);
$parrafo_1 = str_replace("%NOMBRE_BANCO%", $data['expediente']['nom_entidad'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE_PRESTAMO%", $data['expediente']['importe_prestamo'], $parrafo_1);
$html = $parrafo_1;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('isba_9_resolucion_concesion.antecedentes_5'));
$html = $parrafo_2;
$pdf->writeHTML($html, true, false, true, false, '');

if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $parrafo_3m = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p3m'));
    $parrafo_3m = str_replace("%REFRECM%", $ultimaMejora[3], $parrafo_3m);
    $html .= "<li>". $parrafo_3m ."</li>";
    $html .= "<br>";
}

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);

$parrafo_3 = str_replace("%FECHAINFORME%", date_format(date_create($data['expediente']['fecha_propuesta_resolucion_notif']),"d/m/Y") , lang('isba_9_resolucion_concesion.antecedentes_6_7_8_9_10_11_12_13'));
$parrafo_3 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_3);
$parrafo_3 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTEAYUDA%", $data['expediente']['importe_ayuda_solicita_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE_INTERESES%", $data['expediente']['intereses_ayuda_solicita_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE_AVAL%", $data['expediente']['coste_aval_solicita_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_idi_isba']),"d/m/Y") , $parrafo_3);
$parrafo_3 = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE_ESTUDIO%", $data['expediente']['gastos_aval_solicita_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%FECHA_PROPUESTA_RESOLUCION_PROVISIONAL%", $data['expediente']['fecha_firma_propuesta_resolucion_prov'], $parrafo_3);
$parrafo_3 = str_replace("%FECHA_NOTIFICACION_PR_PROV%", $data['expediente']['fecha_not_propuesta_resolucion_prov'], $parrafo_3);
$parrafo_3 = str_replace("%FECHA_PROPUESTA_RESOLUCION_DEFINITIVA%", $data['expediente']['fecha_firma_propuesta_resolucion_def'], $parrafo_3);
$parrafo_3 = str_replace("%FECHA_NOTIFICACION_P_RESOL_DEFINITIVA%", $data['expediente']['fecha_not_propuesta_resolucion_def'], $parrafo_3);
$html = $parrafo_3;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_4 = str_replace("%FECHAPAGO%", date_format(date_create($data['expediente']['fecha_de_pago']),"d/m/Y") ,lang('isba_9_resolucion_concesion.fundamentosDeDerecho_tit'));
$html = $parrafo_4;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_5 = lang('isba_9_resolucion_concesion.fundamentosDeDerechoTxt');
$html = $parrafo_5;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_6 = lang('isba_9_resolucion_concesion.dicto');
$html = $parrafo_6;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_6 = lang('isba_9_resolucion_concesion.resolucion_tit');
$html = $parrafo_6;
$pdf->writeHTML($html, true, false, true, false, '');

/* $html = "<ul style=' list-style-type: none;'>";
if ($ultimaMejora[2] && $ultimaMejora[3]) { 
    $html .= "7. ". $parrafo_6;
    $html .= "<br><br>";
    
    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_7 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p7');
    $html .= "8. ". $parrafo_7;
    $html .= "<br><br>";
    
    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_8 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p8');
    $html .= "9. ". $parrafo_8;
    $html .= "<br><br>";
    
    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_9 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p9');
    $html .= "10. ". $parrafo_9;
    $html .= "<br><br>";
    
    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_10 = str_replace("%FECHAFIRMAINFPOSTENMIENDA%", date_format(date_create($data['expediente']['fecha_YYYYYYYYY']),"d/m/Y") , lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p10'));
    $html .= "11. ". $parrafo_10;
} else  {
    $html .= "6. ". $parrafo_6;
    $html .= "<br><br>";

    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_7 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p7');

    $html .= "7. ". $parrafo_7;
    $html .= "<br><br>";

    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_8 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p8');
    $html .= "8. ". $parrafo_8;
    $html .= "<br><br>";

    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_9 = lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p9');
    $html .= "9. ". $parrafo_9;
    $html .= "<br><br>";

    $currentY = $pdf->getY();
    $pdf->setY($currentY + 4);
    $parrafo_10 = str_replace("%FECHAFIRMAINFPOSTENMIENDA%", date_format(date_create($data['expediente']['fecha_YYYYYYYYY']),"d/m/Y") , lang('isba_9_resolucion_concesion.doc_resolucion_concesion_con_req_p10'));
    $html .= "10. ". $parrafo_10;
}
$html .= "</ul>";
$pdf->writeHTML($html, true, false, true, false, ''); */


$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$resolucion = lang('isba_9_resolucion_concesion.resolucion');
$resolucion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $resolucion);
$resolucion = str_replace("%NIF%", $data['expediente']['nif'], $resolucion);
$resolucion = str_replace("%IMPORTEAYUDA%", $data['expediente']['importe_ayuda_solicita_idi_isba'], $resolucion);
$resolucion = str_replace("%IMPORTE_INTERESES%", $data['expediente']['intereses_ayuda_solicita_idi_isba'], $resolucion);
$resolucion = str_replace("%IMPORTE_AVAL%", $data['expediente']['coste_aval_solicita_idi_isba'], $resolucion);
$resolucion = str_replace("%FECHA_AVAL%", date_format(date_create($data['expediente']['fecha_aval_idi_isba']),"d/m/Y") , $resolucion);
$parrafo_3 = str_replace("%ANYOS_DURACION_AVAL%", $data['expediente']['plazo_aval_idi_isba'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE_ESTUDIO%", $data['expediente']['gastos_aval_solicita_idi_isba'], $parrafo_3);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $resolucion ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos_tit = lang('isba_9_resolucion_concesion.recursos_tit');
$html = $recursos_tit;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos = lang('isba_9_resolucion_concesion.recursos');
$html = $recursos;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
/* $pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); */


$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$firma = lang('isba_9_resolucion_concesion.firma');
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $firma);
$firma = str_replace("%DIRECTORGENERAL%", $data['configuracion']['directorGeneralPolInd'], $firma);
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_res_concesion_idi_isba.pdf', 'F');
