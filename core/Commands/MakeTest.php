<?php


namespace Core\Commands;


//==============================================================================
//
//	Création des tests
// 
//	Cette étends la classe de base "BaseMake" et crée un test dans 
//	le dossier cible
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Commands\BaseMake;

class MakeTest extends BaseMake
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

namespace Tests;

//==============================================================================
//
//	Classe de test
//
//	@date '.$date.' 
//
//	@author
//
//=============================================================================


use PHPUnit\Framework\TestCase;


class '.$name.' extends TestCase
{

	/**
	 * Exécuter avant chaque test 
	 */
	public function setUp() : void
	{

	}

	/**
	 * Exécuter après chaque test 
	 */
	public function tearDown(): void
	{

	}

	/**
	 * Cette méthode ne fait rien de spécial, elle confirme juste
	 */
	public function testSimple()
	{
		$tab = array_sum([2, 3, -5]);

		$this->assertTrue($tab == 0);
	}
	
	/// Ton code ici ..

}';

		return $texte;
	
	}
	
}