<?php
// routes/web.php

// Home routes
$router->get('/', 'HomeController@index');
$router->get('home', 'HomeController@index');

// User routes
$router->get('user', 'UserController@index');
$router->get('user/detail/{id}', 'UserController@detail');
$router->get('user/create', 'UserController@create');
$router->post('user/store', 'UserController@store');
$router->get('user/edit/{id}', 'UserController@edit');
$router->post('user/update/{id}', 'UserController@update');
$router->post('user/delete/{id}', 'UserController@delete');

// 404 handler
$router->notFound(function () {
  http_response_code(404);
  echo "404 - Halaman tidak ditemukan";
});
