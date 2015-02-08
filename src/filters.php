<?php

Route::filter('nologin', function(){

	$user = Nolog::islogged();

	if(!$user){

		//Session::put('redirect', urlencode($_SERVER["REQUEST_URI"]));
		//dd($_SERVER);
		Session::put('redirect', $_SERVER["REQUEST_URI"]);

		//todo redirect
		//		return Redirect::to(URL::to('nologin').'?redirect='.urlencode($_SERVER["REQUEST_URI"]));
		return Redirect::to('nologin');
		//return Redirect::to(URL::to('nologin').'?redirect='.urlencode($_SERVER["REQUEST_URI"]));
	}	
});
