<?php
require_once('tcpdf/tcpdf.php');

setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;

$language = \Config\Services::language();
$language->setLocale("ca");
    
$modelConfig = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();

$data['configuracion'] = $modelConfig->configuracionGeneral();
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
$tipo_tramite = "ADR Balears - ISBA";
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
	
$pdf->SetAuthor("AGENCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (ADR BALEARS) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("REQUERIMIENTO ENMIENDA JUSTIFICACIÓN");
$pdf->SetSubject("REQUERIMIENTO ENMIENDA JUSTIFICACIÓN");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ISBA, PIMES, ADR BALEARS, GOIB");	

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
$pdf->setY($currentY + 15);
$html =  "Document: requeriment esmena<br>";
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
$pdf->setY($currentY + 12);

$asunto = lang('isba_13_requerimiento_enmienda_justificacion.asunto');
$asunto = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $asunto);
$asunto = str_replace("%NIF%", $data['expediente']['nif'], $asunto);
$asunto = str_replace("%BOIBFECHA%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $asunto);
$html = $asunto;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_1 = lang('isba_13_requerimiento_enmienda_justificacion.p1');
$parrafo_1 = str_replace("%FECHA_RESOL_CONCE%", date_format(date_create($data['expediente']['fecha_firma_res']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTEAYUDA%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_1);
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'],  $parrafo_1);
$html = $parrafo_1;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_2 = lang('isba_13_requerimiento_enmienda_justificacion.p2');
/* %FECHA_REUNION_CIERRE% */
$parrafo_2 = str_replace("%FECHA_LIMITE_JUSTIFICACION%", date_format(date_create($data['expediente']['fecha_limite_justificacion']),"d/m/Y"), $parrafo_2);
$html = $parrafo_2;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3 = lang('isba_13_requerimiento_enmienda_justificacion.p3');
$html = $parrafo_3;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_4 = lang('isba_13_requerimiento_enmienda_justificacion.p4');
/* %FECHA_INFORME_INICIO_REQUE% */
$parrafo_4 = str_replace("%TEXTO_LIBRE%", $data['expediente']['motivoRequerimientoJustificacion'] , $parrafo_4);
$html = $parrafo_4;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_5 = lang('isba_13_requerimiento_enmienda_justificacion.p5');
$parrafo_5 = str_replace("%TEXTO_LIBRE%", $data['expediente']['motivoRequerimientoJustificacion'] , $parrafo_5);
$html = $parrafo_5;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);

$parrafo_6 = lang('isba_13_requerimiento_enmienda_justificacion.p6');
$parrafo_6 = str_replace("%TEXTO_LIBRE%", $data['expediente']['motivoRequerimientoJustificacion'] , $parrafo_6);
$html = $parrafo_6;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_7 = lang('isba_13_requerimiento_enmienda_justificacion.p7');
$html = $parrafo_7;
$pdf->writeHTML($html, true, false, true, false, '');


$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$firma = lang('isba_13_requerimiento_enmienda_justificacion.firma');
$firma = str_replace("%DGERENTE%", $data['configuracion']['directorGerenteIDI'], $firma);
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $firma);
$html = $firma;
$pdf->writeHTML($html, true, false, true, false, '');
// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_requerimiento_justificacion.pdf', 'F');