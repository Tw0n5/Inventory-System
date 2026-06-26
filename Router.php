<?php
    class Router {
        private $routes = [];
        //Register paths to the tracking index array
        public function add(string $method, string $path, string $handler) {
            $this->routes[] = [
                'method' => $method,
                'path' => $path,
                'handler' => $handler
            ];
        }
        //match execution paths to controller
        public function dispatch() {
        //normalize the request url path striping query text strings
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            foreach ($this->routes as $route){
                if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                    // split handler parts into Class and Method name
                    list($controller, $method) = explode('@', $route['handler']);

                    if (class_exists($controller)){
                        $controllerInstance= new $controller();
                        $controllerInstance->$method();
                        return;
                    }
                }
            }
            header("HTTP/1.0 404 Not Found");
            echo "404 Page Not Found";
        }
    }
?>