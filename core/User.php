<?php

namespace Core;


//==============================================================================
//
//	Classe de gestion de l'utilisateur
// 
// 	L'utilisateur authentifié a une session, on peut le récupérer ou le détruire
//
//
//	@date 03/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

session_start();

use Core\{ ApplicationComponent, Application };


class User extends ApplicationComponent
{
	
	/**
	 * Constructor
	 *
	 * @param $app
	 */
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}
	
	/**
	 * Obtenir un attribut stocké en session
	 *
	 * @return mixed
	 */
	public function getAttribute($name)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	/**
	 * Obtenir un attribut temporaire (flash) stocké en session
	 *
	 * @return mixed
	 */
	public function getFlash()
	{
		$flash = $_SESSION['flash'];

		unset($_SESSION['flash']);

		return $flash;

	}

	/**
	 * Tester si un flash existe
	 *
	 * @return bool
	 */
	public function hasFlash()
	{
		return isset($_SESSION['flash']);
	}

	/**
	 * Tester si le user est authentifié
	 *
	 * @return bool
	 */
	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
	}

	/**
	 * Ajouter un attribut en session 
	 *
	 * @param $name
	 * @param $value
	 */
	public function setAttribute($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Definir si le user est authentifié ou pas
	 *
	 * @param $val
	 */
	public function setAuthenticate($val = true)
	{
		if( ! is_bool($val))
		{
			throw new \InvalidArgumentException('Valeur booléenne attendue');
		}

		$_SESSION['auth'] = $val;

	}

	/**
	 * Ajouter un flash
	 *
	 * @param $value
	 */
	public function setFlash($value)
	{
		$_SESSION['flash'] = $value;
	}

}