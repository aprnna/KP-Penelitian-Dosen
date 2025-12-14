<?php

class Router
{
  private $routes = [];
  private $notFoundCallback;

  public function get($uri, $callback)
  {
    $this->addRoute('GET', $uri, $callback);
  }

  public function post($uri, $callback)
  {
    $this->addRoute('POST', $uri, $callback);
  }

  public function put($uri, $callback)
  {
    $this->addRoute('PUT', $uri, $callback);
  }

  public function delete($uri, $callback)
  {
    $this->addRoute('DELETE', $uri, $callback);
  }

  private function addRoute($method, $uri, $callback)
  {
    $uri = trim($uri, '/');
    $this->routes[$method][$uri] = $callback;
  }

  public function notFound($callback)
  {
    $this->notFoundCallback = $callback;
  }

  public function dispatch($uri, $method = 'GET')
  {
    $uri = trim($uri, '/');

    // Check exact match first
    if (isset($this->routes[$method][$uri])) {
      return $this->executeCallback($this->routes[$method][$uri], []);
    }

    // Check for dynamic routes with parameters
    foreach ($this->routes[$method] as $route => $callback) {
      $pattern = $this->convertRouteToRegex($route);

      if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches); // Remove full match
        return $this->executeCallback($callback, $matches);
      }
    }

    // Route not found
    if ($this->notFoundCallback) {
      return $this->executeCallback($this->notFoundCallback, []);
    }

    http_response_code(404);
    echo "404 - Page Not Found";
  }

  private function convertRouteToRegex($route)
  {
    // Convert {id} to regex pattern
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route);
    return '#^' . $pattern . '$#';
  }

  private function executeCallback($callback, $params = [])
  {
    if (is_callable($callback)) {
      return call_user_func_array($callback, $params);
    }

    if (is_string($callback)) {
      $parts = explode('@', $callback);
      if (count($parts) === 2) {
        list($controller, $method) = $parts;

        $controllerFile = '../app/controllers/' . $controller . '.php';
        if (file_exists($controllerFile)) {
          require_once $controllerFile;
          $controllerInstance = new $controller();

          if (method_exists($controllerInstance, $method)) {
            return call_user_func_array([$controllerInstance, $method], $params);
          }
        }
      }
    }

    throw new Exception("Invalid route callback");
  }

  public function getCurrentUri()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = parse_url($uri, PHP_URL_PATH);

    // Remove base path if exists
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    if (strpos($uri, $basePath) === 0) {
      $uri = substr($uri, strlen($basePath));
    }

    return $uri;
  }

  public function getCurrentMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }
}
