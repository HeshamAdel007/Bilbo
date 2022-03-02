<?php

namespace Bilbo;

use Bilbo\Http\Route;
use Bilbo\Database\DB;
use Bilbo\Http\Request;
use Bilbo\Http\Response;
use Bilbo\Support\Config;
use Bilbo\Support\Session;
use Bilbo\Database\Managers\MySQLManager;

class Application
{
    protected Route $route;
    protected Request $request;
    protected Response $response;
    protected Config $config;
    protected DB $db;
    protected Session $session;


    public function __construct()
    {
        $this->request  = new Request;
        $this->response = new Response;
        $this->route  = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigurations());
        $this->db = new DB($this->getDatabaseDriver());
        $this->session = new Session;
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
    } // End Of loadConfigurations


    protected function getDatabaseDriver()
    {
        return match (env('DB_DRIVER')) {
            'mysql' => new MySQLManager,
            default => new MySQLManager
        };
    } // End Of getDatabaseDriver

    // Run App
    public function run()
    {
        $this->db->init();
        $this->route->resolve();
    }

    // Helper Function
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
} // ENd Of Class
