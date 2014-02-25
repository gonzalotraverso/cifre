<?
Class LoginController extends Controller
{
	public function getAction()
	{
		return View::make("login.login");
	}

	public function postAction()
	{
		$validator = Validator::make(
			Input::all(),
			User::$loginRules
			);

		if ($validator->passes()) {
			$credentials = array(
					'email' => Input::get('email'),
					'password' => Input::get('password'),
				);

			$remember = false;
			if(Input::get('remember') == 'true')
				$remember = true;

			if(Auth::attempt($credentials, $remember)){
				return Redirect::to('admin');
			}else{
				return Redirect::to('login');
			}
		} else {
			return Redirect::to('login')->withErrors($validator);
		}
	}

	public function logoutAction()
	{
		Auth::logout();
		return Redirect::to('login');
	}
}