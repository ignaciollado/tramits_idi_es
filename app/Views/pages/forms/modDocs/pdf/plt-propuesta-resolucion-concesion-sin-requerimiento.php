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
use App\Models\MejorasExpedienteModel;
        
$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();
$mejorasSolicitud = new MejorasExpedienteModel();

$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
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
$pdf->SetTitle("PROPUESTA RESOLUCIÓN CONCESIÓN SIN REQUERIMIENTO");
$pdf->SetSubject("PROPUESTA RESOLUCIÓN CONCESIÓN SIN REQUERIMIENTO");
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
$html = "Document: resolució de pagament<br>amb proposta previa<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
$html .= "Programa: " .$data['expediente']['tipo_tramite']."<br>";
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
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_prop_resolucion_concesion_sin_req_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('message_lang.doc_prop_resolucion_concesion_sin_req_antecedentes') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('message_lang.doc_prop_resolucion_concesion_sin_req_p1'));
$parrafo_1 = str_replace("%BOIB%", $data['configuracionLinea']['num_BOIB'], $parrafo_1);
$html = "<ol>";
$html .= "<li>". $parrafo_1 ."</li>";
$html .= "<br>";

$parrafo_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , lang('message_lang.doc_prop_resolucion_concesion_sin_req_p2'));
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_2);
$parrafo_2 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_2);
$parrafo_2 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_2);
$parrafo_2 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_2);
$parrafo_2 = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_2);
$html .= "<li>". $parrafo_2 ."</li>";
$html .= "<br>";

if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $parrafo_3m = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , lang('message_lang.doc_prop_resolucion_concesion_sin_req_p3m'));
    $parrafo_3m = str_replace("%REFRECM%", $ultimaMejora[3], $parrafo_3m);
    $html .= "<li>". $parrafo_3m ."</li>";
    $html .= "<br>";
} 

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_3 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_p3');
$parrafo_3 = str_replace("%FECHAINFORFAV%", date_format(date_create($data['expediente']['fecha_infor_fav_desf']),"d/m/Y"), $parrafo_3);
$html .= "<li>". $parrafo_3 ."</li>";
$html .= "<br>";

$pdf->writeHTML($html, true, false, true, false, '');


// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '40', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 13);
$req_fundamentos = lang('message_lang.doc_prop_resolucion_concesion_sin_req_fundamentos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $req_fundamentos ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 2);
$req_fundamentos_1 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_fundamentos_1');
$html = "<ol>";
$html .= "<li>". $req_fundamentos_1 ."</li>";
$html .= "<br>";

$req_fundamentos_2 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_fundamentos_2');
$html .= "<li>". $req_fundamentos_2 ."</li>";
$html .= "</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion = lang('message_lang.doc_prop_resolucion_concesion_sin_req_prop_resolucion');
$resolucion = str_replace("%NUEVALINEA%", "<br><br>", $resolucion);

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $resolucion ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion_1 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_1'));
$resolucion_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'] , $resolucion_1);
$resolucion_1 = str_replace("%NIF%", $data['expediente']['nif'] , $resolucion_1);
$html = "<ol>";
$html .= "<li>". $resolucion_1 ."</li>";
$html .= "<br>";

$resolucion_2 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_2');
$resolucion_2 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $resolucion_2);
$resolucion_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'] , $resolucion_2);
$resolucion_2 = str_replace("%NIF%", $data['expediente']['nif'] , $resolucion_2);
$html .= "<li>". $resolucion_2 ."</li>";
$html .= "<br>";

$resolucion_3 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_3');
$html .= "<li>". $resolucion_3 ."</li>";
$html .= "<br>";

$resolucion_4 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_4');
$html .= "<li>". $resolucion_4 ."</li>";
$html .= "<br>";

$resolucion_5 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_5');
$html .= "<li>". $resolucion_5 ."</li>";
$html .= "<br>";

$resolucion_6 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_6');
$html .= "<li>". $resolucion_6 ."</li>";
$html .= "<br>";

$resolucion_7 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_7');
$html .= "<li>". $resolucion_7 ."</li>";
$html .= "<br>";

$resolucion_9 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion_9');
$html .= "<li>". $resolucion_9 ."</li>";
$html .= "</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '40', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$req_fundamentos = lang('message_lang.doc_prop_resolucion_concesion_sin_req_dicto');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $req_fundamentos ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$req_fundamentos = lang('message_lang.doc_prop_resolucion_concesion_sin_req_resolucion');
$req_fundamentos = str_replace("%SALTOLLINEA%", "<br><br>" , $req_fundamentos);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $req_fundamentos ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$req_fundamentos = lang('message_lang.doc_prop_resolucion_concesion_sin_req_recursos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $req_fundamentos ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos_1 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_recursos_p1');
$html = "<ol>";
$html .= "<li>". $recursos_1 ."</li>";
$html .= "<br>";

$recursos_2 = lang('message_lang.doc_prop_resolucion_concesion_sin_req_recursos_p2');
$html .= "<li>". $recursos_2 ."</li>";
$html .= "</ol>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 25);
$firma = lang('message_lang.doc_prop_resolucion_concesion_sin_req_firma');
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'] , $firma);
$firma = str_replace("%DIRECTORGENERAL%", $data['configuracion']['directorGeneralPolInd'] , $firma);

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $firma ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$firma = lang('message_lang.doc_prop_resolucion_concesion_sin_req_firma_gerente_IDI');
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'] , $firma);
$firma = str_replace("%DIRECTORAGERENTEIDI%", $data['configuracion']['directorGerenteIDI'], "$firma");

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
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_prop_res_conces_sin_req.pdf', 'F');