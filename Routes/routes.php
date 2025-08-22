<?php
//defining routes for the application module

$routes = [
    '/'              => 'HomeController@index',
    '/users'         => 'UserController@index',
    '/users/create'  => 'UserController@create',
    '/users/store'   => 'UserController@store',
    '/products'      => 'ProductController@index',
    '/products/add'  => 'ProductController@add',
];
