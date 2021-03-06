<?php

namespace Tests;

//==============================================================================
//
//	Exemple de test
// 
//	Chaque classe de test étend TestCase et est définie par un nom
//	se terminant par "Test"
//	Chaque méthode de test dévra commencer par le mot "test" pour être 
//	réconnue automatiquement comme élement à tester
//
//
//	@date 30/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
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

}
	
	
	
	