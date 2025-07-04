<?php
helper('cookie');
$language = \Config\Services::language();
$language->setLocale($idioma);
require_once('tcpdf/tcpdf.php');

use App\Models\ConfiguracionModel;
$modelConfig = new ConfiguracionModel();
$generalConfig =  $modelConfig->configuracionGeneral();
$data['configuracion'] = $modelConfig->where('activeGeneralData', 'SI')->first();	
use App\Models\ConfiguracionLineaModel;

$lineaConfig = new ConfiguracionLineaModel();
$data['configuracionLinea'] = $lineaConfig->activeConfigurationLineData('XECS', $generalConfig['convocatoria']);

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
			$this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
    	$this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Sol·licitud d'ajuts i de subvencions");
$pdf->SetSubject('DECLARACIÓ RESPONSABLE DE LA SOL·LICITUD');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, GOIB');	

$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 20, 15, true);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 9);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// -----------------------------------------------------------------------------------Página 1/5---------------------------------------------------------------------------- //
$pdf->AddPage();

$html1 = lang('message_lang.destino_solicitud').": <b>". lang('message_lang.idi')."</b>";
$html1 .= "<br>";
$html1 .= lang('message_lang.codigo_dir3')." <b>".$data['configuracion']['emisorDIR3']."</b> ";
$html1 .= lang('message_lang.codigo_sia')." <b>".$data['configuracionLinea']['codigoSIA']."</b>";

// set color for background
$pdf->SetFillColor(230, 247, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html1, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html2 = lang('message_lang.intro_sol_idigital'); // "Convocatoria para la concesión de ayudas de cheques de consultoría para impulsar a la industria de Baleares en materia de digitalización, internacionalización y sostenibilidad";
$pdf->writeHTML($html2, true, false, true, false, '');

// --------------------------------------------------1. SELECCIONE EL PROGRAMA DE AYUDA QUE SOLICITA-------------------------------------- //
// --------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html3 = lang('message_lang.convocatoria_sol_idigital')." ".$data['configuracionLinea']['convocatoria']; // El año de la convocatoria de las ayudas
$pdf->writeHTML($html3, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html4 =  lang('message_lang.programa'); // el programa de ayudas seleccionado
$pdf->Cell(0, 10, $html4, 1, 1, 'C');
if ($tipo_tramite == "Programa I") {
	$tipo_tramite = lang('message_lang.programaiDigital');
}
else if ($tipo_tramite == "Programa II") {
	$tipo_tramite = lang('message_lang.programaiExporta');
}
else if ($tipo_tramite == "Programa III actuacions corporatives") {
	$tipo_tramite = lang('message_lang.programaiSostenibilitatCorp');
}
else if ($tipo_tramite == "Programa III actuacions producte") {
	$tipo_tramite = lang('message_lang.programaiSostenibilitatProd');
}
else if ($tipo_tramite == "Programa IV") {
	$tipo_tramite = lang('message_lang.programaiGestio');
}
else if ($tipo_tramite == "ILS") {
	$tipo_tramite = lang('message_lang.programaILS');
}

$html5 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html5 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $tipo_tramite ."</b></td></tr>";
$html5 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html5, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html6 =  lang('message_lang.solicitante_tipo'); // 2. TIPO DE SOLICITANTE
$pdf->Cell(0, 10, $html6, 1, 1, 'C');

if ($tipo_solicitante == "autonomo") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_autonomo');
	}
else if ($tipo_solicitante == "pequenya") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_pequenya');
	}
else if ($tipo_solicitante == "mediana") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_mediana');
}

$html7 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $tipo_solicitante ."</b></td></tr>";
$html7 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html7, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html8 = lang('message_lang.identificacion_sol_idigital'); // DADES DE LA PERSONA SOL·LICITANT
$pdf->Cell(0, 10, $html8, 1, 1, 'C');

