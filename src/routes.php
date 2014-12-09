<?php

Route::get('nologin', 'NologinController@getLogin');
Route::post('nologin', 'NologinController@postLogin');

Route::post('nologin/confirm', array('uses' => 'NologinController@confirmEmail'));

Route::get('nologin/logout', array('uses' => 'NologinController@logout'));
