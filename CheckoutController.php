<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/CartModel.php';
require_once BASE_PATH . '/src/Models/OrderModel.php';

class CheckoutController extends BaseController {

    private CartModel $cartModel;
    private OrderModel $orderModel;

    public function __construct() {
        $this->cartModel  = new CartModel();
        $this->orderModel = new OrderModel();
    }

    // GET /checkout
    public function index(): void {
        $this->requireLogin();

        $cartId = $this->cartModel->getOrCreateCart($_SESSION['user_id']);
        $items  = $this->cartModel->getItems($cartId);

        if (empty($items)) {
            $this->redirect('cart');
            return;
        }

        $total = array_sum(array_map(fn($i) => $i['unit_price'] * $i['quantity'], $items));

        $this->render('checkout/index', [
            'pageTitle' => 'Thanh toán - NanoTech',
            'items'     => $items,
            'total'     => $total,
        ]);
    }

    // POST /checkout/place
    public function place(): void {
        $this->requireLogin();
        header('Content-Type: application/json');

        $data      = json_decode(file_get_contents('php://input'), true);
        $name      = trim($data['name'] ?? '');
        $phone     = trim($data['phone'] ?? '');
        $address   = trim($data['address'] ?? '');

        if (!$name || !$phone || !$address) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin giao hàng.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $cartId = $this->cartModel->getOrCreateCart($userId);
        $items  = $this->cartModel->getItems($cartId);

        if (empty($items)) {
            echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống.']);
            return;
        }

        $total = array_sum(array_map(fn($i) => $i['unit_price'] * $i['quantity'], $items));

        // Tạo address record
        $addressId = $this->orderModel->createAddress($userId, $name, $phone, $address);

        // Tạo order
        $orderId = $this->orderModel->createOrder($userId, $addressId, $total);

        // Tạo order items
        foreach ($items as $item) {
            $this->orderModel->createOrderItem($orderId, $item['product_id'], $item['quantity'], $item['unit_price']);
        }

        // Tạo payment record (COD)
        $this->orderModel->createPayment($orderId, $total);

        // Xóa giỏ hàng
        $this->cartModel->clearCart($cartId);
        $_SESSION['cart_count'] = 0;

        echo json_encode(['success' => true, 'order_id' => $orderId]);
    }
}