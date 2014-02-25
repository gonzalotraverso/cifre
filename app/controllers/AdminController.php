<?php

class AdminController extends Controller {

	
	public function showAdmin()
	{
		return View::make('admin.index');
	}

}