<?php
use PHPUnit\Framework\TestCase;

/**
 * Test de la classe \Core\Router
 */
class CoreRouterTest extends TestCase
{

	/*
	 * Test du constructeur
	 */
	public function testConstruct(){
		$url = 'test';
		$expected = $url;

		$router = $this->getMockBuilder('\Core\Router')
			->setConstructorArgs([$url])
			->getMock();

		$Class = new \ReflectionClass('\Core\Router');
		$Method = $Class->getMethod('__construct');
		//$Method->setAccessible(true);

		$Method->invoke($router, $expected);
		$Property = $Class->getProperty('url');
		$Property->setAccessible(true);
		$this->assertSame($expected, $Property->getValue($router));
	}

	/*
	 * Test de la méthode get
	 */
	public function testGet(){
		$expected = 'rt';
		$url = 'test';

		$router = $this->getMockBuilder('\Core\Router')
			->setConstructorArgs([$url])
			->getMock();

		$router->get('/',['controller' => 'Accueil', 'action' => 'index']);

		$Class = new \ReflectionClass('\Core\Router');
		$Method = $Class->getMethod('get');

		$Method->invoke($router, '/',['controller' => 'Accueil', 'action' => 'index']);
		$Property = $Class->getProperty('routes');
		$Property->setAccessible(true);

		// Test si le tableau des routes à bien une clé GET
 		$this->assertArrayHasKey('GET', $Property->getValue($router));
	}

	/*
	 * Test de la méthode post
	 */
	public function testPost(){
		$url = 'test';
		$router = $this->getMockBuilder('\Core\Router')
			->setConstructorArgs([$url])
			->getMock();

		$router->get('/',['controller' => 'Accueil', 'action' => 'index']);

		$Class = new \ReflectionClass('\Core\Router');
		$Method = $Class->getMethod('post');

		$Method->invoke($router, '/',['controller' => 'Accueil', 'action' => 'index']);
		$Property = $Class->getProperty('routes');
		$Property->setAccessible(true);

		// Test si le tableau des routes à bien une clé POSt
 		$this->assertArrayHasKey('POST', $Property->getValue($router));
	}

	/*
	 * Test de la methode run sans méthode
	 */
	public function testRunSansMethode(){

		try {
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$router = new Core\Router('/route');
			$result = $router->run();
		} catch(\Exception $ex){
			$this->assertEquals($ex->getCode(), 9000);
			return;
		}
		$this->fail("L'exception n'a pas été levée");
	}

	/*
	 * Test de la methode run avec méthode et sans route
	 */
	public function testRunAvecMethodeSansRoute(){

		try {
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$router = new Core\Router('/route');
			$router->get('/none',['controller' => 'ctrl', 'action' => 'act']);
			$result = $router->run();
		} catch(\Exception $ex){
			$this->assertEquals($ex->getCode(),404);
			return;
		}
		$this->fail("L'exception n'a pas été levée");
	}

	/*
	 * Test de la methode run
	 */
	public function testRun(){

		$url = 'test';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		require('./tests/CtrlController.php');
		$router = new Core\Router('/route');
		$router->get('/route',['controller' => 'ctrl', 'action' => 'act']);
		$result = $router->run();

	}
}



