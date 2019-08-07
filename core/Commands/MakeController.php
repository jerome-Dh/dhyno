<?php


namespace Core\Commands;


//==============================================================================
//
//	Création des controlleurs
// 
//	Cette étends la classe de base "BaseMake" et crée un controlleur dans 
//	le dossier cible
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Commands\BaseMake;

class MakeController extends BaseMake
{

	/**
	 * Retourner le contenu du controlleur à créer
	 *
	 * @return string
	 */
	public function getContent($name) : string
	{
		$date = (new \Datetime('now', new \DateTimeZone("Africa/Douala")))
					->format('d-m-Y H:i');

		$texte = '<?php

namespace App\Controllers;


//==============================================================================
//
//	Controlleur '.$name.'
//
//
//	@date '.$date.' 
//
//	@author 
//
//=============================================================================


use App\Controllers\{ BaseController };

use Core\{ Application };

class '.$name.' extends BaseController
{

	/** 
	 * Contructeur
	 */
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	/**
	 * Rétourner la vue "welcome" au client
	 *
	 * @return string 
	 */
	public function index()
	{
		return view(\'welcome\');
	}

	/// Ton code ici ..

}';

		return $texte;

	}

}