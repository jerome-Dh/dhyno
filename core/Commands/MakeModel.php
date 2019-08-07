<?php


namespace Core\Commands;


//==============================================================================
//
//	Création des models
// 
//	Cette étends la classe de base "BaseMake" et crée un model dans 
//	le dossier cible
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Commands\BaseMake;

class MakeModel extends BaseMake
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

namespace App\Models;


//==============================================================================
//
//	Model '.$name.'
//
//
//	@date '.$date.' 
//
//	@author 
//
//=============================================================================


use Core\{ BaseModel };


class '.$name.' extends BaseModel
{

	/** 
	 * Contructeur
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/// Ton code ici ..

}';

		return $texte;

	}

}