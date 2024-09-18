<?php
helper('cookie');
$language = \Config\Services::language();
$language->setLocale($idioma);

require_once('tcpdf/tcpdf.php');

use App\Models\ConfiguracionModel;
$modelConfig = new ConfiguracionModel();

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
		$this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel 971176161 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Sol·licitud d'ajuts a microempreses, petites i mitjanes per cobrir despeses financeres");
$pdf->SetSubject('DOCUMENT DE SOL·LICITUD');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, ISBA, GOIB');	

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

// --------------------------------------------------------------CABECERA Programa, datos solicitante, datos consultor ------------------------------------ //
// -------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 25);
$pdf->setX($currentX);

$html1 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html1 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". lang('message_lang.destino_solicitud').": <b>".lang('message_lang.idi')."</b></td></tr>";
$html1 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". lang('message_lang.codigo_dir3').": <b>A04003714</b></td></tr>";
$html1 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". lang('message_lang.tramite_procedimiento').": <b>". lang('message_lang.subtitulo_solicitud_ayudas_idi_isba')."</b></td></tr>";
$html1 .= "</table>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell('', '', '', '', $html1, 1, 1, 0, true, 'L', true);

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$html2 ="1. ". lang('message_lang.identificacion_sol_idi_isba');

$pdf->writeHTMLCell('', '', '', '', $html2, 1, 1, 0, true, 'C', true);

// ------------------------------------------------------------------1. DATOS EMPRESA---------------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$html3 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.solicitante_sol_idigital').": <b>".$empresa."</b></td></tr>"; 
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>NIF: <b>".$nif."</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Domicili: <b>".$domicilio."</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Localitat: <b>".$cpostal." ".$localidad."</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.nom_rep_legal_sol_idigital')." :  <b>". $nombre_rep ."</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>NIF :  <b>".  $nif_rep . "</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.direccion_rep_legal_sol_idigital')." :  <b>". $domicilio_rep ."</b></td></tr>";
$html3 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.movil_sol_idigital')." :  <b>". $telefono_rep ."</b></td></tr>";
$html3 .= "</table>";

$pdf->writeHTML($html3, true, false, true, false, '');

// ------------------------------------------------------------------2. NOTIFICACIÓN----------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$html4 = "2. ". lang('message_lang.notificacion_corto'); // "NOTIFICACIÓ (en aquest correu i mòbil rebreu els avisos de les notificacions corresponents al procediment)";

$pdf->writeHTMLCell('', '', '', '', $html4, 1, 1, 0, true, 'C', true);

$html5 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html5 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.notificacion_idi_isba').":</td></tr>";
$html5 .= "<tr><td></td></tr>";
$html5 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.mail_rep_legal_sol_idigital')." :  <b>". $email_rep . "</b></td></tr>";
$html5 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.tel_rep_legal_sol_idigital')." :  <b>" . $telefono_rep . "</b></td></tr>";
$html5 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);

$pdf->writeHTML($html5, true, false, true, false, '');

// ------------------------------------------------------------------3. INVERSIÓN DESTINADA A-------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$html6 = "3. ". lang('message_lang.operacion_financiera_idi_isba');

$pdf->writeHTMLCell('', '', '', '', $html6, 1, 1, 0, true, 'C', true);

$html7 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".lang('message_lang.operacion_financiera_prestamo_idi_isba').":</b></td></tr>";
$html7 .= "<tr><td></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.entidad_financiera_idi_isba').": <b>". $nom_entidad . "</b></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.importe_prestamo_entidad_idi_isba').": <b>" . $importe_prestamo . "</b></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.plazo_prestamo_entidad_idi_isba').": <b>" . $plazo_prestamo . "</b></td></tr>";
$html7 .= "<tr><td></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".lang('message_lang.operacion_financiera_aval_idi_isba').":</b></td></tr>";
$html7 .= "<tr><td></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.fecha_del_aval_idi_isba').": <b>" . date_format(date_create($fecha_aval_isba),"d/m/Y") . "</b></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.plazo_prestamo_idi_isba').": <b>" . $plazo_aval_idi_isba . "</b></td></tr>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.cuantia_prestamo_idi_isba').": <b>" . $cuantia_aval_idi_isba . "</b></td></tr>";

$html7 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);

$pdf->writeHTML($html7, true, false, true, false, '');

// ------------------------------------------------------------------4. PROYECTO DE INVERSIÓN-------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------- //
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '25', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 25);
$pdf->setX($currentX);
$html8 = "4. ". lang('message_lang.proyecto_de_inversion_idi_isba');
$pdf->writeHTMLCell('', '', '', '', $html8, 1, 1, 0, true, 'C', true);

$html9 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.proyecto_de_inversion_idi_isba_finalidad')." :  <b>". $finalidad_inversion_idi_isba . "</b></td></tr>";
$html9 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$pdf->writeHTML($html9, true, false, true, false, '');

// ------------------------------------------------------------------5. PRESUPUESTO DEL PROYECTO DE INVERSIÓN--------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX);
$html10 = "5. ". lang('message_lang.presupuesto_proyecto_de_inversion_idi_isba');

$pdf->writeHTMLCell('', '', '', '', $html10, 1, 1, 0, true, 'C', true);

