<!-- BANNER -->
<div class="container mb-4 mt-3">
    <div id="bannerCarousel" class="carousel slide shadow-sm rounded" data-ride="carousel" data-interval="3000" style="overflow: hidden;">
        <ol class="carousel-indicators">
            <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#bannerCarousel" data-slide-to="1"></li>
            <li data-target="#bannerCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/webdev/public/img/Banner_1.png" class="d-block w-100" alt="Flash Sale" style="height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="/webdev/public/img/Banner_2.png" class="d-block w-100" alt="ROG Gaming" style="height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="/webdev/public/img/Banner_3.png" class="d-block w-100" alt="Laptop Gaming AMD" style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- DANH MỤC -->
<div class="container mb-5">
    <div class="row text-center">
        <?php
        $catIcons = [
            'Điện-thoại' => 'fa-mobile-alt',
            'laptop'     => 'fa-laptop',
            'máy-tính-bảng'     => 'fa-tablet-alt',
            'Đồng-hồ-thông-minh'    => 'fa-clock',
            'phụ-kiện'   => 'fa-plug',
        ];
        foreach ($categories as $cat):
            $icon = $catIcons[$cat['slug']] ?? 'fa-box';
        ?>
        <div class="col">
            <a href="/webdev/public/product/category/<?= $cat['slug'] ?>" class="text-decoration-none text-dark">
                <div class="p-3">
                    <i class="fas <?= $icon ?> fa-2x text-danger mb-2"></i>
                    <p class="small mb-0"><?= htmlspecialchars($cat['name']) ?></p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- SẢN PHẨM MỚI -->
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold mb-0">Sản phẩm mới</h5>
        <a href="/webdev/public/product" class="text-danger small">Xem tất cả →</a>
    </div>
    <div class="row">
        <?php foreach ($newProducts as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <a href="/webdev/public/product/detail/<?= $p['id'] ?>">
                    <img src="<?= htmlspecialchars($p['image'] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                         class="card-img-top p-3" alt="<?= htmlspecialchars($p['name']) ?>"
                         style="height:200px;object-fit:contain;">
                </a>
                <div class="card-body">
                    <p class="small text-muted mb-1"><?= htmlspecialchars($p['category_name']) ?></p>
                    <h6 class="card-title">
                        <a href="/webdev/public/product/detail/<?= $p['id'] ?>" class="text-dark text-decoration-none">
                            <?= htmlspecialchars($p['name']) ?>
                        </a>
                    </h6>
                    <p class="text-danger font-weight-bold mb-2">
                        <?= number_format($p['price'], 0, ',', '.') ?>đ
                    </p>
                    <button class="btn btn-outline-danger btn-sm btn-block add-to-cart"
                            data-id="<?= $p['id'] ?>">
                        <i class="fas fa-shopping-cart mr-1"></i> Thêm vào giỏ
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- BÁN CHẠY NHẤT -->
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold mb-0">Bán chạy nhất</h5>
        <a href="/webdev/public/product" class="text-danger small">Xem tất cả →</a>
    </div>
    <div class="row">
        <?php foreach ($bestSellers as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <a href="/webdev/public/product/detail/<?= $p['id'] ?>">
                    <img src="<?= htmlspecialchars($p['image'] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                         class="card-img-top p-3" alt="<?= htmlspecialchars($p['name']) ?>"
                         style="height:200px;object-fit:contain;">
                </a>
                <div class="card-body">
                    <p class="small text-muted mb-1"><?= htmlspecialchars($p['category_name']) ?></p>
                    <h6 class="card-title">
                        <a href="/webdev/public/product/detail/<?= $p['id'] ?>" class="text-dark text-decoration-none">
                            <?= htmlspecialchars($p['name']) ?>
                        </a>
                    </h6>
                    <p class="text-danger font-weight-bold mb-2">
                        <?= number_format($p['price'], 0, ',', '.') ?>đ
                    </p>
                    <button class="btn btn-outline-danger btn-sm btn-block add-to-cart"
                            data-id="<?= $p['id'] ?>">
                        <i class="fas fa-shopping-cart mr-1"></i> Thêm vào giỏ
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- THƯƠNG HIỆU NỔI BẬT -->
<div class="container mb-5">
    <h5 class="font-weight-bold mb-3">Thương hiệu nổi bật</h5>
    <div class="row text-center align-items-center">
        <?php
        $brands = [
            'Apple'   => 'fab fa-apple',
            'Samsung' => 'fas fa-mobile-alt',
            'Sony'    => 'fas fa-headphones',
            'Dell'    => 'fas fa-laptop',
            'Asus'    => 'fas fa-desktop',
            'Xiaomi'  => 'fas fa-mobile',
        ];
        foreach ($brands as $brand => $icon): ?>
        <div class="col-md-2 col-4 mb-3">
            <a href="/webdev/public/search?q=<?= urlencode($brand) ?>"
               class="text-decoration-none text-dark">
                <div class="border rounded p-3">
                    <i class="<?= $icon ?> fa-2x text-danger mb-2 d-block"></i>
                    <span class="font-weight-bold small"><?= $brand ?></span>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>