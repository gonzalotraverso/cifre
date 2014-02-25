<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}


	public static $rules = array(
	    'username'=>'required|alpha|min:2',
	    'email'=>'required|email|unique:users',
	    'image'=>'image',
	    'password'=>'required|alpha_num|confirmed|min:6',
	    'password_confirmation'=>'required|alpha_num|min:6',
	    'role'=>'required|not_in:default'
    );

	public static $loginRules = array(
	    'email'=>'required|email',
	    'password'=>'required|alpha_num',
    );

}