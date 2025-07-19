<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::signupPost');
$routes->get('verify', 'Auth::verify');
$routes->post('verify', 'Auth::verifyPost');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');

// Dashboard or other protected routes (later)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/logout', 'Auth::logout');

// Journal Routes
$routes->get('journal', 'Journal::index');                // List all entries
$routes->get('journal/create', 'Journal::create');        // Show create form
$routes->post('journal/store', 'Journal::store');         // Handle create form
$routes->get('journal/edit/(:num)', 'Journal::edit/$1');  // Show edit form
$routes->post('journal/update/(:num)', 'Journal::update/$1'); // Handle update
$routes->get('journal/delete/(:num)', 'Journal::delete/$1');  // Delete entry


$routes->get('analytics', 'Dashboard::analytics');


$routes->get('journal/calendar', 'Journal::calendar');
$routes->get('journal/dayView/(:segment)', 'Journal::dayView/$1');

$routes->get('ai-coach', 'AICoach::index');
$routes->post('ai-coach/generate', 'AICoach::generate');

$routes->post('ai-coach/delete/(:num)', 'AICoach::delete/$1');
