<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';
require_once BASE_PATH . '/src/Models/CategoryModel.php';

class ProductController extends BaseController {

    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct() {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // /product → tất cả sản phẩm
    public function index(): void {
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $limit    = 12;
        $offset   = ($page - 1) * $limit;
        $minPrice = (float)($_GET['min_price'] ?? 0);
        $maxPrice = (float)($_GET['max_price'] ?? 0);
        $brand    = trim($_GET['brand'] ?? '');

        $products   = $this->productModel->getFiltered(0, $minPrice, $maxPrice, $brand, $limit, $offset);
        $total      = $this->productModel->countFiltered(0, $minPrice, $maxPrice, $brand);
        $totalPages = ceil($total / $limit);
        $categories = $this->categoryModel->getAll();

        $this->render('product/index', [
            'pageTitle'   => 'Tất cả sản phẩm - NanoTech',
            'products'    => $products,
            'categories'  => $categories,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'currentCat'  => null,
            'minPrice'    => $minPrice,
            'maxPrice'    => $maxPrice,
            'brand'       => $brand,
        ]);
    }

    // /product/category/slug
    public function category(?string $slug): void {
        if (!$slug) { $this->redirect('product'); return; }

        $category = $this->categoryModel->getBySlug($slug);
        if (!$category) { $this->redirect('product'); return; }

        $page     = max(1, (int)($_GET['page'] ?? 1));
        $limit    = 12;
        $offset   = ($page - 1) * $limit;
        $minPrice = (float)($_GET['min_price'] ?? 0);
        $maxPrice = (float)($_GET['max_price'] ?? 0);
        $brand    = trim($_GET['brand'] ?? '');

        $products   = $this->productModel->getFiltered($category['id'], $minPrice, $maxPrice, $brand, $limit, $offset);
        $total      = $this->productModel->countFiltered($category['id'], $minPrice, $maxPrice, $brand);
        $totalPages = ceil($total / $limit);
        $categories = $this->categoryModel->getAll();

        $this->render('product/index', [
            'pageTitle'   => $category['name'] . ' - NanoTech',
            'products'    => $products,
            'categories'  => $categories,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'currentCat'  => $category,
            'minPrice'    => $minPrice,
            'maxPrice'    => $maxPrice,
            'brand'       => $brand,
        ]);
    }

    // /product/detail/id
    public function detail(?string $id): void {
        if (!$id) {
            $this->redirect('product');
            return;
        }

        $product = $this->productModel->getById((int)$id);
        if (!$product) {
            $this->redirect('product');
            return;
        }

        $images  = $this->productModel->getImages((int)$id);
        $related = $this->productModel->getByCategory($product['category_id'], 4);
        $related = array_filter($related, fn($p) => $p['id'] != $id);

        $this->render('product/detail', [
            'pageTitle' => $product['name'] . ' - NanoTech',
            'product'   => $product,
            'images'    => $images,
            'related'   => array_values($related),
        ]);
    }

    // GET /product/by-category-ajax?id=1
    public function byCategoryAjax(): void {
        header('Content-Type: application/json');
        $categoryId = (int)($_GET['id'] ?? 0);
        if (!$categoryId) {
            echo json_encode([]);
            return;
        }
        $products = $this->productModel->getByCategory($categoryId, 4, 0);
        echo json_encode($products);
    }
}