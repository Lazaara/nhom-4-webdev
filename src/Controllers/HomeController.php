<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';
require_once BASE_PATH . '/src/Models/CategoryModel.php';

class HomeController extends BaseController {

    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct() {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index(): void {
        $newProducts  = $this->productModel->getNewProducts(4);
        $bestSellers  = $this->productModel->getBestSellers(4);
        $categories   = $this->categoryModel->getAll();

        $this->render('home/index', [
            'pageTitle'   => 'NanoTech - Công nghệ chính hãng',
            'newProducts' => $newProducts,
            'bestSellers' => $bestSellers,
            'categories'  => $categories,
        ]);
    }
}