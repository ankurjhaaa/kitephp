<?php

get('/', 'HomeController@index')->name('home');

// User CRUD Routes
get('/users', 'UserController@index')->name('users.index');
get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
post('/users/store', 'UserController@store')->name('users.store');
post('/users/update/{id}', 'UserController@update')->name('users.update');
post('/users/delete/{id}', 'UserController@destroy')->name('users.delete');
