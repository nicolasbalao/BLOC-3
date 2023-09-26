<?php

namespace App\Routes;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/**
 * Class for handling routing of the app
 *
 * @package App\Routes
 */
class Router
{

    // Routes of the app
    private $routes = array();


    /**
     * Declare a GET route 
     * 
     * $router->get("/resource", [Controller::class, 'method'])
     * 
     * $router->get("/resource/{arg}", [Controller::class, 'method'])
     *
     * @param $url the url path
     * @param $handler the function to execute on the route
     */
    public function get($url, $handler)
    {
        $this->addRoute($url,  $handler, "GET");
    }

    /**
     * Declare a POST route
     * 
     * $router->get("/resource", [Controller::class, 'method'])
     * 
     * $router->get("/resource/{arg}", [Controller::class, 'method'])
     *
     * @param $url the url path
     * @param $handler the function to execute on the route
     */
    public function post($url, $handler)
    {
        $this->addRoute($url,  $handler, "POST");
    }

    /**
     * Declare a PUT route
     * 
     * $router->get("/resource", [Controller::class, 'method'])
     * 
     * $router->get("/resource/{arg}", [Controller::class, 'method'])
     *
     * @param $url the url path
     * @param $handler the function to execute on the route
     */
    public function put($url, $handler)
    {
        $this->addRoute($url, $handler, "PUT");
    }

    /**
     * Declare a DELETE route 
     * 
     * $router->get("/resource", [Controller::class, 'method'])
     * 
     * $router->get("/resource/{arg}", [Controller::class, 'method'])
     *
     * @param $url the url path
     * @param $handler the function to execute on the route
     */
    public function delete($url, $handler)
    {
        $this->addRoute($url, $handler, "DELETE");
    }

    /**
     * Adding routes to the app   
     * 
     * @param $url the url path
     * @param $handler the function to execute on the route
     * @param $methode Http methode default = GET
     */
    private function addRoute(string $url, array $handler, string $method = "GET")
    {
        $this->routes[] = array('url' => $url, 'handler' => $handler, 'method' => $method);
    }

    /**
     * Handle the request maping throught the routes
     */
    public function handleRequest()
    {
        $role = "unlogged";
        if (isset($_SESSION['user']['role'])) {
            $role = $_SESSION['user']['role'];
        }
        // Get the request URI
        $request_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        // Allow requests from any origin
        // TODO: Make restriction for only api route 
        // http://localhost:8100 -> ionic client dev
        header("Access-Control-Allow-Origin: http://localhost:8100");

        foreach ($this->routes as $route) {

            // Build the regex for extract information of the URI
            $pattern = $this->buildPattern($route["url"]);

            // Check if the $route match the URI and if the request method is the same of the route method
            // preg_match => check if the route match the URI  and extract argument
            if (preg_match($pattern, $request_url, $matches) && $route['method'] === $_SERVER["REQUEST_METHOD"]) {

                // Remove the full text matched
                array_shift($matches);
                // Remove the text that matched the first captured
                array_pop($matches);

                /*
                 Exemple: URI => http://localhost/test/1
                          $matches = ["id" => 1]
                */

                if (is_array($route["handler"])) {
                    $handler = $route["handler"];
                    // Init the controller 
                    $controller = new $handler[0]();
                    // Extract the methode
                    $method = $handler[1];
                    // Execute the method of the controller with arguments extracted from the URI
                    $controller->$method(...$matches);
                } else {
                    echo "here";
                }
                return;
            }
        }

        $this->handle404();
    }

    private function handle404()
    {
        header('HTTP/1.0 404 Not Found');
        require_once(__DIR__ . '/../Views/404.php');
    }

    private function handle401()
    {
        header('HTTP/1.0 401 Unauthorized');
        require_once(__DIR__ . '/../Views/401.php');
    }


    private function buildPattern($path)
    {
        $pattern = preg_replace('/\//', '\\/', $path);
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\\/]+)', $pattern);
        $pattern = '/^' . $pattern . '$/';
        return $pattern;
    }
}
