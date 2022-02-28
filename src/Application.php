<?php

namespace Bilbo;

use Bilbo\Http\Route;
use Bilbo\Http\Request;
use Bilbo\Http\Response;
use Bilbo\Support\Config;

class Application
{
    protected Route $route;
    protected Request $request;
    protected Response $response;
    protected Config $config;


    public function __construct()
    {
        $this->request  = new Request;
        $this->response = new Response;
        $this->route  = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigurations());
    }


    // loading Configurations
    protected function loadConfigurations()
    {
        // Get All Dir in Config File
        foreach (scandir(config_path()) as $file) {
            // skep . & ..
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filename = explode('.', $file)[0]; // Get First Element
            yield $filename => require config_path() . $file;
        }
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
