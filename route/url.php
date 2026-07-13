<?php

get('/', 'HomeController@index')->name('home');

// User CRUD Routes
get('/users', 'UserController@index')->name('users.index');
post('/users/save', 'UserController@save')->name('users.save');
post('/users/delete/{id}', 'UserController@destroy')->name('users.delete');
