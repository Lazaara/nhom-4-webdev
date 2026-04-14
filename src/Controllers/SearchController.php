<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';

class SearchController extends BaseController {

    private ProductModel $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // GET /search?q=keyword
    public function index(): void {
        $keyword = trim($_GET['q'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $limit   = 12;
        $offset  = ($page - 1) * $limit;

        $products   = [];
        $total      = 0;
        $totalPages = 0;

        if ($keyword) {
            $products   = $this->productModel->search($keyword, $limit, $offset);
            $total      = $this->productModel->countSearch($keyword);
            $totalPages = ceil($total / $limit);
        }

        $this->render('search/index', [
            'pageTitle'   => 'Tìm kiếm: ' . $keyword . ' - NanoTech',
            'products'    => $products,
            'keyword'     => $keyword,
            'total'       => $total,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
        ]);
    }

    // GET /search/suggest?q=keyword (AJAX - gợi ý tìm kiếm)
    public function suggest(): void {
        header('Content-Type: application/json');
        $keyword  = trim($_GET['q'] ?? '');

        if (strlen($keyword) < 2) {
            echo json_encode([]);
            return;
        }

        $results = $this->productModel->search($keyword, 5, 0);
        $suggestions = array_map(fn($p) => [
            'id'    => $p['id'],
            'name'  => $p['name'],
            'price' => number_format($p['price'], 0, ',', '.') . 'đ',
            'image' => $p['image'] ?? '',
        ], $results);

        echo json_encode($suggestions);
    }
}