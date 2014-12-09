<?php

class Nolog {

	public static function islogged(){

		// Cache
		
		if(Session::has('user')){
			return Session::get('user');
		}

		// Get cookie

		$cookie = Cookie::get('user');

		if(!$cookie){
			return false;
		}

		// Get user

		$email = $cookie;

		$v = Validator::make(array('email' => $email), array(
			'email' => 'required|email'
		));

		if($v->fails()){
			die($v->messages());
		}

		//

		$model = Config::get('nologin::nologin.model_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		$user = $model::where($field_email, '=', $email)
			->first();

		Session::put('user', $user);

		return $user;
	}
}