<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/CartModel.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';

class CartController extends BaseController {

    private CartModel $cartModel;
    private ProductModel $productModel;

    public function __construct() {
        $this->cartModel    = new CartModel();
        $this->productModel = new ProductModel();
    }

    // GET /cart
    public function index(): void {
        if (!$this->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        $cartId = $this->cartModel->getOrCreateCart($_SESSION['user_id']);
        $items  = $this->cartModel->getItems($cartId);
        $total  = array_sum(array_map(fn($i) => $i['unit_price'] * $i['quantity'], $items));

        $this->render('cart/index', [
            'pageTitle' => 'Giỏ hàng - NanoTech',
            'items'     => $items,
            'total'     => $total,
            'cartId'    => $cartId,
        ]);
    }

    // POST /cart/add (AJAX)
    public function add(): void {
        header('Content-Type: application/json');

        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
            return;
        }

        $data      = json_decode(file_get_contents('php://input'), true);
        $productId = (int)($data['product_id'] ?? 0);
        $qty       = (int)($data['quantity'] ?? 1);

        $product = $this->productModel->getById($productId);
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            return;
        }

        if ($product['stock'] < $qty) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không đủ tồn kho.']);
            return;
        }

        $cartId = $this->cartModel->getOrCreateCart($_SESSION['user_id']);
        $this->cartModel->addItem($cartId, $productId, $qty, $product['price']);

        $count = $this->cartModel->countItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $count;

        echo json_encode(['success' => true, 'cart_count' => $count]);
    }

    // POST /cart/update (AJAX)
    public function update(): void {
        header('Content-Type: application/json');

        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false]);
            return;
        }

        $data      = json_decode(file_get_contents('php://input'), true);
        $productId = (int)($data['product_id'] ?? 0);
        $qty       = (int)($data['quantity'] ?? 1);

        $cartId = $this->cartModel->getOrCreateCart($_SESSION['user_id']);

        if ($qty <= 0) {
            $this->cartModel->removeItem($cartId, $productId);
        } else {
            $this->cartModel->updateItem($cartId, $productId, $qty);
        }

        $items = $this->cartModel->getItems($cartId);
        $total = array_sum(array_map(fn($i) => $i['unit_price'] * $i['quantity'], $items));
        $count = $this->cartModel->countItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $count;

        echo json_encode([
            'success'    => true,
            'total'      => number_format($total, 0, ',', '.') . 'đ',
            'cart_count' => $count,
        ]);
    }

    // POST /cart/remove (AJAX)
    public function remove(): void {
        header('Content-Type: application/json');

        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false]);
            return;
        }

        $data      = json_decode(file_get_contents('php://input'), true);
        $productId = (int)($data['product_id'] ?? 0);

        $cartId = $this->cartModel->getOrCreateCart($_SESSION['user_id']);
        $this->cartModel->removeItem($cartId, $productId);

        $items = $this->cartModel->getItems($cartId);
        $total = array_sum(array_map(fn($i) => $i['unit_price'] * $i['quantity'], $items));
        $count = $this->cartModel->countItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $count;

        echo json_encode([
            'success'    => true,
            'total'      => number_format($total, 0, ',', '.') . 'đ',
            'cart_count' => $count,
        ]);
    }
}