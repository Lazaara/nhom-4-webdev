<div class="container mt-4 mb-5">
    <!-- Search bar -->
    <div class="mb-4">
        <form action="/webdev/public/search" method="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control form-control-lg"
                       value="<?= htmlspecialchars($keyword) ?>"
                       placeholder="Tìm kiếm sản phẩm...">
                <div class="input-group-append">
                    <button class="btn btn-danger btn-lg" type="submit">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($keyword): ?>
        <p class="text-muted mb-3">
            Tìm thấy <strong><?= $total ?></strong> kết quả cho 
            "<strong><?= htmlspecialchars($keyword) ?></strong>"
        </p>

        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                <a href="/webdev/public/product" class="btn btn-danger">Xem tất cả sản phẩm</a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $p): ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="/webdev/public/product/detail/<?= $p['id'] ?>">
                            <img src="<?= htmlspecialchars($p['image'] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                                 class="card-img-top p-3"
                                 style="height:200px;object-fit:contain;"
                                 alt="<?= htmlspecialchars($p['name']) ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
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
                           href="/webdev/public/search?q=<?= urlencode($keyword) ?>&page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>