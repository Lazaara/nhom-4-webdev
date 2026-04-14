<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/configs/database.php';
require_once BASE_PATH . '/src/Core/Router.php';

// Cập nhật cart count
if (isset($_SESSION['user_id'])) {
    require_once BASE_PATH . '/src/Models/CartModel.php';
    $cartModel = new CartModel();
    $_SESSION['cart_count'] = $cartModel->countItems($_SESSION['user_id']);
}

$router = new Router();
$router->dispatch();