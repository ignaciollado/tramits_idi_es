<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
    //obtengo los datos de la convocatoria
    use App\Models\ConfiguracionModel;
    $configuracion = new ConfiguracionModel();
    $data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
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
        $image_file = K_PATH_IMAGES.'logo_idi_conselleria.jpg';
        // $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', 'url', 'align', false (resize), 300 (dpi), 'align (L (left) C (center) R (righ)', false, false, 0, $fitbox, false, false);
        // align: T (top), M (middle), B (bottom), N (next line)
        $this->Image($image_file, 10, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
		// Texto pie de página
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
		$this->Cell(0, 5, "Institut d'Innovació Empresarial - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->setX(-15);
        //$this->setY(-25);
       // $footer = "Plaça de Son Castelló, 1<br>";
        //$footer .= "07009 Polígon de Son Castelló.<br>";
        //$footer .= "Palma<br>";
        //$footer .= "Tel. 971 17 61 61<br>";
        //$footer .= "www.idi.es";
        //$html = "<div style='width:100%;color:#000;text-align:left;font-size:8px;'>";
        //$html .= $footer;
        //$html .= "</div>";
        //$this->writeHTML($html, true, false, true, false, '');

        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("INFORME FAVORABLE CON REQUERIMIENTO");
$pdf->SetSubject("INFORME FAVORABLE CON REQUERIMIENTO");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, GOIB");	

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
$html = "Document: informe favorable<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
$html .= "Codi SIA: ".$data['configuracion']['codigoSIA']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ".$data['expediente']['nif'];

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
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_info_favorable_con_req_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('message_lang.doc_info_favorable_con_req_hechos') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('message_lang.doc_info_favorable_con_req_p1'));
$parrafo_1 = str_replace("%BOIB%", $data['configuracion']['num_BOIB'], $parrafo_1);
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1 ."</td></tr>";
//$html .= "</table>";
$html = "<ol>";
$html .= "<li>". $parrafo_1 ."</li>";
$html .= "<br>";
//$html .= "</ol>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
//$parrafo_1_1 = str_replace("%BOIB%", $data['configuracion']['num_BOIB_modific'], lang('message_lang.doc_info_favorable_con_req_p1_1'));
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1_1 ."</td></tr>";
//$html .= "</table>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
$parrafo_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , lang('message_lang.doc_info_favorable_con_req_p2'));
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_2);
$parrafo_2 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_2);
$parrafo_2 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_2);
$parrafo_2 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_2);
$parrafo_2 = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_2);
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_2 ."</td></tr>";
//$html .= "</table>";
$html .= "<li>". $parrafo_2 ."</li>";
$html .= "<br>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
$parrafo_3 = str_replace("%FECHAREQUERIMIENTO%", date_format(date_create($data['expediente']['fecha_requerimiento_notif']),"d/m/Y") , lang('message_lang.doc_info_favorable_con_req_p3'));
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3 ."</td></tr>";
//$html .= "</table>";
$html .= "<li>". $parrafo_3 ."</li>";
$html .= "<br>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
$parrafo_4 = str_replace("%FECHAENMIENDA%", date_format(date_create($data['expediente']['fecha_REC_enmienda']),"d/m/Y") , lang('message_lang.doc_info_favorable_con_req_p4'));
$parrafo_4 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_4);
$parrafo_4 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_4);
$parrafo_4 = str_replace("%NUMREC%", $data['expediente']['ref_REC_enmienda'], $parrafo_4);
$parrafo_4 = str_replace("%IMPORTE%",  money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_4);
$parrafo_4 = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_4);
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_4 ."</td></tr>";
//$html .= "</table>";
$html .= "<li>". $parrafo_4 ."</li>";
$html .= "<br>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
$parrafo_5 =  lang('message_lang.doc_info_favorable_con_req_p5');
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_5 ."</td></tr>";
//$html .= "</table>";
$html .= "<li>". $parrafo_5 ."</li>";
$html .= "<br>";
//$pdf->writeHTML($html, true, false, true, false, '');

//$currentY = $pdf->getY();
//$pdf->setY($currentY + 4);
$parrafo_6 =  lang('message_lang.doc_info_favorable_con_req_p6');
//$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_6 ."</td></tr>";
//$html .= "</table>";
$html .= "<li>". $parrafo_6 ."</li>";
$html .= "</ol>";
$html .= "<br>";
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
// $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', 'url', 'align', false (resize), 300 (dpi), 'align (L (left) C (center) R (righ)', false, false, 0, $fitbox, false, false);
// align: T (top), M (middle), B (bottom), N (next line)
$pdf->Image($image_file, 15, 15, '', '40', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$parrafo_pre = lang('message_lang.doc_info_favorable_con_req_preconclusion');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_pre ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_conclusion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_info_favorable_con_req_conclusion'));
$parrafo_conclusion = str_replace("%SALTOLINEA%", "<br><br>", $parrafo_conclusion);
$parrafo_conclusion = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_conclusion);
$parrafo_conclusion = str_replace("%IMPORTE%",  money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_conclusion);
$parrafo_conclusion = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_conclusion);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_conclusion ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$firma = "El/la tècnic/a<br><br>".  $pieFirma;
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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_informe_favorable_con_requerimiento.pdf', 'F');