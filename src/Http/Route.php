<?php
namespace Bilbo\Http;

use Bilbo\View\View;

class Route
{
    protected Request $request;
    protected Response $response;
    protected static array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function get($route, callable|array|string $action)
    {
        self::$routes['get'][$route] = $action;
    }

    public static function post($route, callable|array|string $action)
    {
        self::$routes['post'][$route] = $action;
    }

    // Resolve Outcome From Method
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method(); // Get OR Post
        $action = self::$routes[$method][$path] ?? false;

        // If Action Not Exists
        // if (!$action) {
        //     return;
        // }
        if (!array_key_exists($path, self::$routes[$method])) {
            $this->response->setStatusCode(404);
            View::makeError('404');
        }
        
        // If Action Is A Callable
        if (is_callable($action)) {
            call_user_func_array($action, []);
        }

        // If Action Is A Array
        if (is_array($action)) {
            $controller = new $action[0];
            $method = $action[1];
            call_user_func_array([$controller, $method], []);
        }
    }
}
