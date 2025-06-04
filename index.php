<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require các file cần thiết
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/ProductController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerClass = ucfirst($controller) . 'Controller';

if (!file_exists(__DIR__ . "/controllers/{$controllerClass}.php")) {
    die("Controller không tồn tại: {$controllerClass}");
}

// Khởi tạo controller
if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass();
} else {
    die("Lớp controller không tồn tại: {$controllerClass}");
}

// Kiểm tra action có tồn tại trong controller không
if (!method_exists($controllerInstance, $action)) {
    die("Action không tồn tại: {$action} trong {$controllerClass}");
}

// Gọi action
$controllerInstance->$action();