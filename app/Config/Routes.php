<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// RUTAS COMANDA
$routes->get('/comanda', 'Comanda::index');
$routes->post('/comanda', 'Comanda::create');
$routes->get('/comanda/(:num)', 'Comanda::show/$1');
$routes->put('/comanda/(:num)', 'Comanda::update/$1');
$routes->delete('/comanda/(:num)', 'Comanda::delete/$1');

// RUTAS MENU

$routes->get('/menu', 'Menu::index');
$routes->post('/menu', 'Menu::create');
$routes->get('/menu/(:num)', 'Menu::show/$1');
$routes->put('/menu/(:num)', 'Menu::update/$1');
$routes->delete('/menu/(:num)', 'Menu::delete/$1');


//RUTAS LOGIN
$routes->post('login', 'Login::index');
$routes->get('login', 'Login::showLoginForm');
$routes->post('login', 'Login::processLogin');
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::index');


// Ruta Usuarios 
$routes->get('usuarios', 'Usuario::index');

// Ruta para crear un nuevo usuario (create)
$routes->post('usuarios', 'Usuario::create');

// Ruta para obtener un usuario por su ID (show)
$routes->get('usuarios/(:num)', 'Usuario::show/$1');

// Ruta para actualizar un usuario por su ID (update)
$routes->put('usuarios/(:num)', 'Usuario::update/$1');

// Ruta para eliminar un usuario por su ID (delete)
$routes->delete('usuarios/(:num)', 'Usuario::delete/$1');