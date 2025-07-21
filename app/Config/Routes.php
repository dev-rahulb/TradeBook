<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');

$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::signupPost');

$routes->get('verify', 'Auth::verify');
$routes->post('verify', 'Auth::verifyPost');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');

$routes->get('logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::forgotPasswordPost');

$routes->get('reset-password', 'Auth::resetPasswordForm');
$routes->post('reset-password', 'Auth::handleResetPassword');

// Protected routes — require login
$routes->group('', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Journal
    $routes->get('journal', 'Journal::index');
    $routes->get('journal/create', 'Journal::create');
    $routes->post('journal/store', 'Journal::store');
    $routes->get('journal/edit/(:num)', 'Journal::edit/$1');
    $routes->post('journal/update/(:num)', 'Journal::update/$1');
    $routes->get('journal/delete/(:num)', 'Journal::delete/$1');
    $routes->get('journal/calendar', 'Journal::calendar');
    $routes->get('journal/dayView/(:segment)', 'Journal::dayView/$1');

    // Analytics
    $routes->get('analytics', 'Analytics::index');

    // AI Coach
    $routes->get('ai-coach', 'AICoach::index');
    $routes->post('ai-coach/generate', 'AICoach::generate');
    $routes->post('ai-coach/delete/(:num)', 'AICoach::delete/$1');

    $routes->get('profile', 'Auth::profile');
$routes->get('change-password', 'Auth::changePassword');
$routes->post('change-password', 'Auth::changePasswordPost');

});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('users', 'Admin::users');
    $routes->get('toggle-block/(:num)', 'Admin::toggleBlock/$1');
    $routes->get('change-role/(:num)', 'Admin::changeRole/$1');
});

