<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::post('users/{users}/test', function(){
	echo Input::file('image');
	echo "succes";
});

Route::group(array(
		'before' => 'guest'
	),
		function(){
			Route::get('login', array(
					'as' => 'login',
					'uses' => 'LoginController@getAction'
				));


			Route::post('login', array(
					'as' => 'login',
					'uses' => 'LoginController@postAction'
				));




			Route::post('reminder', array(
					'as' => 'reminder',
					'uses' => 'RemindersController@postRemind'
				));



			Route::get('reminder', array(
					'as' => 'reminder',
					'uses' => 'RemindersController@getRemind'
				));


			

			Route::post('reset', array(
					'as' => 'reset',
					'uses' => 'resetsController@postReset'
				));



			Route::get('reset', array(
					'as' => 'reset',
					'uses' => 'RemindersController@getReset'
				));


			

		});




Route::group(array(
		'before' => 'auth'
	),
		function(){


			Route::get('admin', array(
					'as' => 'admin',
					'uses' => 'AdminController@showAdmin'
				));


			Route::get('logout', array(
					'as' => 'logout',
					'uses' => 'LoginController@logoutAction'
				));
		});

Route::group(array(
		'before' => 'auth|users'
	), 
	function(){

			Route::resource('users', 'UserController', 
				array('only' => array('index', 'create', 'store', 'destroy'))
				);
});

Route::group(array(
		'before' => 'auth|profile'
	), 
	function(){

			Route::resource('users', 'UserController', 
				array('only' => array('show', 'edit', 'update'))
				);
});


Route::get('/start', function()
{
    $admin = new Role();
    $admin->name = 'Administrator';
    $admin->save();
 
    $author = new Role();
    $author->name = 'Author';
    $author->save();
 
    $read = new Permission();
    $read->name = 'can_read_users';
    $read->display_name = 'Can Read Users';
    $read->save();
 
    $edit = new Permission();
    $edit->name = 'can_edit_users';
    $edit->display_name = 'Can Edit Users';
    $edit->save();
 
    $delete = new Permission();
    $delete->name = 'can_delete_user';
    $delete->display_name = 'Can Delete Users';
    $delete->save();
 
    $admin->attachPermission($edit);
    $admin->attachPermission($delete);
    $admin->attachPermission($read);

 	$user = User::where('username', 'admin');
    $all = User::whereNotIn('username', 'admin');
 
    $user->attachRole($admin);
    //$all->attachRole($author);
 
    return 'Woohoo!';
});




