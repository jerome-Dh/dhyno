<?php

namespace App\Controllers;


//==============================================================================
//
//	BaseController
// 
// 	La classe de base de tout controlleur, elle définie les	opérations communes sur tout
//	controlleur de l'application
//
//
//	@date 31/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use Core\{ ApplicationComponent, Application, DB\DBManager, Page };


abstract class BaseController extends ApplicationComponent
{

	/**
	 * La méthode cible
	 *
	 * @var string
	 */
	protected $action = '';
	
	/**
	 * Le controller
	 *
	 * @var string
	 */
	protected $controller = '';
	
	/**
	 * La page
	 *
	 * @var Page
	 */
	protected $page = null;
	
	/**
	 * L'instance PDO
	 *
	 * @var \PDO
	 */
	protected $pdo;

	/** 
	 * Contructeur
	 *
	 * @param $app
	 * @param $controller
	 * @param $action
	 */
	public function __construct(Application $app)
	{
		parent::__construct($app);

		$this->setDBManager();

	}

	/**
	 * Exécuter la méthode cible dans le controller
	 *
	 * @return string
	 *
	 * @throws InvalidArgumentException
	 */
	public function execute()
	{
		if( ! is_callable([$this, $this->action]))
		{
			throw new \InvalidArgumentException ('Impossible d\'exécuter l\'action <'.$this->action.'> sur ce controlleur');
		}

		//Exécuter la méthode
		$action = $this->action;

		if($this->methodHasRequestParam())
		{
			$ret = $this->$action($this->app->httpRequest());
		}
		else
		{
			$ret = $this->$action();
		}

		return $ret;

	}

	/**
	 * Modifier l'application
	 */
	public function setApplication(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Contruire l'objet de la connexion à la BD
	 */
	public function setDBManager()
	{
		$this->pdo = (new DBManager())->getPDO();
	}

	/**
	 * Vérifier si la méthode possède le paramètre HTTPRequest
	 *
	 * @return bool
	 */
	public function methodHasRequestParam()
	{
		$reflectionController = new \ReflectionClass('App\Controllers\\'.$this->controller);

		$m = $reflectionController->getMethod ( $this->action );

		$params = $m->getParameters();
		foreach($params as $param)
		{
			if($param->getClass()->getShortName() == 'HTTPRequest')
			{
				return true;
			}
		}

		return false;

	}

	/**
	 * Modifier l'action
	 *
	 * @param $action
	 */
	public function setAction($action)
	{
		if( ! is_string($action) or empty($action))
		{
			throw new \InvalidArgumentException('L\'action doit être une chaine valide');
		}

		$this->action = $action;

	}

	/**
	 * Modifier le controller
	 *
	 * @param $controller
	 */
	public function setController($controller)
	{
		if( ! is_string($controller) or empty($controller))
		{
			throw new \InvalidArgumentException('L\'action doit être une chaine valide');
		}

		$this->controller = $controller;

	}

}