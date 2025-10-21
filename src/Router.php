<?php
namespace Src;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler)
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function run()
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Hilangkan base path agar cocok dengan route di index.php
        $basePath = '/api-php-native/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Hilangkan trailing slash
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            $routePath = rtrim($route['path'], '/') ?: '/';

            // Ubah {id} jadi regex pattern (contoh: {id} -> ([a-zA-Z0-9_]+))
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // hapus path penuh
                $params = [];

                // Ambil nama parameter dari path {id}
                if (preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $routePath, $paramNames)) {
                    foreach ($paramNames[1] as $i => $name) {
                        $params[$name] = $matches[$i] ?? null;
                    }
                }

                // Jalankan handler dengan parameter
                call_user_func($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Route not found"]);
    }
}
