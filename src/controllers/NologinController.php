<?php
class NologinController extends BaseController {

	public static function clean_email($email){

		//todo Remove special chars

		return trim(strtolower(Input::get($email)));
	}

	public static function set_session($user){

		$table = Config::get('nologin::nologin.table_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		Session::put($table, $user);

		if($user){
			setcookie("{$table}_email", $user->$field_email, time()+2592000, '/');
		}else{
			setcookie("{$table}_email", '', time()+2592000, '/');
		}
	}

	public static function delete_session(){

		NologinController::set_session(null);
	}

	public static function redirect($to){

		if($to){
			//return Redirect::to($to);
			dd(Request::root());
			return Redirect::to(Request::root().$to);
		}else{
			return Redirect::to('/');
		}	
	}

	###########################################################################

	// Try to login the user. If not exist, we ask to confirm email.
	public function tryLogin(){

		$email1 = $this->clean_email('email1');
		$redirect = Input::get('redirect');
		//dd($redirect);

		//todo validate if it's an email

		$model = Config::get('nologin::nologin.model_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		//dd($model);

		$user = $model::select('*')
			->where($field_email, '=', $email1)
			->first();

		//dd($user);

		if(count($user) > 0){

			//User::setCookie($user);
			$this->set_session($user);

			return $this->redirect($redirect);		

		}else{

			//todo overwrite view

			return View::make('nologin::login-confirm', compact('email1', 'redirect'));
		}
	}

	// The user doesn't exist so we validate the emails and log the user.
	public function confirmEmail(){

		// Validate emails

		$email1 = $this->clean_email('email1');
		$email2 = $this->clean_email('email2');
		$redirect = Input::get('redirect');

		if($email1 != $email2){
			echo 'Error: Come on... the two emails need to be identical!!';
			die();
		}

		// Create user

		$model = Config::get('nologin::nologin.model_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		$user = new $model;
		$user->$field_email = $email1;

		$user->save();

		$this->set_session($user);
		//User::setCookie($user);

		//return Redirect::to('books');
		return $this->redirect($redirect);
	}

	public function logout(){

		$this->delete_session();

		return Redirect::to('nologin');
	}
	
	/*
	public static function set_session($user){

		setcookie("dez_nologin", $user->email.';'.$user->key, time()+31536000, '/'); //one year

		Session::put('user', array(
			'logged' 	=> true,
			'user' 		=> $user
		));
	}

	public static function delete_session(){
		
		setcookie("dez_nologin", "", time()-3600, '/');

		Session::forget('user');
	}

	public static function empty_session(){

		Session::put('user', array(
			'logged' 	=> false,
			'user' 		=> null
		));
	}
	*/
}