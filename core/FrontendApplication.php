<?php

namespace Core;


//==============================================================================
//
//	Implémentation d'une application spécifique
// 
// 	Cette classe hérite de "Application" et implémente la méthode "run" spécifique
//	à l'application
//  Chaque Application lance une action d'un controlleur
//
//	@date 03/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\{ Application, Log };


class FrontendApplication extends Application
{

	/**
	 * Le contructeur
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Exécuter l'application
	 * La méthode rattrappe et gère toutes les exceptions lancées
	 *
	 * @return html
	 */
	public function run()
	{
		try
		{
			
			$this->init();
	
			//Si c'est un controlleur
			if($this->getRoute()->isRouteController())
			{
				$controller = $this->getControllerInstance();

				$data = $controller->execute();

			}
			else
			{
				$data = view($this->getViewName());
			}

			$this->httpResponse->setData($data);

			$this->httpResponse->send();

		}
		catch(\Exception $e)
		{
			//S'il y a encore exception, on affiche le message brut
			try
			{
				$this->httpResponse->redirect404($e->getMessage());
			}
			catch(\Exception $e)
			{
				$this->httpResponse->setData(htmlentities($e->getMessage()));
				$this->httpResponse->send();
			}
		}

	}

}