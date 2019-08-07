<?php


namespace Core;


//==============================================================================
//
//	Classe de contruction des routes
// 
//	Elle gère les routes de l'application
//
//
//	@date 30/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Exceptions\RoutesException;

use Core\Route;

class Router
{
	/**
	 * Les routes 
	 *
	 * @var array
	 */
	protected $routes = [];
	
	/**
	 * Le nom du fichier
	 *
	 * @var string
	 */
	protected $filename;
 
	/**
	 * Constantes symbolisant l'absence de route
	 *
	 * @var array
	 */
	const NO_ROUTE = 1;
	const NO_GET_ROUTE = 2;
	const NO_POST_ROUTE = 3;

	/**
	 * Les constantes des routes
	 *
	 * @var string
	 */
	const ROUTE_WEB = 'web';
	const ROUTE_API = 'api';
	const ROUTE_GET = 'get';
	const ROUTE_POST = 'post';

	public function __construct($filename = '')
	{
		$this->setFileName($filename);

		$this->init();
	}

	/**
	 * Former un tableau de routes avec les données du fichier routes.xml
	 */
	private function init()
	{
		$file = $this->getFileName();

		$this->routes = [];

		if(file_exists($file))
		{
			$xml = new \DOMDocument();

			$ret = $xml->load($file);

			$domList = $xml->getElementsByTagName('routes');

			if($domList->count() > 0)
			{
				$childNodes = $domList->item(0)->childNodes;

				$this->routes = [

					self::ROUTE_WEB => [
					
						self::ROUTE_GET => $this->construireRoute(
							$childNodes, 
							self::ROUTE_WEB, 
							self::ROUTE_GET
						),

						self::ROUTE_POST => $this->construireRoute(
							$childNodes, 
							self::ROUTE_WEB, 
							self::ROUTE_POST
						),
				
					],
					self::ROUTE_API => [

						self::ROUTE_GET => $this->construireRoute(
								$childNodes, 
								self::ROUTE_API, 
								self::ROUTE_GET
						),

						self::ROUTE_POST => $this->construireRoute(
							$childNodes, 
							self::ROUTE_API, 
							self::ROUTE_POST
						),

					],
				];
			}
			else
			{
				throw new RoutesException('Balise <routes> manquante dans le fichier de routes');
			}
		}
		else
		{
			throw new RoutesException('Fichier de routes introuvable');
		}

	}
	
	/**
	 * Récupérer les options d'une URL spécifique
	 *
	 * @param $node
	 * @param $type
	 * @param $verb - Get/Post
	 *
	 * @return array - Tableau des routes et options 
	 */
	private function construireRoute(Object $nodes, $type, $verb)
	{
		$result = [];

		foreach($nodes as $childNode)
		{

			if($childNode->nodeName == $type)
			{
				$nodeWebOrApi = $childNode->childNodes;
				
				foreach($nodeWebOrApi as $childGetOrPost)
				{
					if($childGetOrPost->nodeName == $verb)
					{
						$attrs = $childGetOrPost->attributes;

						$tempo = [];
						foreach($attrs as $attr)
						{
							$tempo[$attr->name] = $attr->textContent;
						}

						//Contruire le tableau de correspondance
						$result[] = new Route(trim($tempo['url']), trim($tempo['action']));
					}
				}
			}
		}

		return $result;

	}


	/**
	 * Tester si une route existe
	 *
	 * @param $uri
	 *
	 * @return boolean
	 */
	public function routeExists($uri) : bool
	{
		return
			$this->routeWebExists($uri)
				or 
					$this->routeApiExists($uri);
	}

	/**
	 * Tester si une route existe dans la catégorie Web
	 *
	 * @param $uri
	 *
	 * @return boolean
	 */
	public function routeWebExists($uri) : bool
	{
		return
			$this->routeWebGetExists($uri)
				or
					$this->routeWebPostExists($uri);
	}

	/**
	 * Tester si une route existe dans la catégorie Web Get
	 *
	 * @param $uri
	 *
	 * @return boolean
	 */
	public function routeWebGetExists($uri) : bool
	{
		return $this->findExistsRoute($uri, $this->routes[self::ROUTE_WEB][self::ROUTE_GET]);
	}

	/**
	 * Tester si une route existe dans la catégorie Web Post
	 *
	 * @param $uri
	 *
	 * @return boolean
	 */
	public function routeWebPostExists($uri) : bool
	{
		return $this->findExistsRoute($uri, $this->routes[self::ROUTE_WEB][self::ROUTE_POST]);
	}

	/**
	 * Tester si une route existe dans la catégorie API
	 *
	 * @param $uri
	 *
	 * @return boolean
	 */
	public function routeApiExists($uri) : bool
	{
		return
			$this->findExistsRoute($uri, $this->routes[self::ROUTE_API][self::ROUTE_GET])
			or
			$this->findExistsRoute($uri, $this->routes[self::ROUTE_API][self::ROUTE_POST]);
	}

	/**
	 * Tester si une route existe dans un tableau de routes
	 *
	 * @param $uri
	 * @param $tabRoutes
	 *
	 * @return boolean
	 */
	public function findExistsRoute($uri, array $tabRoutes) : bool
	{
		foreach($tabRoutes as $route)
		{
			if($route->getUrl() == $uri)
			{
				return true;
			}
		}

		return false;

	}

	/**
	 * Récupérer la route correspondante à une URI
	 *
	 * @param $uri
	 *
	 * @return Route|false
	 */
	public function getWebRoute($uri, $method)
	{
		if($method == self::ROUTE_GET or $method == self::ROUTE_POST) 
		{
			foreach($this->routes[self::ROUTE_WEB][$method] as $route)
			{
				if($route->getUrl() == $uri)
				{
					return $route;
				}
			}
		}
		
		return false;
	
	}
		

	/**
	 * Retourner le tableau des routes
	 *
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Récupérer le nom du fichier de routes
	 *
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * Modifier le nom du fichier de routes
	 *
	 * @param $filename 
	 */
	public function setFileName($filename = '')
	{
		if( ! empty($filename))
		{
			if( ! file_exists($filename))
			{
				throw new RoutesException('Fichier de routes introuvable');
			}
	
			$this->filename = $filename;
		}
		else
		{
			$this->filename = \base_dir().'app/Config/routes.xml';
		}
	}

}

