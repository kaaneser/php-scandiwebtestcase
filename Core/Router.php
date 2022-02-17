<?php

namespace Core;

class Router {

    public static function parse_url()
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $basename = basename($_SERVER['SCRIPT_NAME']);
        $request_uri = str_replace([$dirname, $basename], "/", $_SERVER['REQUEST_URI']);
        return $request_uri;
    }

    public static function run($url, $callback, $method = 'get') {
        
        $request_uri = self::parse_url();
        if (preg_match('@^' . $url . '$@', $request_uri, $parameters)) {
            if (is_callable($callback)) {
                call_user_func_array($callback, $parameters);
            }

            $controller = explode('@', $callback);
            $controllerFile = dirname(__DIR__) . '/App/Controller/' . $controller[0] . '.php';

            if (file_exists($controllerFile)){
                require $controllerFile;
                $className = "\App\Controller\\" . $controller[0];

                call_user_func_array([new $className, $controller[1]], $parameters);
            }
        }
    }

}