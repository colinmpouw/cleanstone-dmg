<?php
class Router
{
    private $routes = [];

    public function get($uri, $callback)
    {
        $this->routes['GET'][$uri] = $callback;
    }

    public function post($uri, $callback)
    {
        $this->routes['POST'][$uri] = $callback;
    }


    public function dispatch()
    {
        ob_start();

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        $method = $_SERVER['REQUEST_METHOD'];


        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            ob_end_flush();
            return;
        }


        foreach ($this->routes[$method] ?? [] as $route => $callback) {

            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $route);
            $pattern = "@^" . rtrim($pattern, '/') . "$@";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($callback, $matches);
                ob_end_flush();
                return;
            }
        }


        http_response_code(404);


        if (str_starts_with($uri, '/admin')) {
            $errorPage = __DIR__ . '/admin/admin404.php';
        } else {
            $errorPage = __DIR__ . '/public/404.php';
        }

        if (file_exists($errorPage)) {
            require $errorPage;
        } else {
            echo "<h1>404 Not Found</h1>";
            echo "<p>The requested URL '$uri' was not found on this server.</p>";
        }

        ob_end_flush();
    }

}
