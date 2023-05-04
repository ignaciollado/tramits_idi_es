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
        $this->Cell(0, 5, "Institut d'Innovació Empresarial - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("INFORME DE LIQUIDACIÓN");
$pdf->SetSubject("INFORME DE LIQUIDACIÓN");
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

// ------------------------------------------- Programa, datos solicitante, datos consultor -------------------------------------------- // $data['configuracion']['num_BOIB']
// ------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: liquidació subvenció<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Codi SIA: ".$data['configuracion']['codigoSIA']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";

// set membrete
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 120, 40, $html, 0, 1, 1, true, 'J', true);
$pdf->SetFont('helvetica', '', 12);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$intro = lang('message_lang.doc_informe_de_liquidacion_asunto')."<br>";
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $intro);
$intro = str_replace("%EXPED%", $data['expediente']['idExp']."/".$data['expediente']['convocatoria'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_1 = lang('message_lang.doc_informe_de_liquidacion_p1');
$parrafo_1 = str_replace("%FECHAFIRMARESCONCESION%", date_format(date_create($data['expediente']['fecha_resolucion']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']);
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracion']['num_BOIB'], $parrafo_1);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
//$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1.str_replace("%BOIBNUM%", $data['configuracion']['num_BOIB_modific'], lang('message_lang.doc_informe_de_liquidacion_p1_1')) ."</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_2 = lang('message_lang.doc_informe_de_liquidacion_p2');
$parrafo_2 = str_replace("%FECHAPAGO%", date_format(date_create($data['expediente']['fecha_de_pago']),"d/m/Y"), $parrafo_2);
$parrafo_2 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_2);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_2 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_3 = lang('message_lang.doc_informe_de_liquidacion_p2_2');
$parrafo_3 = str_replace("%FECHARECJUSTIFICACION%", date_format(date_create($data['expediente']['fecha_REC_justificacion']),"d/m/Y"), $parrafo_3);
$parrafo_3 = str_replace("%REFRECJUSTIFICACION%", $data['expediente']['ref_REC_justificacion'], $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_3);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_4 = lang('message_lang.doc_informe_de_liquidacion_p2_3');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_4 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_5 = lang('message_lang.doc_informe_de_liquidacion_p3');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_5 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');


$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$parrafo_6 = lang('message_lang.doc_informe_de_liquidacion_p4');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_6 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$firma = lang('message_lang.doc_informe_de_liquidacion_firma')."<br>".  $pieFirma;;
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $firma ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
/* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_informe_de_liquidacion.pdf', 'F');

