<?php

Route::filter('nologin', function(){

	$table = Config::get('nologin::nologin.table_user');
	$model = Config::get('nologin::nologin.model_user');
	$field_email = Config::get('nologin::nologin.db_field_email');

	$logged = false;

	if(Session::has($table)){

		//todo verify is user is not null

		$logged = true;
		
	}else {

		if(isset($_COOKIE["{$table}_email"])){

			$user_email = $_COOKIE["{$table}_email"];

			$user = $model::select('*')
				->where($field_email, '=', $user_email)
				->first();

			//todo verify if there is one!

			Session::put($table, $user);
			$logged = true;
		}
	}

	if(!$logged){

		//dd($_SERVER["REQUEST_URI"]);
		//dd(Request::url());

		return Redirect::to(URL::to('nologin').'?redirect='.urlencode($_SERVER["REQUEST_URI"]));
	}
});
