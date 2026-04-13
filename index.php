<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/webdev/public/">Home</a></li>
            <li class="breadcrumb-item <?= $currentCat ? '' : 'active' ?>">
                <a href="/webdev/public/product">Sản phẩm</a>
            </li>
            <?php if ($currentCat): ?>
            <li class="breadcrumb-item active"><?= htmlspecialchars($currentCat['name']) ?></li>
            <?php endif; ?>
        </ol>
    </nav>

    <!-- Category tabs -->
    <div class="mb-4 d-flex flex-wrap">
        <a href="/webdev/public/product"
           class="btn btn-sm <?= !$currentCat ? 'btn-danger' : 'btn-outline-danger' ?> mr-1 mb-1">
            Tất cả
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="/webdev/public/product/category/<?= $cat['slug'] ?>"
           class="btn btn-sm <?= ($currentCat && $currentCat['id'] == $cat['id']) ? 'btn-danger' : 'btn-outline-danger' ?> mr-1 mb-1">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <!-- Filter sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-filter text-danger mr-1"></i> Bộ lọc
                    </h6>

                    <?php
                    $baseUrl = $currentCat
                        ? '/webdev/public/product/category/' . $currentCat['slug']
                        : '/webdev/public/product';
                    ?>

                    <form action="<?= $baseUrl ?>" method="GET" id="filterForm">

                        <!-- Brand filter -->
                        <div class="mb-3">
                            <label class="small font-weight-bold text-muted">Thương hiệu</label>
                            <?php
                            $brands = ['Apple', 'Samsung', 'Sony', 'Dell', 'Asus', 'Xiaomi', 'Lenovo', 'LG'];
                            foreach ($brands as $b):
                            ?>
                            <div class="custom-control custom-checkbox">
                                <input type="radio" name="brand" value="<?= $b ?>"
                                       id="brand_<?= $b ?>"
                                       class="custom-control-input filter-input"
                                       <?= ($brand === $b) ? 'checked' : '' ?>>
                                <label class="custom-control-label small" for="brand_<?= $b ?>">
                                    <?= $b ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                            <?php if ($brand): ?>
                            <a href="<?= $baseUrl ?>" class="small text-danger">Xóa filter</a>
                            <?php endif; ?>
                        </div>

                        <!-- Price filter -->
                        <div class="mb-3">
                            <label class="small font-weight-bold text-muted">Khoảng giá</label>
                            <?php
                            $priceRanges = [
                                ['label' => 'Dưới 5 triệu',       'min' => 0,         'max' => 5000000],
                                ['label' => '5 - 10 triệu',       'min' => 5000000,   'max' => 10000000],
                                ['label' => '10 - 20 triệu',      'min' => 10000000,  'max' => 20000000],
                                ['label' => '20 - 40 triệu',      'min' => 20000000,  'max' => 40000000],
                                ['label' => 'Trên 40 triệu',      'min' => 40000000,  'max' => 0],
                            ];
                            foreach ($priceRanges as $range):
                                $checked = ($minPrice == $range['min'] && $maxPrice == $range['max']);
                            ?>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="price_range" value="<?= $range['min'] ?>_<?= $range['max'] ?>"
                                       id="price_<?= $range['min'] ?>"
                                       class="custom-control-input filter-input"
                                       <?= $checked ? 'checked' : '' ?>>
                                <label class="custom-control-label small" for="price_<?= $range['min'] ?>">
                                    <?= $range['label'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                            <input type="hidden" name="min_price" id="minPriceInput" value="<?= $minPrice ?>">
                            <input type="hidden" name="max_price" id="maxPriceInput" value="<?= $maxPrice ?>">
                        </div>

                        <button type="submit" class="btn btn-danger btn-sm btn-block">
                            Áp dụng
                        </button>
                        <?php if ($minPrice || $maxPrice || $brand): ?>
                        <a href="<?= $baseUrl ?>" class="btn btn-outline-secondary btn-sm btn-block mt-1">
                            Xóa tất cả
                        </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product grid -->
        <div class="col-md-9">
            <?php if (empty($products)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Không có sản phẩm nào.</p>
                </div>
            <?php else: ?>
            <div class="row">
                <?php foreach ($products as $p): ?>
                <div class="col-md-4 col-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="/webdev/public/product/detail/<?= $p['id'] ?>">
                            <img src="<?= htmlspecialchars($p['image'] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                                 class="card-img-top p-3"
                                 style="height:200px;object-fit:contain;"
                                 alt="<?= htmlspecialchars($p['name']) ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <p class="small text-muted mb-1"><?= htmlspecialchars($p['category_name']) ?></p>
                            <h6 class="card-title flex-grow-1">
                                <a href="/webdev/public/product/detail/<?= $p['id'] ?>"
                                   class="text-dark text-decoration-none">
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

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link"
                           href="?page=<?= $i ?><?= $brand ? '&brand=' . urlencode($brand) : '' ?><?= $minPrice ? '&min_price=' . $minPrice : '' ?><?= $maxPrice ? '&max_price=' . $maxPrice : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>