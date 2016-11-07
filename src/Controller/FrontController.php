<?php

namespace Controller;

use Database\Connector;

/**
 * Class FrontController
 */
class FrontController
{
    const CONTROLLER_NAMESPACE = 'Controller';

    private $databaseConfig;

    public function __construct(array $databaseConfig)
    {
        $this->databaseConfig = $databaseConfig;

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../View/');
        $this->twig = new \Twig_Environment($loader, ['debug' => true]);
    }

    public function handle()
    {
        list ($controllerName, $actionName) = $this->getControllerAndAction();

        if ($controllerName === IndexController::class) {
            $controller = new $controllerName($this->twig);
        } else {
            $databaseConnector = $this->getDatabaseConnector();

            $controller = new $controllerName($this->twig, $databaseConnector);
        }

        return $controller->$actionName();
    }

    private function getControllerAndAction(): array
    {
        $controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $actionName     = isset($_GET['action']) ? $_GET['action'] : 'index';

        $controllerName = ucfirst($controllerName) . 'Controller';
        $controllerName = self::CONTROLLER_NAMESPACE . '\\' . $controllerName;

        $actionName = $actionName . 'Action';

        if (!class_exists($controllerName)) {
            throw new \Exception('No controller');
        }

        if (!method_exists($controllerName, $actionName)) {
            throw new \Exception('No action');
        }

        return [$controllerName, $actionName];
    }

    private function getDatabaseConnector(): Connector
    {
        $host     = $this->databaseConfig['host'];
        $database = $this->databaseConfig['database'];
        $user     = $this->databaseConfig['user'];
        $password = $this->databaseConfig['password'];

        return new Connector($database, $user, $password, $host);
    }

    public static function redirect(string $redirectUrl = '/')
    {
        header("Location: {$redirectUrl}");
        die();
    }
}
