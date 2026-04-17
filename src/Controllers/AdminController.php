<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';
require_once BASE_PATH . '/src/Models/CategoryModel.php';
require_once BASE_PATH . '/src/Models/OrderModel.php';
require_once BASE_PATH . '/src/Models/UserModel.php';

class AdminController extends BaseController {

    private ProductModel $productModel;
    private CategoryModel $categoryModel;
    private OrderModel $orderModel;
    private UserModel $userModel;

    public function __construct() {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel    = new OrderModel();
        $this->userModel     = new UserModel();
    }

    // GET /admin
    public function index(): void {
        $this->requireAdmin();
        $totalProducts = $this->productModel->countAll();
        $totalOrders   = count($this->orderModel->getAllOrders());
        $recentOrders  = array_slice($this->orderModel->getAllOrders(), 0, 5);

        $this->renderAdmin('admin/dashboard', [
            'pageTitle'     => 'Admin Panel - NanoTech',
            'totalProducts' => $totalProducts,
            'totalOrders'   => $totalOrders,
            'recentOrders'  => $recentOrders,
        ]);
    }

    // GET /admin/products
    public function products(): void {
        $this->requireAdmin();
        $products = $this->productModel->getAll(100, 0);
        $this->renderAdmin('admin/products', [
            'pageTitle' => 'Quản lý sản phẩm - Admin',
            'products'  => $products,
        ]);
    }

    // GET /admin/product-add
    public function productAdd(): void {
        $this->requireAdmin();
        $categories = $this->categoryModel->getAll();
        $this->renderAdmin('admin/product_form', [
            'pageTitle'  => 'Thêm sản phẩm - Admin',
            'categories' => $categories,
            'product'    => null,
        ]);
    }

    // POST /admin/product-store
    public function productStore(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data        = json_decode(file_get_contents('php://input'), true);
        $name        = trim($data['name'] ?? '');
        $sku         = trim($data['sku'] ?? '');
        $price       = (float)($data['price'] ?? 0);
        $stock       = (int)($data['stock'] ?? 0);
        $categoryId  = (int)($data['category_id'] ?? 0);
        $image       = trim($data['image'] ?? '');

        if (!$name || !$sku || !$price || !$categoryId) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
            return;
        }

        $productId = $this->productModel->create($name, $sku, $price, $stock, $categoryId);

        if ($image) {
            $this->productModel->addImage($productId, $image);
        }

        echo json_encode(['success' => true]);
    }

    // GET /admin/product-edit/id
    public function productEdit(?string $id): void {
        $this->requireAdmin();
        $product    = $this->productModel->getById((int)$id);
        $categories = $this->categoryModel->getAll();
        $this->renderAdmin('admin/product_form', [
            'pageTitle'  => 'Sửa sản phẩm - Admin',
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    // POST /admin/product-update
    public function productUpdate(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data       = json_decode(file_get_contents('php://input'), true);
        $id         = (int)($data['id'] ?? 0);
        $name       = trim($data['name'] ?? '');
        $sku        = trim($data['sku'] ?? '');
        $price      = (float)($data['price'] ?? 0);
        $stock      = (int)($data['stock'] ?? 0);
        $categoryId = (int)($data['category_id'] ?? 0);
        $image      = trim($data['image'] ?? '');

        if (!$id || !$name || !$sku || !$price || !$categoryId) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
            return;
        }

        $this->productModel->update($id, $name, $sku, $price, $stock, $categoryId);

        if ($image) {
            $this->productModel->updateImage($id, $image);
        }

        echo json_encode(['success' => true]);
    }

    // POST /admin/product-delete
    public function productDelete(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false]);
            return;
        }

        $this->productModel->delete($id);
        echo json_encode(['success' => true]);
    }

    // GET /admin/categories
    public function categories(): void {
        $this->requireAdmin();
        $categories = $this->categoryModel->getAll();
        $this->renderAdmin('admin/categories', [
            'pageTitle'  => 'Quản lý danh mục - Admin',
            'categories' => $categories,
        ]);
    }

    // POST /admin/category-store
    public function categoryStore(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $name = trim($data['name'] ?? '');

        if (!$name) {
            echo json_encode(['success' => false, 'message' => 'Tên danh mục không được trống.']);
            return;
        }

        $slug = strtolower(preg_replace('/\s+/', '-', $name));
        $this->categoryModel->create($name, $slug);
        echo json_encode(['success' => true]);
    }

    // POST /admin/category-delete
    public function categoryDelete(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        $this->categoryModel->delete($id);
        echo json_encode(['success' => true]);
    }

    // GET /admin/orders
    public function orders(): void {
        $this->requireAdmin();
        $orders = $this->orderModel->getAllOrders();
        $this->renderAdmin('admin/orders', [
            'pageTitle' => 'Quản lý đơn hàng - Admin',
            'orders'    => $orders,
        ]);
    }

    // POST /admin/order-status
    public function orderStatus(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data   = json_decode(file_get_contents('php://input'), true);
        $id     = (int)($data['id'] ?? 0);
        $status = trim($data['status'] ?? '');

        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!$id || !in_array($status, $allowed)) {
            echo json_encode(['success' => false]);
            return;
        }

        $this->orderModel->updateStatus($id, $status);
        echo json_encode(['success' => true]);
    }
}