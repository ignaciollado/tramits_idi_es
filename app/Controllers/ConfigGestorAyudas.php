<?php namespace App\Controllers;

// Add those two lines at the beginning of your controller
use App\Libraries\GroceryCrud;
use App\Models\ConfiguracionModel;

class ConfigGestorAyudas extends BaseController
{
	public function profile_management()
	{
	    $crud = new GroceryCrud();
        $crud->setPrint();
        $crud->setExport();
	    $crud->setTable('pindust_linea_ayuda')
            ->setSubject('Linea de ayuda', 'Lineas de ayudas')
            ->columns(['id', 'codigoSIA', 'lineaAyuda', 'convocatoria', 'activeLineData', 
                        'num_BOIB', 'fecha_BOIB', 'convocatoria_desde', 'convocatoria_hasta', 'totalAmount'])
            
                        ->displayAs('activeLineData', "Convocatòria activa?")
                        ->displayAs('lineaAyuda', "Linia d'ajuda")
                        ->displayAs('convocatoria', 'Convocatòria')
                        ->displayAs('num_BOIB', 'Num BOIB')
                        ->displayAs('fecha_BOIB', 'Data BOIB')
                        ->displayAs('fechaResPresidIDI', 'Data resolució president IDI')
                        ->displayAs('codigoSIA', 'Codi SIA')
                        ->displayAs('dias_fecha_lim_justificar', "Màxim dies per justificar l'ajut rebut")
                        ->displayAs('meses_fecha_lim_consultoria', "Màxim mesos per justificar l'ajut rebut")
                        ->displayAs('convocatoria_aviso_ca', "Nota convocatòria pendent de publicació")
                        ->displayAs('convocatoria_aviso_es', "Nota convocatoria pendiente de publicación")
                        ->displayAs('totalAmount', "Import econòmic màxim")

            ->fields(['convocatoria', 'lineaAyuda', 'activeLineData', 'codigoSIA', 'num_BOIB', 'fecha_BOIB', 'num_BOIB_modific', 'fechaResPresidIDI', 'programa', 'meses_fecha_lim_consultoria', 'convocatoria_desde', 'convocatoria_hasta', 'totalAmount', 'dias_fecha_lim_justificar', 'convocatoria_aviso_ca', 'convocatoria_aviso_es'])

            ->requiredFields(['convocatoria', 'activeLineData', 'lineaAyuda', 'codigoSIA', 'num_BOIB', 'fecha_BOIB', 'meses_fecha_lim_consultoria', 'convocatoria_desde', 'convocatoria_hasta', 'convocatoria_aviso_ca', 'convocatoria_aviso_es']);

        $crud->fieldType('convocatoria', 'dropdown', ['2020' => '2020',
        '2021' => '2021',
        '2022' => '2022',
        '2023' => '2023',
        '2024' => '2024',
        '2025' => '2025',
        '2026' => '2026',
        '2027' => '2027',   
        ]);

        $crud->fieldType('lineaAyuda', 'dropdown', ['XECS' => 'XECS',
        'ILS' => 'ILS',
        'IDI-ISBA' => 'IDI-ISBA']);

        $crud->fieldType('activeLineData', 'dropdown', ['SI' => 'SI',
        'NO' => 'NO']);

        $crud->fieldType('codigoSIA', 'number');
        $crud->fieldType('dias_fecha_lim_justificar', 'number');
        $crud->fieldType('meses_fecha_lim_consultoria', 'string');

       /*  $crud->fieldType('empresa', 'string');
        $crud->fieldType('nif', 'string');
        $crud->fieldType('domicilio', 'string'); */

        //->setRule('buyPrice', 'numeric')
        //->setRule('quantityInStock', 'integer');

        $crud->unsetDelete();
           
	    $output = $crud->render();

		return $this->_exampleOutput($output);

	}

