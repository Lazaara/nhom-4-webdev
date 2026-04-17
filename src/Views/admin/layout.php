<?php $adminUrl = $_GET['url'] ?? ''; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin - NanoTech' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .admin-sidebar { min-height: 100vh; background: #343a40; }
        .admin-sidebar .nav-link { color: #adb5bd; }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-radius: 4px; }
        .admin-sidebar .nav-link i { width: 20px; }
    </style>
</head>
<body class="bg-light">
<div class="d-flex">
    <!-- Sidebar -->
    <div class="admin-sidebar p-3" style="width:240px;min-width:240px;">
        <a href="/webdev/public/admin" class="text-white text-decoration-none">
            <h5 class="font-weight-bold mb-4">⚙️ NanoTech Admin</h5>
        </a>
        <nav class="nav flex-column">
            <a href="/webdev/public/admin"
               class="nav-link <?= $adminUrl === 'admin' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="/webdev/public/admin/products"
               class="nav-link <?= strpos($adminUrl, 'admin/product') !== false ? 'active' : '' ?>">
                <i class="fas fa-box mr-2"></i> Sản phẩm
            </a>
            <a href="/webdev/public/admin/categories"
               class="nav-link <?= strpos($adminUrl, 'admin/categor') !== false ? 'active' : '' ?>">
                <i class="fas fa-tags mr-2"></i> Danh mục
            </a>
            <a href="/webdev/public/admin/orders"
               class="nav-link <?= strpos($adminUrl, 'admin/order') !== false ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag mr-2"></i> Đơn hàng
            </a>
            <hr class="border-secondary">
            <a href="/webdev/public/" class="nav-link">
                <i class="fas fa-home mr-2"></i> Về trang chủ
            </a>
            <a href="/webdev/public/auth/logout" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
            </a>
        </nav>
    </div>

    <!-- Main content -->
    <div class="flex-fill p-4">