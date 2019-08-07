<?php


namespace Core;


//==============================================================================
//
//	Classe réprésentant l'application
// 
// 	Elle récupère la réquête du client et lui génère une réponse en traitant 
//	les données
//
//
//	@date 25/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\{ Router, Exceptions\RoutesException, User, Route };

abstract class Application
{
	/**
	 * La réquête
	 *
	 * @var HTTPRequest
	 */
	protected $httpRequest;

	/**
	 * La réponse
	 *
	 * @var HTTPResponse
	 */
	protected $httpResponse;

	/**
	 * Le nom de l'application
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Le user 
	 *
	 * @var User
	 */
	protected $user;

	/**
	 * Le tableau des routes
	 *
	 * @var array
	 */
	protected $router;
	
	/**
	 * La route de l'application
	 *
	 * @var Route
	 */
	protected $route;
	
	/**
	 * Exporter l'instance de cette classe
	 *
	 * @var $this
	 */
	private static $export_this = null;

	/**
	 * Le contructeur
	 */
	public function __construct()
	{
		
	}

	/**
	 * Initialiser les instances
	 */
	protected function init()
	{
		$this->httpRequest = new HTTPRequest($this);

		$this->httpResponse = new HTTPResponse($this);

		// echo $this->httpRequest()->queryString();

		$this->name = \config('name');

		$this->user = new User($this);
		
		//Obtenir le tableau des routes
		$this->setRoutes();

		//Controller la présence des fichiers
		$this->checkExistsRoute();

		//Exporter cette instance
		self::$export_this = $this;

	}

	

	/**
	 * Vérifier l'existence de la route dans le fichier XML
	 *
	 * @throws \Exception
	 */
	protected function checkExistsRoute()
	{

		$uri = $this->httpRequest->requestURI();

		$method = strtolower($this->httpRequest->method());

		if( ! $this->router->routeExists($uri))
		{
			throw new RoutesException('Route introuvable !', Router::NO_ROUTE);
		}

		//Vérifier que le verbe correspond bien à celle de la route
		if( $method == Router::ROUTE_GET and ! $this->router->routeWebGetExists($uri) )
		{
			throw new RoutesException('Methode GET not allowed !', Router::NO_GET_ROUTE); 
		}

		if( $method == Router::ROUTE_POST and ! $this->router->routeWebPostExists($uri))
		{
			throw new RoutesException('Methode POST not allowed !', Router::NO_POST_ROUTE); 
		}

		//Vérifier l'existence du controlleur
		$this->route = $this->router->getWebRoute($uri, $method);

		if( ! $this->route)
		{
			throw new RoutesException('Route introuvable !', Router::NO_ROUTE); 
		}
		else
		{
			//Vérifier l'existence des fichiers
			if( $this->route->isRouteController() )
			{
				$controller = $this->route->getController();
				$m = $this->route->getMethodName();
				$this->checkExistsController($controller, $m);
			}
			else
			{
				$view = $this->route->getAction();
				$this->checkExistsViews($view);
			}
		}
	}

	/**
	 * Vérifier l'existence d'un controlleur et son action
	 * 
	 * @param $name
	 * @param $action
	 *
	 * @return bool
	 *
	 * @throws Exception
	 */
	protected function checkExistsController($name, $action)
	{
		$filename = controller_dir().'/'.($name).'.php';

		if( file_exists($filename) )
		{
			$refection = new \ReflectionClass('App\Controllers\\'.$name);
			
			//Vérifier la classe parente
			$parent = $refection->getParentClass();
			if( ! $parent or ($parent->getShortName() != 'BaseController'))
			{
				throw new \Exception('La classe <'.$name.'> doit hériter de <BaseController>');
			}
			
			//Vérifier que l'action est publique et non statique
			try
			{
				$m = $refection->getMethod ( $action );

				if( ! $m->isPublic() or $m->isStatic())
				{
					throw new \Exception('La méthode <'.$action.'> du controlleur <'.$name.'> doit avoir la visibilité publique non statique');
				}				
			}
			catch(\ReflectionException  $e)
			{
				throw new \Exception('La méthode <'.$action.'> n\'existe pas dans le controlleur <'.$name.'>');
			}

		}
		else
		{
			throw new \Exception('Controlleur <'.$name.'> introuvable dans <'.controller_dir().'> !');
		}

		return true;

	}

	/**
	 * Vérifier l'existence d'une vue
	 * 
	 * @param $name
	 *
	 * @return bool
	 *
	 * @throws Exception
	 */
	protected function checkExistsViews( $name )
	{
		$filename = view_dir().($name).'.php';

		if( ! file_exists($filename))
		{
			throw new \Exception('Vue <'.$name.'.php> introuvable dans <'.\view_dir().'> !');
		}

		return true;

	}
	
	/**
	 * Exécuter l'instance du controller
	 */
	protected function getControllerInstance()
	{

		$controller = $this->route->getController();

		$m = $this->route->getMethodName();

		// On ajoute les variables de l'URL au tableau $_GET.
		// $_GET = array_merge($_GET, $matchedRoute->vars());

		// On instancie le contrôleur.
		$controllerClass = 'App\Controllers\\'.$controller;

		$instanceController = new $controllerClass($this);
		$instanceController->setAction($m);
		$instanceController->setController($controller);

		return $instanceController;

	}

	//Exécuter l'application
	abstract protected function run();

	/**
	 * Obtenir le tableau des routes
	 * 
	 * @throws \Exception
	 */
	protected function setRoutes()
	{
		$this->router = new Router();
	}

	/**
	 * La route pour le web
	 *
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->route;
	}

	public function httpRequest()
	{
		return $this->httpRequest;
	}

	public function httpResponse()
	{
		return $this->httpResponse;
	}

	public function name()
	{
		return $this->name;
	}

	public function user()
	{
		return $this->user;
	}

	/**
	 * Retourner le nom de la vue
	 *
	 * @return string
	 */
	public function getViewName()
	{
		return $this->route->getAction();
	}
	
	/**
	 * Retourner l'instance de l'application en cours d'exéction
	 * 
	 * @return $this
	 */
	public static function getInstance()
	{
		return self::$export_this;
	}


}