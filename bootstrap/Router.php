<?php

namespace bootstrap;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->initRoutes();
        $this->startSession();
    }

    public function startSession() : void
    {
        $status = session_status();
        if ($status != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }

    public function initRoutes(): void
    {
        include "../app/routes/web.php";
        $this->routes = $webRoutes;
    }

    public function route(string $requestUri)
    {
        return $this->doAction($requestUri);
    }

    private function doAction(string $url)
    {
        [$action, $params] = $this->findRoute($url);

        [$controller, $actionName] = $this->parseActionForUrl($action);

        return $this->exec($controller, $actionName, $params);
    }

    private function findRoute(string $requestUri): array
    {
        $requestUri = explode("?", $requestUri)[0];
        $requestUri = ltrim($requestUri, '/');
        $requestUri = rtrim($requestUri, '/'); // nginx don't cut last '/'

        foreach ($this->routes as $routePath => $action) {
            $pattern = '/^' . str_replace('/', '\/', $routePath) . '$/';
            if (preg_match($pattern, $requestUri, $params)) {
                array_shift($params);
                return [$action, $params];
            }
        }
        var_dump($requestUri);

        header("location: /error");
        exit();
//        throw new \Exception('Path not found');
    }

    private function parseActionForUrl(string $action): array
    {
        $explodeAction = explode('@', $action);
        $controllerName = $explodeAction[0];

        $actionName = $explodeAction[1];
        include APP_ROOT_DIRECTORY . $controllerName . '.php';

        $controller = str_replace('/', '\\', $controllerName);

        return [$controller, $actionName];
    }

    private function exec(mixed $controller, mixed $actionName, ?array $params)
    {
        $controllerObject = new $controller();
        return is_array($params)
            ? $controllerObject->$actionName($params)
            : $controllerObject->$actionName();
    }
}