// ------------------------------------------------------------------3. INTERESADO---------------------------------------------------------------------- //
// ----------------------------------------------------------------------------------------------------------------------------------------------------- //
/* $currentY = $pdf->getY();
$pdf->setY($currentY + 5); */
$html9 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.solicitante_sol_idigital').": <b>".$empresa."</b> NIF: <b>".$nif."</b></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.nom_rep_legal_sol_idigital')." :  <b>". $nombre_rep ."</b> NIF: <b>" . $nif_rep . "</b></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.direccion_sol_idigital').": <b>".$domicilio."</b> ".lang('message_lang.localidad_sol_idigital').": <b>".$localidad."</b></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>C.P.:  <b>".$cpostal."</b> ".lang('message_lang.movil_sol_idigital').":  <b>".$telefono."</b> ".lang('message_lang.select_iae')." :  <b>" . $iae ."</b></td></tr>";
$html9 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html9, true, false, true, false, '');
$html10 = "4. ". lang('message_lang.notificacion_corto'); // "4. NOTIFICACIÓN (en aquest correu i mòbil rebreu els avisos de les notificacions corresponents al procediment)";
$pdf->Cell(0, 10, $html10, 1, 1, 'C');

$html11 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.mail_rep_legal_sol_idigital')." :  <b>". $email_rep . "</b></td></tr>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.tel_rep_legal_sol_idigital')." :  <b>" . $telefono_rep . "</b></td></tr>";
$html11 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html11, true, false, true, false, '');

// ------------------------------------------------------------------5. DATOS DEL CONSULTOR--------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------- //
$html12 = lang('message_lang.datos_cons_sol_idigital'); // "DADES DEL CONSULTOR";
$pdf->Cell(0, 10, $html12, 1, 1, 'C');

$html13 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
if ( $hay_consultor != "si") {
	$html13 .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('message_lang.no_cons_sol_idigital')."</b></td></tr>"; // <b>No</b> tenc consultor, l'IDI m'assignarà un consultor acreditat</td></tr>";
}
else {	
	$html13 .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.nom_habilitador_sol_idigital').": <b>" . $nom_consultor . "</b></td></tr>";
	$html13 .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.tel_rep_legal_sol_idigital').": <b>" . $tel_consultor . "</b></td></tr>";
	$html13 .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.mail_rep_legal_sol_idigital')." <b>: " . $mail_consultor. "</b></td></tr>";
}
$html13 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html13, true, false, true, false, '');

// ----------------------------------------------------------------6. DOCUMENTACIÓN ADJUNTA --------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------- //
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html14 = "<h4>".lang('message_lang.intro_sol_idigital')."</h4>";
$html14 .= "<h4>".lang('message_lang.convocatoria_sol_idigital')." ".$data['configuracionLinea']['convocatoria']." </h4>";
$pdf->SetFillColor(230, 247, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html14, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$html15 = lang('message_lang.documentacion_adjunta'); // 6. DOCUMENTACIÓN ADJUNTA CABECERA
$pdf->Cell(0, 10, $html15, 1, 1, 'C');

$html16 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "<tr><td><ol>";
if ( trim($file_memoriaTecnica) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.doc_Memoria_Tecnica')."</li>";		
}
if ( trim($memoriaTecnicaEnIDI) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.memoriaTecnicaEnIDI_sinCambios')."</li>";		
}
if (trim( $file_altaAutonomos) === "SI") {
	$html16 .= "<li>".lang('message_lang.doc_alta_RETA')."</li>";		
}
if ( trim($file_certificadoIAE) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.doc_certificado_IAE')."</li>";		
}
if ( trim($certificadoIAEEnIDI) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.certificadoIAEEnIDI_sinCambios')."</li>";		
}
if ( trim($file_document_acred_como_repres) === "SI") { /* FAIL */
	$html16 .= "<li>".lang('message_lang.doc_Acreditativa_Repres')."</li>";		
}
if ( trim($pJuridicaDocAcreditativaEnIDI) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.pJuridicaDocAcreditativaEnIDI_sinCambios')."</li>";		
}
if ( trim($file_nifEmpresa) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.eres_persona_juridica')."</li>";		
}
if ( trim($file_escritura_empresa) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.eres_persona_juridica_doc_acreditativa')."</li>";		
}
if ( trim($copiaNIFSociedadEnIDI) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.copiaNIFSociedadEnIDI_sinCambios')."</li>";		
}
if ( trim($file_certificadoAEAT) === "SI") { /* OK */
	$html16 .= "<li>".lang('message_lang.certificado_corriente_pago_aeat')."</li>";		
}
$html16 .= "</ol></td></tr>";
$html16 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html16, true, false, true, false, '');

