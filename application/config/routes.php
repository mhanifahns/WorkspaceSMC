<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth Routes
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';

// Credentials Routes
$route['credentials'] = 'credentials/index';
$route['credentials/new'] = 'credentials/create';
$route['credentials/store'] = 'credentials/store';
$route['credentials/edit/(:num)'] = 'credentials/edit/$1';
$route['credentials/update/(:num)'] = 'credentials/update/$1';
$route['credentials/delete/(:num)'] = 'credentials/delete/$1';
