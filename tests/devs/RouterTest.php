<?php

namespace Tests;

//==============================================================================
//
//	Classe de test
//
//	@date 05-08-2019 11:27 
//
//	@author Jerome Dh
//
//=============================================================================

require __dir__ . '/include.php';

use PHPUnit\Framework\TestCase;

use Core\Router;

use Tests\CreateRouteXML;

class RouterTest extends TestCase
{

	use CreateRouteXML;

	/**
	 * Tableau des routes
	 *
	 * @var array
	 */
	protected $router = null;
	
	/**
	 * Nom du fichier de routes
	 *
	 * @var string
	 */
	private static $filename = __dir__ . '/routes.xml';

	/**
	 * Exécuter avant chaque test 
	 */
	public function setUp() : void
	{
		if($this->router == null)
		{
			$this->router = new Router(self::$filename);
		}
	}

	/**
	 * Exécuter après chaque test 
	 */
	public function tearDown(): void
	{

	}

	/**
	 * Créer le fichier xml des routes
	 *
	 * @beforeClass
	 */
	public static function createXMLFile()
	{
		self::createXML(self::$filename);

		if( ! file_exists(self::$filename))
		{
			exit('Impossible de continuer les tests');
		}

	}

	/**
	 * Test routeExists
	 */
	public function testRouteExists()
	{
		$this->assertTrue($this->router->routeExists('/'));
		$this->assertTrue($this->router->routeExists('test'));
		$this->assertFalse($this->router->routeExists('no-route'));
	}

	/**
	 * Test routeWebGetExists
	 */
	public function testRouteWebGetExists()
	{
		$this->assertTrue($this->router->routeWebGetExists('/'));
	}

	/**
	 * Test routeWebPostExists
	 */
	public function testRouteWebPostExists()
	{
		$this->assertTrue($this->router->routeWebPostExists('/'));
		$this->assertTrue($this->router->routeWebPostExists('test'));
		$this->assertFalse($this->router->routeWebPostExists('no-route'));
	}

	/**
	 * Test routeApiExists
	 */
	public function testRouteApiExists()
	{
		$this->assertTrue($this->router->routeApiExists('/'));
		$this->assertFalse($this->router->routeApiExists('notApiRoute'));
	}

	/**
	 * Test getWebRoute
	 */
	public function testGetWebRoute()
	{
		$this->assertNotNull($this->router->getWebRoute('/', 'get'));
		$this->assertNotNull($this->router->getWebRoute('/', 'post'));
		$this->assertFalse($this->router->getWebRoute('noExists', 'post'));
		$this->assertFalse($this->router->getWebRoute('/', 'badMethod'));
		
		$this->assertTrue($this->router->getWebRoute('/', 'get') instanceof \Core\Route);
	
	}

	/**
	 * Test routeApiExists
	 */
	public function testGetRoutes()
	{
		$this->assertTrue(is_array($this->router->getRoutes()));
	}	
	

}