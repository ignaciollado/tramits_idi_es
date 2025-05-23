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
/* $routes->get('photos/new', 'Photos::new');
$routes->post('photos', 'Photos::create'); */
$routes->get('expediente', 'ApiController::index');
$routes->get('expediente/(:segment)/(:segment)/(:segment)', 'ApiController::getExpediente/$1/$2/$3');
$routes->get('nifExpediente/(:segment)', 'ApiController::getExpedientebyNIF/$1');
$routes->get('numExpediente/(:segment)/(:segment)', 'ApiController::getExpedientebyExp/$1/$2');

/* $routes->get('photos/(:segment)/edit', 'Photos::edit/$1');
$routes->put('photos/(:segment)', 'Photos::update/$1');
$routes->patch('photos/(:segment)', 'Photos::update/$1');
$routes->delete('photos/(:segment)', 'Photos::delete/$1'); */

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
//$routes->get('/home/sol_idigital', 'Home::sol_idigital',['filter' => 'auth']);
$routes->get('logout', 'LoginController::logout');

$routes->options('/recovery/hello', 'MailController::options');
$routes->get('/recovery/hello', 'MailController::index');
$routes->options('/recovery/password', 'MailController::options');
$routes->get('/recovery/password', 'MailController::sendMail');


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
