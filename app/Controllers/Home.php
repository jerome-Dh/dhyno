<?php

namespace App\Controllers;


//==============================================================================
//
//	Controlleur Home
//
//
//	@date 05-08-2019 18:56 
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use App\Controllers\{ BaseController };

use Core\{ Application, HTTPRequest };

class Home extends BaseController
{

	/**
	 * Contructeur
	 */
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	/**
	 * Rétourner la vue "layout" au client
	 *
	 * @return string 
	 */
	public function index()
	{
		return view('Templates/layout');
	}

	/**
	 * Quelques tests
	 *
	 * @return string 
	 */
	public function show(HTTPRequest $request)
	{

		$name = 'Dhyno';

		$v = view('acceuil', compact('name'));

		echo '<p>App Name: '.app()->name().'</p>';

		echo '<p>App version: '.config('version').'</p>';

		echo '<p>URI: '.$request->requestURI().'</p>';

		return $v;

	}

}