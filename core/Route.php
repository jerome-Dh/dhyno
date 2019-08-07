<?php


namespace Core;


//==============================================================================
//
//	Classe réprésentant une route
// 
//	Elle gère les différentes actions d'une route
//
//
//	@date 25/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


class Route
{
	protected $action;

	protected $controller;

	protected $url;

	protected $varsNames;

	protected $vars = array();

	public function __construct($url, $action)
	{
		$this->setUrl($url);
		$this->setAction($action);
		$this->setController();
	}

	/**
	 * Tester si une route mène vers un controlleur
	 *
	 * @param $action
	 *
	 * @return bool
	 */
	public function isRouteController() : bool
	{
		return (stristr($this->action, '@') !== false) ? true : false;
	}

	/**
	 * Récupérer le nom du controlleur lié à la route
	 *
	 * @return string|null
	 */
	public function setController()
	{
		if($this->isRouteController())
		{
			$this->controller = explode('@', $this->action)[0];
		}
	}

	/**
	 * Récupérer la méthode du controlleur lié à une action
	 *
	 * @param $action
	 *
	 * @return string
	 */
	public function getMethodName()
	{
		return

			$this->isRouteController() ? 

				explode('@', $this->action)[1] : $this->action;

	}

	public function hasVars()
	{
		return ! empty($this->varsNames);
	}

	public function match($url)
	{
		if (preg_match('`^'.$this->url.'$`', $url, $matches))
		{
			return $matches;
		}
		else
		{
			return false;
		}
	}

	public function setAction($action)
	{
		if (is_string($action))
		{
			$this->action = $action;
		}
	}

	/**
	 * Modifier l'url
	 * Ajouter le caractère "/" s'il n'y en a pas 
	 */
	public function setUrl($url)
	{
		if (is_string($url))
		{
			$this->url = (substr($url, 0, 1) != '/') ?  '/'.$url : $url;
		}
	}
	
	public function getUrl()
	{
		return $this->url;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function vars()
	{
		return $this->vars;
	}

	public function varsNames()
	{
		return $this->varsNames;
	}

}