    public function payment_orders() 
    {
        $modelConfig = new ConfiguracionModel();
	    $data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();
	    $convocatoria =  $data['configuracion']['convocatoria'];
        
        $crud = new GroceryCrud();

        $crud->setTable('pindust_expediente')
        ->setSubject('Ordre de pagament', 'Ordres de pagament')
        ->columns([ 'idExp', 'convocatoria', 'nif', 'empresa', 'importeAyuda', 'porcentajeConcedido',
                    'fecha_resolucion', 'fecha_notificacion_resolucion', 'cc_datos_bancarios', 'fechaEnvioAdministracion', 'ordenDePago'])
        
        ->displayAs('idExp', 'N. exped.')
        ->displayAs('convocatoria', 'Convocatòria')
        ->displayAs('empresa', 'Sol·licitant')
        ->displayAs('nif', 'Núm. CIF')
        ->displayAs('importeAyuda', 'Import concedit')
        ->displayAs('fecha_resolucion', 'Firma resolució')
        ->displayAs('fecha_notificacion_resolucion', 'Data notificació resolució')
        ->displayAs('cc_datos_bancarios', 'CC')
        ->displayAs('fechaEnvioAdministracion', 'Data enviament Administració')
        ->displayAs('ordenDePago', 'Afegir al fitxer de pagaments?')

        ->fields(['empresa', 'nif', 'fecha_resolucion', 'fecha_notificacion_resolucion', 'cc_datos_bancarios', 'fechaEnvioAdministracion', 'ordenDePago'])
        ->requiredFields(['fechaEnvioAdministracion', 'ordenDePago']);
        
        $crud->fieldType('ordenDePago', 'dropdown', ['SI' => 'SI', 'NO' => 'NO']);
        $crud->where( "ordenDePago = 'SI'" );
        $crud->where( "convocatoria = {$convocatoria}" );
        $crud->callbackColumn('idExp', function ($value, $row) {
            if (!empty($value)) {
                return "<a href='https://tramits.idi.es/public/index.php/expedientes/edit/" . $row->id."' target='_self'>$row->idExp/$row->convocatoria</a>";
            } else {
                // Make sure that you return white space or else the cell may break on print layout
                return '----';
            }
        });

        $crud->unsetAdd();
        $crud->unsetDelete();
        $crud->unsetEdit();

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

	public function orders_management() {
        $crud = new GroceryCrud();

        $crud->setRelation('customerNumber','customers','{contactLastName} {contactFirstName}');
        $crud->displayAs('customerNumber','Customer');
        $crud->setTable('orders');
        $crud->setSubject('Order');
        $crud->unsetAdd();
        $crud->unsetDelete();

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    public function offices_management () {
        $crud = new GroceryCrud();

        $crud->setTheme('datatables');
        $crud->setTable('offices');
        $crud->setSubject('Office');
        $crud->requiredFields(['city']);
        $crud->columns(['city','country','phone','addressLine1','postalCode']);
        $crud->setRead();

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    public function products_management() {
        $crud = new GroceryCrud();

        $crud->setTable('products');
        $crud->setSubject('Product');
        $crud->unsetColumns(['productDescription']);
        $crud->callbackColumn('buyPrice', function ($value) {
            return $value.' &euro;';
        });

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    public function employees_management()
    {
        $crud = new GroceryCrud();

        $crud->setTheme('datatables');
        $crud->setTable('employees');
        $crud->setRelation('officeCode','offices','city');
        $crud->displayAs('officeCode','Office City');
        $crud->setSubject('Employee');

        $crud->requiredFields(['lastName']);

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

    public function film_management()
    {
        $crud = new GroceryCrud();

        $crud->setTable('film');
        $crud->setRelationNtoN('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname');
        $crud->setRelationNtoN('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
        $crud->unsetColumns(['special_features','description','actors']);

        $crud->fields(['title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features']);

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }


    private function _exampleOutput($output = null) {
        
        return view('pages/exped/crud-solicitud', (array)$output);

    }


}