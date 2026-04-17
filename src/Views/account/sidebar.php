<?php $currentUrl = $_GET['url'] ?? ''; ?>
<div class="card border-0 shadow-sm">
    <div class="card-body text-center pb-2">
        <i class="fas fa-user-circle fa-4x text-secondary mb-2"></i>
        <p class="font-weight-bold mb-0"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
    </div>
    <div class="list-group list-group-flush">
        <a href="/webdev/public/account"
           class="list-group-item list-group-item-action <?= $currentUrl === 'account' ? 'active' : '' ?>">
            <i class="fas fa-user mr-2"></i> Thông tin cá nhân
        </a>
        <a href="/webdev/public/account/orders"
           class="list-group-item list-group-item-action <?= strpos($currentUrl, 'account/orders') !== false ? 'active' : '' ?>">
            <i class="fas fa-box mr-2"></i> Đơn hàng
        </a>
        <a href="/webdev/public/auth/logout"
           class="list-group-item list-group-item-action text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
        </a>
    </div>
</div>