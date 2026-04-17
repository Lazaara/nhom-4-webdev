<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/OrderModel.php';
require_once BASE_PATH . '/src/Models/UserModel.php';

class AccountController extends BaseController {

    private OrderModel $orderModel;
    private UserModel $userModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->userModel  = new UserModel();
    }

    // GET /account
    public function index(): void {
        $this->requireLogin();
        $user = $this->userModel->findById($_SESSION['user_id']);
        $this->render('account/index', [
            'pageTitle' => 'Tài khoản - NanoTech',
            'user'      => $user,
        ]);
    }

    // GET /account/orders
    public function orders(): void {
        $this->requireLogin();
        $orders = $this->orderModel->getOrdersByUser($_SESSION['user_id']);
        $this->render('account/orders', [
            'pageTitle' => 'Đơn hàng - NanoTech',
            'orders'    => $orders,
        ]);
    }

    // GET /account/order-detail/id
    public function orderDetail(?string $id): void {
        $this->requireLogin();

        $order = $this->orderModel->getOrderById((int)$id, $_SESSION['user_id']);
        if (!$order) {
            $this->redirect('account/orders');
            return;
        }

        $items = $this->orderModel->getOrderItems((int)$id);

        $this->render('account/order_detail', [
            'pageTitle' => 'Chi tiết đơn hàng #' . $id . ' - NanoTech',
            'order'     => $order,
            'items'     => $items,
        ]);
    }
}