$html11 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.adherido_a_ils_si_no')." :  <b>". $empresa_eco_idi_isba."</b></td></tr>"; /* OK */
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.importe_del_presupuesto_idi_isba').":  <b>".$importe_presupuesto_idi_isba."</b></td></tr>"; /* OK */
$html11 .= lang('message_lang.solicita_ayuda_importe_idi_isba').":  <b>".$importe_ayuda_solicita_idi_isba."</b> ".lang('message_lang.solicita_ayuda_importe_idi_isba_detall')."<br>";
$html11 .= "<ol><li>".lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba')." :  <b>".$intereses_ayuda_solicita_idi_isba."</b></li>";
$html11 .= "<li>".lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba')." :  <b>" .$coste_aval_solicita_idi_isba."</b></li>";
$html11 .= "<li>".lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba')." :  <b>" . $gastos_aval_solicita_idi_isba."</b></li>";
$html11 .= "<ol></td></tr></table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$pdf->writeHTML($html11, true, false, true, false, '');

// ----------------------------------------------6. DECLARO-------------------------------------------------------------------------------- //
// ---------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$html12 = "6. ".lang('message_lang.declaro');
$pdf->writeHTMLCell('', '', '', '', $html12, 1, 1, 0, true, 'C', true);

$html13 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html13 .= "<tr><td><ol>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_0')."</li>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_1')."</li>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_2')."</li>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_3')."</li>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_4');

if ($declaro_idi_isba_que_cumple_4 != "SI") {
	$html13 .= "<br><ul><li><b>". money_format("%i ", $ayudasSubvenSICuales_dec_resp) ." €</b></li></ul><br>";
}

$html13 .= "</li>";
$html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_5')."</li>";
/* $html13 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_6')."</li>"; */
$html13 .= "</ol></td></tr>";
$html13 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$pdf->writeHTML($html13, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '25', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 25);
$pdf->setX($currentX);
$html14 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html14 .= '<tr><td><ol start="8">';
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_7')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_8')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_9')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_10')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_11')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_12')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_13')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_14')."</li>";
$html14 .= "<li>".lang('message_lang.declaro_idi_isba_que_cumple_15')."</li>";
$html14 .= "</ol></td></tr>";
$html14 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 8);
$pdf->setX($currentX);
$pdf->writeHTML($html14, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '25', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

// ----------------------------------------------7. DOCUMENTACIÓN ADJUNTADA---------------------------------------------------------------- //
// ---------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 25);
$pdf->setX($currentX);
$html15 = "7. ".lang('message_lang.documentacion_adjuntada_idi_isba');

$pdf->writeHTMLCell('', '', '', '', $html15, 1, 1, 0, true, 'C', true);

$html16 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "<tr><td><ol>";

if ($file_memoriaTecnica == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_b')."</li>";		
}
if ($file_veracidad_datos_bancarios == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_c')."</li>";		
}
if ( $file_certificadoIAE == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_d')."</li>";		
}
if ( $file_altaAutonomos == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_e')."</li>";		
}
if ( $file_escrituraConstitucion == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_f')."</li>";		
}
if ( $file_nifRepresentante  == "NO") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_g')."</li>";		
}
if ( $file_certificadoATIB == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_h')."</li>";		
}
if ( $file_certificadoAEAT == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_i')."</li>";		
}
if ( $file_certificadoLey382003 == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_j')."</li>";		
}
if ( $file_certificadoSGR == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_k')."</li>";		
}
if ( $file_contratoOperFinanc == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_l')."</li>";		
}
if ( $file_avalOperFinanc == "SI") {
	$html16 .= "<li>".lang('message_lang.documentacion_adjunta_requerida_idi_isba_m')."</li>";		
}
$html16 .= "</ol></td></tr>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 7);
$pdf->setX($currentX);

$pdf->writeHTML($html16, true, false, true, false, '');

// ---------------------------------------------------------FECHA y FIRMA----------------------------------------- //
$html17 = "<br>";
$html17 .= "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html17 .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;'>".lang('message_lang.firma_idi_isba')."</td></tr>";
$html17 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 1);
$pdf->WriteHTML($html17, true, false, true, false, '');

// ---------------------------------------------------------RGDP------------------------------------------------ //

$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');
$html18 = $rgpd;
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 1);
$pdf->setX($currentX - 40);
$pdf->WriteHTML($html18, true, false, true, false, '');

$pdf->Output(WRITEPATH.'documentos/'.$nif.'/'.$selloDeTiempo.'/'.$nif.'_dec_res_solicitud_idi_isba.pdf', 'F');
?>

<div class="container">
	<div><?php echo $html1;?></div>
	<div><?php echo $html2;?></div>

	<!-- <div class="cabecera-apartado"><?php //echo $html4;?></div> -->

	<div class="cabecera-apartado"><?php echo $html3;?></div>
	<div><?php echo $html4;?></div>
	<div class="cabecera-apartado"><?php echo $html5;?></div>
	<div><?php echo $html6;?></div>
	<div class="cabecera-apartado"><?php echo $html7;?></div>
	<div><?php echo $html8;?></div>
	<div class="cabecera-apartado"><?php echo $html9;?></div>
	<div><?php echo $html10;?></div>

	<div class="cabecera-apartado"><?php echo $html11;?></div>
	<div><?php echo $html12;?></div>
	<div class="cabecera-apartado"><?php echo $html13;?></div>
	<div><?php echo $html14;?></div>
	<div><?php echo $html15;?></div>

	<div><?php echo $html16;?></div>
	<div><?php echo $html17;?></div>
	<div class="cabecera-apartado"><?php echo $html18;?></div>
<style>
	html, body {
		font-size: 14px!important;
	}
	body {
		margin: auto;
		max-width: 1200px;
	}
	table, li {
		font-size: 1rem!important;
	}

	td {
		padding: 0.5cm!important;
	}
	.cabecera-apartado {
		margin-top:1rem;
	}
	.container {
    max-width: 1140px;
    border: 1px solid black;
    background-color: #cdebe8;
    color: #000;
    border-radius: .5rem;
	padding: 1rem;
	margin-bottom: 1rem;
	}
</style>