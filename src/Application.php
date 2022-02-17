<?php

namespace Bilbo;

use Bilbo\Http\Route;
use Bilbo\Http\Request;
use Bilbo\Http\Response;

class Application
{
    protected Route $route;
    protected Request $request;
    protected Response $response;


    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
    }

    // Run App
    public function run()
    {
        $this->route->resolve();
    }

    // Helper Function
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
