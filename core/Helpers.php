<?php

//==============================================================================
//
//	Les helpers
//
//	Ces fonctions ont pour but d'aider l'utilisateur dans les taches basiques
//	Elles fournissent des utilitaires pratiques pour programmer plus vite.
//	De plus l'utilisateur pourra ajouter ses propres fonctions ou les utiliser
//	à sa convenance
//
//
//	@date 26/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


if( ! function_exists('base_url'))
{
	/**
	 * Obtenir l'url de base de l'application
	 *
	 * @return string
	 */
	function base_url()
	{
		return $_SERVER['REMOTE_ADDR'].':'.$_SERVER['SERVER_PORT'];
	}
}

if( ! function_exists('base_dir'))
{
	/**
	 * Obtenir le chemin de base de l'application
	 *
	 * @return string
	 */
	function base_dir()
	{
		return dirname(dirname(__FILE__)).'/';
	}
}

if( ! function_exists('uri'))
{
	/**
	 * Obtenir l'uri en cours
	 *
	 * @return string
	 */
	function uri()
	{
		return $_SERVER['REQUEST_URI'];
	}
}

if( ! function_exists('controller_dir'))
{
	/**
	 * Obtenir le chemin des controlleurs de l'application
	 *
	 * @return string
	 */
	function controller_dir()
	{
		return base_dir().'app/Controllers/';
	}
}

if( ! function_exists('model_dir'))
{
	/**
	 * Obtenir le chemin des models de l'application
	 *
	 * @return string
	 */
	function model_dir()
	{
		return base_dir().'app/Models/';
	}
}

if( ! function_exists('view_dir'))
{
	/**
	 * Obtenir le chemin des vues de l'application
	 *
	 * @return string
	 */
	function view_dir()
	{
		return base_dir().'app/Views/';
	}
}

if( ! function_exists('template_dir'))
{
	/**
	 * Obtenir le chemin des templates
	 *
	 * @return string
	 */
	function template_dir()
	{
		return view_dir().'Templates/';
	}
}

if( ! function_exists('error_dir'))
{
	/**
	 * Obtenir le chemin des erreurs
	 *
	 * @return string
	 */
	function error_dir()
	{
		return view_dir().'Errors/';
	}
}

if( ! function_exists('test_dir'))
{
	/**
	 * Obtenir le chemin des tests
	 *
	 * @return string
	 */
	function test_dir()
	{
		return base_dir().'tests/';
	}

}

if( ! function_exists('storage_dir'))
{
	/**
	 * Obtenir le chemin des stockages
	 *
	 * @return string
	 */
	function storage_dir()
	{
		return base_dir().'storages/';
	}
}

if( ! function_exists('log_dir'))
{
	/**
	 * Obtenir le chemin des logs
	 *
	 * @return string
	 */
	function log_dir()
	{
		return storage_dir().'logs/';
	}

}

if( ! function_exists('view'))
{
	/**
	 * Obtenir la réponse d'une d'une vue
	 *
	 * @return string
	 */
	function view($filename, array $data = [])
	{
		return (new \Core\View($filename, $data))->getContent();
	}

}

if( ! function_exists('config'))
{
	/**
	 * Obtenir la valeur d'une constante de la class "App"
	 *
	 * @return string
	 */
	function config($key)
	{
		try
		{
			$reflectionClass = new \ReflectionClass('\App\Config\App');

			return $reflectionClass->getConstant(strtoupper($key));
		}
		catch(\ReflectionException $e)
		{
			return false;
		}

	}

}

if( ! function_exists('app'))
{
	/**
	 * Obtenir une instance de l'application
	 *
	 * @return \Core\FrontendApplication
	 */
	function app()
	{
		return \Core\FrontendApplication::getInstance();
	}

}

if( ! function_exists('user'))
{
	/**
	 * Obtenir une instance de User
	 *
	 * @return \Core\User
	 */
	function user()
	{
		return ( ! is_null(\app()) ) ? app()->user() : null;
	}

}

