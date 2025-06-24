<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->resource('apicontroller', ['websafe' => 1]);
$routes->get('expediente', 'ApiController::index');
$routes->get('expediente/(:segment)/(:segment)/(:segment)', 'ApiController::getExpediente/$1/$2/$3');
$routes->get('nifExpediente/(:segment)', 'ApiController::getExpedientebyNIF/$1');
$routes->get('numExpediente/(:segment)/(:segment)', 'ApiController::getExpedientebyExp/$1/$2');

$routes->get('/', 'LoginController::index');
$routes->post('login', 'LoginController::login');
$routes->post('loginGoogle', 'LoginController::loginGoogle');
$routes->get('content', 'LoginController::content');
$routes->get('home', 'Home::ca');
$routes->get('/home/ca', 'Home::ca', ['filter' => 'auth']);
$routes->get('/home/es', 'Home::es', ['filter' => 'auth']);
$routes->get('/expedientes', 'Expedientes::index', ['filter' => 'auth']);
$routes->get('/expedientes/edit/(:num)', 'Expedientes::edit/$1',['filter' => 'auth']);
$routes->get('/expedientes/configurador_edit', 'Expedientes::configurador_edit',['filter' => 'auth']);
$routes->get('/expedientes/filtrarexpedientes', 'Expedientes::filtrarexpedientes',['filter' => 'auth']);
$routes->get('/custodia', 'Custodia::index',['filter' => 'auth']);
$routes->get('logout', 'LoginController::logout');

$routes->options('/recovery/hello', 'MailController::options');
$routes->get('/recovery/hello', 'MailController::index');
$routes->options('/recovery/password', 'MailController::options');
$routes->get('/recovery/password', 'MailController::sendMail');


/* API REST end points */
/* Pindust Expediente */

// Rutas RESTful para PindustExpedienteController
$routes->get('pindustexpediente', 'PindustExpedienteController::index');// Obtener todas los expedientes
$routes->get('pindustexpediente/(:num)', 'PindustExpedienteController::show/$1'); // Obtener un expediente
$routes->get('pindustexpediente/convocatoria/(:segment)', 'PindustExpedienteController::getByConvocatoria/$1'); // Obtener un expediente por convocatoria y, opcionalmente, tipo_trámite
$routes->post('pindustexpediente/create', 'PindustExpedienteController::create');  // Crear un nuev expediente
$routes->put('pindustexpediente/update/(:segment)', 'PindustExpedienteController::update/$1'); // Actualizar un expediente
$routes->delete('pindustexpediente/delete/(:segment)', 'PindustExpedienteController::delete/$1'); // Eliminar un expediente

// Rutas para preflight (CORS)
$routes->options('pindustexpediente/', 'PindustExpedienteController::options');
$routes->options('pindustexpediente/(:num)', 'PindustExpedienteController::options');
$routes->options('pindustexpediente/convocatoria/(:segment)', 'PindustExpedienteController::options'); // Obtener un expediente por convocatoria y, opcionalmente, tipo_trámite
$routes->options('pindustexpediente/create', 'PindustExpedienteController::options');
$routes->options('pindustexpediente/update/(:segment)', 'PindustExpedienteController::options');
$routes->options('pindustexpediente/delete/(:segment)', 'PindustExpedienteController::options');

// Insert Document into bbdd
$routes->get('pindustdocument/(:segment)/(:segment)', 'PindustDocumentoController::show/$1/$2'); // Obtener un documento por nif y timestamp
$routes->options('pindustdocument/(:segment)/(:segment)', 'PindustDocumentoController::options');

$routes->get('pindustdocument/expediente/(:num)', 'PindustDocumentoController::getByExpediente/$1'); //Obtiene todos los documentos de un expediente
$routes->options('pindustdocument/expediente/(:num)', 'PindustDocumentoController::options');

$routes->post('pindustdocument/create', 'PindustDocumentoController::create');  // Crear un nuev documento
$routes->options('pindustdocument/create', 'PindustDocumentoController::options');

$routes->put('pindustdocument/update/(:segment)', 'PindustDocumentoController::update/$1'); // Actualizar un documento
$routes->delete('pindustdocument/delete/(:segment)', 'PindustDocumentoController::delete/$1'); // Eliminar un documento

// Rutas RESTful para PindustActividadesCNAEController
// ActividadesCNAE API REST - Rutas individuales

$routes->get('pindustactividades', 'PindustActividadesCNAEController::index');
$routes->options('pindustactividades', 'PindustActividadesCNAEController::options');

$routes->get('pindustactividades/(:num)', 'PindustActividadesCNAEController::show/$1');
$routes->options('pindustactividades/(:num)', 'PindustActividadesCNAEController::options');

$routes->post('pindustactividades', 'PindustActividadesCNAEController::create');
$routes->options('pindustactividades', 'PindustActividadesCNAEController::options');

$routes->put('pindustactividades/(:num)', 'PindustActividadesCNAEController::update/$1');
$routes->options('pindustactividades/(:num)', 'PindustActividadesCNAEController::options');

$routes->delete('pindustactividades/(:num)', 'PindustActividadesCNAEController::delete/$1');
$routes->options('pindustactividades/(:num)', 'PindustActividadesCNAEController::options');

/* Documents upload API */
$routes->options('documents/(:segment)/(:segment)', 'DocumentController::options');
$routes->get('documents/(:segment)/(:segment)', 'DocumentController::index/$1/$2'); /* list all documents in folder path: nif/timestamp */

$routes->options('document/upload/(:any)/(:any)', 'DocumentController::options');
$routes->post('document/upload/(:any)/(:any)', 'DocumentController::upload/$1/$2'); /* upload the document */

$routes->options('documents/delete/(:any)/(:num)/(:any)', 'DocumentController::optionsDelete');
$routes->delete('documents/delete/(:any)/(:num)/(:any)', 'DocumentController::delete/$1/$2/$3'); /* delete the document ?????? */


//$routes->get('(:any)', 'LoginController::login');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
