<?php


namespace Core;


//==============================================================================
//
//	Classe de gestion des réponses HTTP
// 
// 	Elle permet de construire la réponse qui dévra être renvoyée au client
//	Les actions telles que la rédirection 404 et définission des cookies y 
//	sont implémentées
//
//
//	@date 25/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


class HTTPResponse
{

	/**
	 * Instance de l'application
	 *
	 * @var Application
	 */
	protected $app;
		
	/**
	 * Données de la vue
	 *
	 * @var string
	 */
	protected $data;

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
	 * Ajouter une entête
	 * 
	 * @param $header L'entête
	 *
	 */
	public function addHeader($header)
	{
		header($header);
	}

	public function redirect($location)
	{
		header('Location: '.$location);
		exit;
	}

	/**
	 * Page des erreurs
	 * 
	 */
	public function redirect404($msg = 'Page introuvable')
	{

		$data = compact('msg');

		$filename = 'Errors/404';

		$this->data = \view($filename, $data);

		$this->addHeader('HTTP/1.0 404 Not found');

		$this->send();

	}

	/**
	 * Renvoyer la page au client
	 */
	public function send()
	{
		exit($this->data);
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setCookie(
		$name, 
		$value = '', 
		$expire = 0, 
		$path = null, 
		$domain = null, 
		$secure = false, 
		$httpOnly = true
	)
	{
		setcookie(
			$name, 
			$value, 
			$expire, 
			$path, 
			$domain,
			$secure,
			$httpOnly
		);

	}

}