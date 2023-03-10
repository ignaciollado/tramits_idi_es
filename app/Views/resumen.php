 <div class="container">
    <br>
     
    <?php if (session('msg')) : ?>
        <div class="alert alert-info alert-dismissible">
            <?= session('msg') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
 
	<div class="row">
    <div class="col-md-9"> 
	<?php
	$table = new \CodeIgniter\View\Table();
	$table->setHeading(array('ID', 'cifnif_propietario', 'Nom', 'Tipo', 'created_at', 'Tipo trámite', 'datetime_uploaded'));
	$template = [
        'table_open'         => '<table border="0" cellpadding="4" cellspacing="0">',

        'thead_open'         => '<thead>',
        'thead_close'        => '</thead>',

        'heading_row_start'  => '<tr>',
        'heading_row_end'    => '</tr>',
        'heading_cell_start' => '<th>',
        'heading_cell_end'   => '</th>',

        'tfoot_open'         => '<tfoot>',
        'tfoot_close'        => '</tfoot>',

        'footing_row_start'  => '<tr>',
        'footing_row_end'    => '</tr>',
        'footing_cell_start' => '<td>',
        'footing_cell_end'   => '</td>',

        'tbody_open'         => '<tbody>',
        'tbody_close'        => '</tbody>',

        'row_start'          => '<tr>',
        'row_end'            => '</tr>',
        'cell_start'         => '<td>',
        'cell_end'           => '</td>',

        'row_alt_start'      => '<tr>',
        'row_alt_end'        => '</tr>',
        'cell_alt_start'     => '<td>',
        'cell_alt_end'       => '</td>',

        'table_close'        => '</table>'
];

$table->setTemplate($template);	
$db = \Config\Database::connect();
$query = $db->query('SELECT * FROM pindust_documentos');	
echo $table->generate($query);

echo $respuesta;
	?>
 
 </div>
</div>
  
</div>