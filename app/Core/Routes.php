
<?php

class Router
{
    private $routes = [];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = [
            'action' => $action
        ];
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = [
            'action' => $action
        ];
    }

    public function dispatch(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        $uri = (string) $uri;

        // Remove project base directory from URL
        $scriptDir = str_replace(
            '\\',
            '/',
            dirname($_SERVER['SCRIPT_NAME'] ?? '')
        );

        $baseDir = preg_replace(
            '#/public$#',
            '',
            $scriptDir
        );

        if (
            $scriptDir !== ''
            && $scriptDir !== '/'
            && stripos($uri, $scriptDir) === 0
        ) {
            $uri = substr($uri, strlen($scriptDir));
        } elseif (
            $baseDir !== ''
            && $baseDir !== '/'
            && stripos($uri, $baseDir) === 0
        ) {
            $uri = substr($uri, strlen($baseDir));
        }

        $uri = '/' . trim($uri, '/');

        // Match the requested URL against registered routes
        foreach ($this->routes[$httpMethod] ?? [] as $routePath => $route) {

            $segments = explode('/', trim($routePath, '/'));
            $regexParts = [];

            foreach ($segments as $segment) {

                // Dynamic parameter, e.g. {id}
                if (
                    preg_match(
                        '/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/',
                        $segment,
                        $matches
                    )
                ) {
                    $regexParts[] = '([^/]+)';
                } else {
                    // Match static path segments safely
                    $regexParts[] = preg_quote($segment, '#');
                }
            }

            $pattern = '#^/' . implode('/', $regexParts) . '/?$#';

            if (preg_match($pattern, $uri, $matches)) {

                // Remove the full matched URL
                array_shift($matches);

                // Get controller and method
                [$controller, $methodName] = $route['action'];

                $controllerInstance = new $controller();

                // Pass URL parameters to the controller
                $controllerInstance->$methodName(...$matches);

                return;
            }
        }

        http_response_code(404);
        echo '404 - page Not found';
    }
}

