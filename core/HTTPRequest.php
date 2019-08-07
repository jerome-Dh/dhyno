<?php


namespace Core;


//==============================================================================
//
//	Classe de gestion des réquêtes HTTP
// 
// 	Elle permet d'obtenir les informations sur la réquête envoyée par le client 
//	telsque les cookies, le type de réquête et bien d'autre
//
//
//	@date 25/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


class HTTPRequest
{
	
	/**
	 * Instance de l'application
	 *
	 * @var Application
	 */
	protected $app;
	
	/**
	 * Constructor
	 *
	 * @param Application
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Obtenir un cookie
	 * 
	 * @param $key Le nom du cookie 
	 *
	 * @return mixed si le cookie existe ou null sinon
	 */
	public function cookieData($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

	public function cookieExists($key)
	{
		return isset($_COOKIE[$key]);
	}

	public function getData($key)
	{
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}

	public function getExists($key)
	{
		return isset($_GET[$key]);
	}

	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function postData($key)
	{
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	public function postExists($key)
	{
		return isset($_POST[$key]);
	}

	/**
	 * Extraire uniquement l'URI
	 * Ignorer le queryString ou le "?" en fin de chaine
	 *
	 * @return string
	 */	 
	public function requestURI()
	{
		$t = $_SERVER['REQUEST_URI'];

		$qString = $this->queryString();

		if($qString and strlen($t))
		{
			$pos = stripos($t, $qString);

			$text = substr($t, 0, ($pos - 1));

		}
		elseif(substr($t, (strlen($t) - 1)) == '?')
		{
			$text = substr($t, 0, (strlen($t) - 1));
		}
		else
		{
			$text = $t;
		}

		return $text;

	}

	public function queryString()
	{
		return $_SERVER['QUERY_STRING'] ?? null;
	}

}