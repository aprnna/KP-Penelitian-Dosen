<?php

// Home routes
$router->get('/', 'HomeController@index');
$router->get('home', 'HomeController@index');
$router->get('dashboard', 'DashboardController@index');
$router->get('dashboard/filterData', 'DashboardController@filterData');
$router->get('penelitian', 'PenelitianController@index');
$router->get('penelitian/detail/{id}', 'PenelitianController@detail');

// User routes
$router->get('user', 'UserController@index');
$router->get('user/detail/{id}', 'UserController@detail');
$router->get('user/create', 'UserController@create');
$router->post('user/store', 'UserController@store');
$router->get('user/edit/{id}', 'UserController@edit');
$router->post('user/update/{id}', 'UserController@update');
$router->post('user/delete/{id}', 'UserController@delete');

// Auth routes
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/login', 'AuthController@doLogin');
$router->post('/auth/logout', 'AuthController@logout');

// optional register
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/register', 'AuthController@doRegister');

$router->get('auth/google/login', 'AuthController@googleLogin');
$router->get('auth/google/register', 'AuthController@googleRegister');
$router->get('auth/google/callback', 'AuthController@googleCallback');

// Scraping routes
$router->get('scraping', 'ScrapingController@index');
$router->post('scraping/triggerScraping', 'ScrapingController@triggerScraping');
$router->get('scraping/getJobs', 'ScrapingController@getJobs');
$router->get('scraping/getJobDetails/{id}', 'ScrapingController@getJobDetails');
$router->get('scraping/getJobProgress/{id}', 'ScrapingController@getJobProgress');
$router->get('scraping/getLogs/{id}', 'ScrapingController@getLogs');
$router->post('scraping/webhook', 'ScrapingController@webhook');


// 404 handler
$router->notFound(function () {
  http_response_code(404);
  echo "404 - Halaman tidak ditemukan";
});
