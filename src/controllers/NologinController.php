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

	public function getLogin(){

		$redirect = Input::get('redirect');

		$vars = compact('redirect');
		$view = 'nologin.login';

		if(View::exists($view)){
			return View::make($view, $vars);
		}else{
			return View::make('nologin::login', $vars);
		}
	}

	// Try to login the user. If not exist, we ask to confirm email.
	public function postLogin(){

		$input = Input::all();

		$redirect = Input::get('redirect');
		$email = $input['email1'];

		// Validate

		$v = Validator::make($input, array(
			'email1' => 'required|email'
		));

		if($v->fails()){
			die($v->messages());
		}

		// Get user

		$model = Config::get('nologin::nologin.model_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		$user = $model::where($field_email, '=', $email)
			->first();

		if($user){

			//$user->login();
			Nolog::login($user);

			//return Redirect::to('/');
			return $this->redirect($redirect);
			
		}else{
			
			$vars = compact('email', 'redirect');
			$view = 'nologin.login-confirm';

			if(View::exists($view)){
				return View::make($view, $vars);
			}else{
				return View::make('nologin::login-confirm', $vars);
			}
		}
	}

	// The user doesn't exist so we validate the emails and log the user.
	public function confirmEmail(){

		$input = Input::all();

		// Validate

		$v = Validator::make($input, array(
			'email1' => 'required|email',
			'email2' => 'required|email',
		));

		if($v->fails()){
			die($v->messages());
		}

		if($input['email1'] != $input['email2']){
			die('Error: Emails are different.');
		}

		// Create user

		$model = Config::get('nologin::nologin.model_user');
		$field_email = Config::get('nologin::nologin.db_field_email');

		$user = $model::where($field_email, '=', $input['email1'])
			->first();

		if(!$user){
			
			$user = new $model;
			$user->$field_email = $input['email1'];

			$user->save();
		}

		Nolog::login($user);

		return $this->redirect(Input::get('redirect'));
	}

	public function logout(){

		//$this->delete_session();

		if(Session::has('user')){

			$user = Session::get('user');

			// Delete cookie

			Cookie::forget('user'); //necessaire??
			Cookie::queue('user', '', 60 * 24 * 60); //2 months		

			Session::forget('user');
		}

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