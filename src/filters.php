<?php

Route::filter('nologin', function(){

	$user = Nolog::islogged();

	if(!$user){
		//todo redirect
		//		return Redirect::to(URL::to('nologin').'?redirect='.urlencode($_SERVER["REQUEST_URI"]));
		return Redirect::to('nologin');
	}
});
