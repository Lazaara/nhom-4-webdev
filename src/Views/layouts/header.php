<?php
$currentUrl = $_GET['url'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NanoTech' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/webdev/public/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid px-4">

        <!-- Logo + Nav links bên trái -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand font-weight-bold text-danger mr-4" href="/webdev/public/">
                NanoTech
            </a>
            <ul class="navbar-nav flex-row d-none d-lg-flex">
                <li class="nav-item mr-3">
                    <a class="nav-link <?= $currentUrl === '' ? 'active font-weight-bold' : '' ?>"
                       href="/webdev/public/">Home</a>
                </li>
                <li class="nav-item mr-3" id="megaMenuWrapper" style="position:static;">
                    <a class="nav-link" href="/webdev/public/product" id="megaMenuToggle">Sản phẩm</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentUrl === 'page/faq' ? 'active font-weight-bold' : '' ?>"
                       href="/webdev/public/page/faq">FAQ</a>
                </li>
            </ul>
        </div>

        <!-- Search bar giữa -->
        <div class="flex-grow-1 mx-4 d-none d-lg-block">
            <form action="/webdev/public/search" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control"
                        placeholder="Tìm kiếm sản phẩm công nghệ..."
                        style="border-radius: 20px 0 0 20px; border-color: #ced4da; border-right: none;">
                    <div class="input-group-append">
                        <button class="btn" type="submit"
                                style="border-radius: 0 20px 20px 0; border: 1px solid #ced4da; border-left: none; background: white;">
                            <i class="fas fa-search text-muted"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right icons -->
        <ul class="navbar-nav align-items-center flex-row">
            <li class="nav-item mr-3">
                <a class="nav-link position-relative" href="/webdev/public/cart">
                    <i class="fas fa-shopping-basket fa-lg"></i>
                    <?php $cartCount = $_SESSION['cart_count'] ?? 0; ?>
                    <?php if ($cartCount > 0): ?>
                        <span class="badge badge-danger position-absolute"
                              style="top:0;right:-4px;font-size:9px;min-width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg mr-1"></i>
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/webdev/public/account">
                                <i class="fas fa-user mr-2"></i>Tài khoản
                            </a>
                            <a class="dropdown-item" href="/webdev/public/account/orders">
                                <i class="fas fa-box mr-2"></i>Đơn hàng
                            </a>
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="/webdev/public/admin">
                                    <i class="fas fa-cog mr-2"></i>Admin Panel
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="/webdev/public/auth/logout">
                                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">
                        <i class="fas fa-user-circle fa-lg mr-1"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </li>
        </ul>

        <!-- Mobile toggler -->
        <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbarMobile">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <!-- Mobile menu -->
    <div class="collapse px-4" id="navbarMobile">
        <form action="/webdev/public/search" method="GET" class="my-2">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                <div class="input-group-append">
                    <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/webdev/public/">Home</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Sản phẩm</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/webdev/public/product/category/dien-thoai">Điện thoại</a>
                    <a class="dropdown-item" href="/webdev/public/product/category/laptop">Laptop</a>
                    <a class="dropdown-item" href="/webdev/public/product/category/tablet">Tablet</a>
                    <a class="dropdown-item" href="/webdev/public/product/category/tai-nghe">Tai nghe</a>
                    <a class="dropdown-item" href="/webdev/public/product/category/phu-kien">Phụ kiện</a>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link" href="/webdev/public/page/faq">FAQ</a></li>
        </ul>
    </div>
</nav>

<div id="megaMenu" style="
    display:none;
    position:fixed;
    left:0; right:0;
    top:57px;
    background:white;
    border-top:2px solid #dc3545;
    box-shadow:0 8px 24px rgba(0,0,0,0.1);
    z-index:9999;
    padding:20px 40px;
">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 border-right pr-3">
                <?php
                if (!isset($categories)) {
                    require_once BASE_PATH . '/src/Models/CategoryModel.php';
                    $catModel = new CategoryModel();
                    $megaCategories = $catModel->getAll();
                } else {
                    $megaCategories = $categories;
                }
                $catIcons = [
                    'dien-thoai' => 'fa-mobile-alt',
                    'laptop'     => 'fa-laptop',
                    'tablet'     => 'fa-tablet-alt',
                    'tai-nghe'   => 'fa-headphones',
                    'dong-ho'    => 'fa-clock',
                    'phu-kien'   => 'fa-plug',
                ];
                foreach ($megaCategories as $cat):
                ?>
                <a href="/webdev/public/product/category/<?= $cat['slug'] ?>"
                   class="d-flex align-items-center py-2 px-2 text-dark text-decoration-none mega-cat-item"
                   data-id="<?= $cat['id'] ?>"
                   style="border-radius:4px;">
                    <i class="fas <?= $icon ?> text-danger mr-2" style="width:20px;"></i>
                    <span class="small"><?= htmlspecialchars($cat['name']) ?></span>
                    <i class="fas fa-chevron-right ml-auto small text-muted"></i>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="col-md-10 pl-4" id="megaMenuProducts">
                <p class="text-muted small mt-2">Hover vào danh mục để xem sản phẩm</p>
            </div>
        </div>
    </div>
</div>


<!-- Main content bắt đầu -->
<main>