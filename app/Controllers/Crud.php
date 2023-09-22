<?php namespace App\Controllers;

// Add those two lines at the beginning of your controller
use App\Libraries\GroceryCrud;
use App\Models\ConfiguracionModel;

class Crud extends BaseController
{
	public function customers_management()
	{
	    $crud = new GroceryCrud();
	    $crud->setTable('pindust_expediente')
            ->setSubject('Sol·licitud', 'Sol·licituts')
            ->columns(['idExp', 'convocatoria', 'tipo_tramite', 'situacion', 'nif', 'empresa', 'domicilio', 'localidad', 'cpostal', 'telefono',
                        'telefono_rep', 'email_rep', 'nom_consultor', 'empresa_consultor', 'tel_consultor', 'mail_consultor',
                        'iae', 'importeAyuda', 'porcentajeConcedido','fecha_acta_cierre', 'fecha_REC', 'fecha_REC_enmienda', 'fecha_REC_amp_termino',
                        'fecha_REC_justificacion', 'fecha_REC_requerimiento_justificacion', 'fecha_REC_desestimiento', 'fecha_enmienda',
                        'fecha_kick_off', 'fecha_completado', 'fecha_limite_consultoria', 'fecha_reunion_cierre', 'fecha_limite_justificacion',
                        'fecha_propuesta_resolucion', 'fecha_propuesta_resolucion_notif', 'fecha_resolucion', 'fecha_notificacion_resolucion',
                        'fecha_requerimiento', 'fecha_requerimiento_notif', 'fecha_firma_requerimiento_justificacion',
                        'fecha_firma_resolucion_desestimiento', 'fecha_notificacion_desestimiento', 'fecha_infor_fav_desf',
                        'fecha_amp_termino', 'fecha_res_liquidacion', 'fecha_not_liquidacion', 'fecha_justificacion_ayuda_acta_cierre',
                        'fecha_de_pago', 'fecha_max_desp_ampliacion', 'ref_REC', 'ref_REC_enmienda', 'ref_REC_amp_termino', 'ref_REC_justificacion',
                        'ref_REC_requerimiento_justificacion', 'ref_REC_desestimiento', 'importe_minimis', 'tecnicoAsignado'])
            
                        ->displayAs('convocatoria', "Convocatòria")
                        ->displayAs('tipo_tramite', "Línia d'ajuda")
                        ->displayAs('situacion', "Situació")
                        ->displayAs('nif', 'NIF / CIF')
                        ->displayAs('cpostal', 'CP')
                        ->displayAs('telefono_rep', 'Telèfon notificacions')
                        ->displayAs('email_rep', 'Mail notificacions')
                        ->displayAs('iae', 'IAE')
                        ->displayAs('importeAyuda', 'Import ajut')
                        ->displayAs('porcentajeConcedido', '% concedit')

                        

            /*->displayAs('fecha_completado', 'Data complet')
            ->displayAs('tipo_tramite', 'Programa')
            ->displayAs('tipo_solicitante', "Tipus empresa")
            ->displayAs('empresa', 'Sol·licitant')
            ->displayAs('nif', 'NIF / CIF')
            ->displayAs('domicilio', 'Domicili')
            ->displayAs('email_rep', 'Adreça electrònica a efectes de notificacions')
            ->displayAs('telefono_rep', 'Mòbil a efectes de notificacions')
            ->displayAs('nombreConsultor', 'Consultor')
            ->displayAs('Situacion', 'Situació')*/

            ->fields(['tipo_tramite', 'tipo_solicitante', 'empresa', 'nif', 'domicilio', 'email_rep', 'telefono_rep', 'nombreConsultor'])

            ->requiredFields(['tipo_tramite', 'tipo_solicitante', 'empresa', 'nif', 'domicilio', 'email_rep', 'telefono_rep']);

        $crud->fieldType('tipo_tramite', 'dropdown', ['Programa_I' => 'Programa I',
        'Programa_II' => 'Programa II',
        'Programa_III' => 'Programa III']);

        $crud->fieldType('tipo_solicitante', 'dropdown', ['autonomo' => 'Autònom',
        'pequenya' => 'Petita',
        'mediana' => 'Mitjana']);

        $crud->fieldType('empresa', 'string');
        $crud->fieldType('nif', 'string');
        $crud->fieldType('domicilio', 'string');

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