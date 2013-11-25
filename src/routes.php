<?php

Route::get('nologin', function(){
	
	$redirect = Input::get('redirect');

	return View::make('nologin::login', compact('redirect'));
});

Route::post('nologin', array('uses' => 'NologinController@tryLogin'));

Route::post('nologin/confirm', array('uses' => 'NologinController@confirmEmail'));

Route::get('nologin/logout', array('uses' => 'NologinController@logout'));
