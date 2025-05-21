<?php
$controller = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'HomeController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

$controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerObj = new $controller();

    if (method_exists($controllerObj, $action)) {
        if ($id !== null) {
            $controllerObj->$action($id);
        } else {
            $controllerObj->$action();
        }
    } else {
        echo "Không tìm thấy action: $action";
    }
} else {
    echo "Không tìm thấy controller: $controller";
}