// ---------------------------------------------------------------------------------------------------------------------------- //
// ----------------------------------------------7. AUTORIZACIONES------------------------------------------------------------- //
$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$html17 = lang('message_lang.autorizaciones_solicitud'); // AUTORIZACIONES
$pdf->Cell(0, 10, $html17, 1, 1, 'C');

$html18 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html18 .= "<tr><td></td></tr>";
$html18 .= "<tr><td><ul>";
if (trim($file_copiaNIF)=="SI" OR trim($file_certificadoATIB)=="SI" OR trim($file_certificadoSegSoc)=="SI") {
	$html18 .= lang('message_lang.autorizaciones_solicitud_si_autoriza')."<br>";
} 
if (trim($file_copiaNIF)=="NO" OR trim($file_certificadoATIB)=="NO" OR trim($file_certificadoSegSoc)=="NO") {
	$html18 .= "<br><br>".lang('message_lang.autorizaciones_solicitud_no_autoriza')."<br>";
	if (trim($file_copiaNIF)=="NO") {
		$html18 .= "<li>".lang('message_lang.autorizaciones_personas_fisicas')."</li>";
	}
	if (trim($file_certificadoATIB)=="NO") {
		$html18 .= "<li>".lang('message_lang.doy_mi_consentimiento_pdf')."</li>";
	}
	if (trim($file_certificadoSegSoc)=="NO") {
		$html18 .= "<li>".lang('message_lang.doy_mi_consentimiento_seg_soc')."</li>";
	}
}		
$html18 .= "</ul></td></tr>";
$html18 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html18, true, false, true, false, '');

// ------------------------------------------------------------------------------------------------------------------------------ //
// ----------------------------------------------8. DECLARACIÓN RESPONSABLE------------------------------------------------------ //
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html19 = "<h4>".lang('message_lang.intro_sol_idigital')."</h4>";
$html19 .= "<h4>".lang('message_lang.convocatoria_sol_idigital')." ".$data['configuracionLinea']['convocatoria']." </h4>";
$pdf->SetFillColor(230, 247, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html19, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$html20 = lang('message_lang.declaracion_responsable'); //."DECLARACIÓ RESPONSABLE</h5>";
$localidad = explode ("#", $localidad);
$pdf->Cell(0, 10, $html20, 1, 1, 'C');

$html21 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html21 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>" . $empresa . ",".  lang('message_lang.domicilio_notifica_dec_resp') . $domicilio . " de " . $localidad[1] . "</td></tr><br>";
$html21 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html21, true, false, true, false, '');


$html22 = lang('message_lang.declaracion_minimis'); // "DECLARACIÓ DE MINIMIS";
$pdf->Cell(0, 10, $html22, 1, 1, 'C');

$html23 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html23 .= "<tr><td>".lang('message_lang.declaro');
$html23 .= "<p>".lang('message_lang.declaracion_responsable_i')."</p>";

if ( $importe_minimis != 0) {
	$html23 .= "<p>".lang('message_lang.declaracion_responsable_ii')."<br> $importe_minimis €</p>";
}
$html23 .= "</td></tr>";
$html23 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html23, true, false, true, false, '');

$html24 = lang('message_lang.declaracion_datos_bancarios_cabecera'); //"DECLARACIÓ RESPONSABLE DE VERACITAT DE DADES BANCÀRIES APORTADES";
$pdf->Cell(0, 10, $html24, 1, 1, 'C');

$html25 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html25 .= "<tr><td>".lang('message_lang.declaro');
if ( $veracidad_datos_bancarios_1 == "SI ") {
	$html25 .= "<p>".lang('message_lang.declaracion_datos_bancarios_1')."</p>";
}
if ( $opcion_banco == "1") {
	$html25 .= "<p>".lang('message_lang.declaracion_datos_bancarios_2')." : $cc_datos_bancarios</p>";
}
else {
	$html25 .= "<p>".lang('message_lang.declaracion_datos_bancarios_3')." : $cc_datos_bancarios - $pais_datos_bancarios</p>";
}
if ( $veracidad_datos_bancarios_2 == "SI ") {
	$html25 .= "<p>".lang('message_lang.declaracion_datos_bancarios_4')."</p>";
}
if ( $veracidad_datos_bancarios_3 == "SI ") {
	$html25 .= "<p>".lang('message_lang.declaracion_datos_bancarios_5')."</p>";
}

