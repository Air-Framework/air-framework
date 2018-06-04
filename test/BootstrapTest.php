<?php
use PHPUnit\Framework\TestCase;
use Air\Bootstrap\Bootstrap;

class BootstrapTest extends TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        try{
            $reflection = new \ReflectionClass(get_class($object));

            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);

            return $method->invokeArgs($object, $parameters);
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * @dataProvider routeProvider
     */
    public function testGetRouteFromRouter($routes, $uri, $expected)
    {
        $return = Bootstrap::getRouteFromRouter($routes, $uri);
        $this->assertEquals($expected, $return);
    }

    public function routeProvider()
    {
		/* Route */
		$uris [0] = '/route/myFirstParam/first/mySecondParam';
        $routes[0] = [
            'my_first_route' => [
                'pattern' => '/route/{param1}/first/{param2}',
                'controller' => '\AppNamespace\Controller\AjaxController',
                'method' => 'myFirstRouteAction'
            ]
        ];
         $expecteds[0] = [
          'pattern' => '/route/{param1}/first/{param2}',
          'controller' => '\AppNamespace\Controller\AjaxController',
          'method' => 'myFirstRouteAction',
          'params' => [
            'param1' => 'myFirstParam',
            'param2' => 'mySecondParam'
          ]
		];
		/* Route */
		$uris [1] = '/route/myFiraram/first/mySecondParam';
        $routes[1] = [            
			'my_second_route' => [
                'pattern' => '/route/{param1}/first/{param2}',
                'controller' => '\AppNamespace\Controller\AjaxController',
                'method' => 'myFirstRouteAction'
            ]
        ];	
		$expecteds[1] = [
          'pattern' => '/route/{param1}/first/{param2}',
          'controller' => '\AppNamespace\Controller\AjaxController',
          'method' => 'myFirstRouteAction',
          'params' => [
            'param1' => 'myFiraram',
            'param2' => 'mySecondParam'
          ]
        ];
		/* Route */
		$uris [2] = '/';
        $routes[2] = [            
			'index' => [
                'pattern' => '/',
                'controller' => '\AppNamespace\Controller\IndexController',
                'method' => 'indexAction'
            ]
        ];	
		$expecteds[2] = [
          'pattern' => '/',
          'controller' => '\AppNamespace\Controller\IndexController',
          'method' => 'indexAction'
        ];
		
		
		$i = 0;
		$stack = [];
		for($i =0; $i < count($routes); $i++)
			$stack[] = [$routes[$i], $uris[$i], $expecteds[$i]];
		
        return $stack;
    }
}