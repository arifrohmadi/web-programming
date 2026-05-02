<?php

class Router {
    private array $routes = [];

    public function add(string $method, string $pattern, callable $handler): void {
        $this->routes[] = compact('method', 'pattern', 'handler');
    }

    public function dispatch(string $method, string $uri): void {
        $uri = strtok($uri, '?'); // strip query string

        foreach ($this->routes as $route) {
            if (strtoupper($method) !== strtoupper($route['method'])) continue;

            $regexPattern = preg_replace('/\{(\w+)\}/', '(\d+)', $route['pattern']);
            $regexPattern = "@^{$regexPattern}$@";

            if (preg_match($regexPattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], array_map('intval', $matches));
                return;
            }
        }

        Response::error('Route not found', 404);
    }
}