$html25 .= "</td></tr>";
$html25 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html25, true, false, true, false, '');

// ----------------------------------------------------------------------------------------------------------------------------------------------------- //
// ----------------------------------------------La declaración responsable del solicitante (2)--------------------------------------------------------- //
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html26 = "<h4>".lang('message_lang.intro_sol_idigital')."</h4>";
$html26 .= "<h4>".lang('message_lang.convocatoria_sol_idigital')." ".$data['configuracionLinea']['convocatoria']." </h4>";
$pdf->SetFillColor(230, 247, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html26, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$html27 = lang('message_lang.declaracion_responsable'); //."DECLARACIÓ RESPONSABLE</h5>";
$pdf->Cell(0, 10, $html27, 1, 1, 'C');

$html28 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html28 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.declaro')."</td></tr>";
$html28 .= "<tr><td ><ul>";

$html28 .= "<p>".lang('message_lang.declaracion_responsable_iv')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_v')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_vi')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_vii')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_viii')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_ix')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_x')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_xi')."</p>";
$html28 .= "<p>".lang('message_lang.declaracion_responsable_xii')."</p>";

$html28 .= "</ul></td></tr>";
$html28 .= "</table>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html28, true, false, true, false, '');

// ---------------------------------------------------------RGDP----------------------------------------------------------------- //
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');
$html29 = "<br>";
$html29 .= "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td style='background-color:#f2f2f2;color:#000;font-size:7px;'>".lang('message_lang.rgpd_txt')."</td></tr>";
$html29 .= "</table>"; 
$currentY = $pdf->getY();
$pdf->setY($currentY+40);
$pdf->writeHTML($html29, true, false, true, false, '');

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //

$pdf->Output(WRITEPATH.'documentos/'.$nif.'/'.$selloDeTiempo.'/'.$nif.'_dec_res_solicitud.pdf', 'F');

?>
<div class="container">
	<div class='alert alert-info'><?php echo lang('message_lang.enviado_correo_electron');?></div>
	<div class='alert alert-warning'><?php echo lang('message_lang.nota_info_rec');?></div>
	<div class='alert alert-info'><?php echo lang('message_lang.contacto_idi_pindust');?></div>	
	<div class='alert alert-info'><?php echo lang('message_lang.una_vez_firmado');?></div>
</div>
<div class="container">
	<div><?php echo $html1;?></div>
	<div><?php echo $html2;?></div>
	<div><?php echo $html3;?></div>
	<div class="cabecera-apartado"><?php echo $html4;?></div>
	<div><?php echo $html5;?></div>
	<div class="cabecera-apartado"><?php echo $html6;?></div>
	<div><?php echo $html7;?></div>
	<div class="cabecera-apartado"><?php echo $html8;?></div>
	<div><?php echo $html9;?></div>
	<div class="cabecera-apartado"><?php echo $html10;?></div>
	<div><?php echo $html11;?></div>
	<div class="cabecera-apartado"><?php echo $html12;?></div>
	<div><?php echo $html13;?></div>
	<div class="cabecera-apartado"><?php echo $html15;?></div>
	<div><?php echo $html16;?></div>
	<div><?php echo $html17;?></div>
	<div><?php echo $html18;?></div>
	<div><?php echo $html20;?></div>
	<div><?php echo $html21;?></div>
	<div class="cabecera-apartado"><?php echo $html22;?></div>
	<div><?php echo $html23;?></div>
	<div><?php echo $html24;?></div>
	<div><?php echo $html25;?></div>
	<div><?php echo $html27;?></div>
	<div><?php echo $html28;?></div>
	<div><?php echo $html29;?></div>	
</div>
<style>
	html, body {
		font-size: 14px!important;
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
    background-color: #d9eee4;
    color: #000;
    border-radius: .5rem;
		padding: 1rem;
		margin-bottom: 1rem;
	}
</style>