<?php


namespace Core;


//==============================================================================
//
//	Classe réprésentant la composante de base de l'application
// 
//	Elle gère l'application
//
//
//	@date 25/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


abstract class ApplicationComponent
{
	/**
	 * L'application
	 *
	 * @var Application
	 */
	protected $app;

	/**
	 * Le contructeur
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function app()
	{
		return $this->app;
	}

}