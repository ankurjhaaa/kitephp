<?php

get('/', 'HomeController@index')->name('home');
get('/about', 'HomeController@about')->name('about');
post('/submit', 'HomeController@submit')->name('submit');
