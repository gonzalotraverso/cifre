<?

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\Image;

Class UserController extends Controller
{
	public function index()
	{
		$users = User::paginate(2);
		$data['users'] = $users;
		return View::make('user.all', $data);
	}

	public function show($id)
	{
		try{
			$user = User::findOrFail($id);
			$data['user'] = $user;
			$data['role'] = DB::select(DB::raw("SELECT name from roles where id in (select role_id from assigned_roles where user_id in (select id from users where id = :uid))"), array('uid' => $id));
			return View::make('user.single', $data);
		}
		catch(ModelNotFoundException $e)
		{
		    echo "not found";
		}	
	}

	public function create()
	{
		$roles = Role::all()->lists('name', 'id');
		$data['roles'] = $roles;
		return View::make('user.create', $data);
	}

	public function store()
	{
		
		$validator = Validator::make(Input::all(), User::$rules);
		if($validator->fails()){
			return Redirect::to('users/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}else{

			$user = new User;
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));

			$role = Role::find(Input::get('role'));
			$user->attachRole($role);

			if(Input::hasFile('image')){
				$fileName = Input::file('image')->getClientOriginalName();
				$dir = public_path().'/uploads/'.$user->email.'/';
				$upload = Input::file('image')->move($dir, $fileName);
				$user->image = $fileName;
			}


			$user->save();

			return Redirect::to('users')
				->with('message', 'Save succesful.');
		}
	}

	public function edit($id){
		try{
			$user = User::findOrFail($id);
			$data['user'] = $user;
			$data['roles'] = Role::all()->lists('name', 'id');
			$data['role'] = DB::select(DB::raw("SELECT id from roles where id in (select role_id from assigned_roles where user_id in (select id from users where id = :uid))"), array('uid' => $id));
			return View::make('user.edit', $data);
		}
		catch(ModelNotFoundException $e)
		{
		    echo "not found";
		}	
	}

	public function update($id)
	{

		$email = Input::get('email');
		$pass = Input::get('password');


		$user = User::find($id);

		$rules = array(
				'email' => 'required|unique:users,email,'.$user->id,
				'username' => 'required',
				'image' => 'image'
			);


		if($pass != ''){
			if(!Hash::check($pass, $user->password)){
				return Redirect::to('users/'.$id.'/edit')
						->with('message', 'Incorrect password.')
						->withInput(Input::except('password'));
			}else{
				$rules['new_password'] = 'required|min:6|alpha_num';			
			}
		}


		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::to('users/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}else{

			$user->username = Input::get('username');
			$user->email = $email;
			if($pass != '') $user->password = Hash::make(Input::get('new_password'));

			$role = Role::find(Input::get('role'));
			$user->attachRole($role);
			
			if(Input::hasFile('image') && $user->image != Input::file('image')->getClientOriginalName()){
				$fileName = Input::file('image')->getClientOriginalName();
				$dir = public_path().'/uploads/'.$user->email.'/';
				$upload = Input::file('image')->move($dir, $fileName);
				$user->image = $fileName;
			}
			
			$user->save();

			return Redirect::to('users')
				->with('message', 'Save succesful.');
		}
	}

	public function destroy($id)
	{
		try{
			$user = User::findOrFail($id);
			File::deleteDirectory(public_path().'/uploads/'.$user->email);
			$user->delete();
			if(Request::ajax()){
				$users = User::paginate(2);
				$url = URL::to('users');
				return Response::json(array('elements' => $users, 'url' => $url));
			}else{
				return Redirect::to('users')
				 	->with('message', 'Delete succesful.');
			}
		}
		catch(ModelNotFoundException $e)
		{
		    echo "not found";
		}	
	}
}