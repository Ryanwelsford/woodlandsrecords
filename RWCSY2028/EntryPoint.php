<?php
namespace RWCSY2028;
class EntryPoint {
	private $routes;

	public function __construct(Routes $routes) {
		$this->routes = $routes;
	}

	public function run() {
		//get the url
		session_start();
		$route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

		//get routes array 
		$routes = $this->routes->getRoutes();
		//var_dump($page);

		//check if user is allowed to access this page
		$route = $this->routes->checkLogin($route);

		//method is get/post
		$method = $_SERVER['REQUEST_METHOD'];
		//prevents bug with non existent pages, essentially just reroutes user to returned page when they attempt to access pages that arent real. NGINX wasnt doing this for some reason
		//method added, accessing a page that requires a post submission directly through get reroutes to home page
		if(!isset($routes[$route][$method])) {
			$route = $this->routes->getReroute();
		}

		
		$controller = $routes[$route][$method]['controller'];
		$functionName = $routes[$route][$method]['function'];
		//pull controller and function from routes array build page

		$page = $controller->$functionName();

		$output = $this->loadTemplate('../templates/' . $page['template'], $page['variables']);

		$title = $page['title'];
		//pull out variables required for layouts pages
		$layoutVars = $this->routes->getLayoutVariables();
		extract($layoutVars);
		
		require  '../templates/layout.html.php';
	}
	
	public function loadTemplate($fileName, $templateVars) {
		extract($templateVars);
		ob_start();
		require $fileName;
		$contents = ob_get_clean();
		return $contents;
	}
}