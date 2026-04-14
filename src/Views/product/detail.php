<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/webdev/public/">Home</a></li>
            <li class="breadcrumb-item"><a href="/webdev/public/product">Sản phẩm</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-5 mb-4">
            <img id="mainImage"
                 src="<?= htmlspecialchars($images[0] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                 class="img-fluid border rounded p-3"
                 style="width:100%;height:350px;object-fit:contain;"
                 alt="<?= htmlspecialchars($product['name']) ?>">
            <?php if (count($images) > 1): ?>
            <div class="d-flex mt-2 flex-wrap">
                <?php foreach ($images as $img): ?>
                <img src="<?= htmlspecialchars($img) ?>"
                     class="img-thumbnail mr-2 mb-2 product-thumb"
                     style="width:70px;height:70px;object-fit:contain;cursor:pointer;"
                     onclick="document.getElementById('mainImage').src=this.src">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <p class="text-muted small mb-1"><?= htmlspecialchars($product['category_name']) ?></p>
            <h4 class="font-weight-bold"><?= htmlspecialchars($product['name']) ?></h4>

            <div class="mb-3">
                <span class="text-warning">★★★★★</span>
                <span class="small text-muted ml-1">Đã bán <?= rand(10, 200) ?></span>
            </div>

            <h3 class="text-danger font-weight-bold mb-3">
                <?= number_format($product['price'], 0, ',', '.') ?>đ
            </h3>

            <div class="mb-3">
                <span class="badge <?= $product['stock'] > 0 ? 'badge-success' : 'badge-danger' ?>">
                    <?= $product['stock'] > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                </span>
            </div>

            <!-- Số lượng -->
            <div class="d-flex align-items-center mb-3">
                <label class="mr-3 mb-0 font-weight-bold">Số lượng:</label>
                <div class="input-group" style="width:130px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" id="qtyMinus">-</button>
                    </div>
                    <input type="number" id="qty" class="form-control text-center" value="1" min="1" max="<?= $product['stock'] ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="qtyPlus">+</button>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <?php if ($product['stock'] > 0): ?>
            <div class="d-flex mb-3">
                <button class="btn btn-danger mr-2 px-4" id="buyNowBtn"
                        data-id="<?= $product['id'] ?>">
                    Mua ngay
                </button>
                <button class="btn btn-outline-danger px-4 add-to-cart"
                        data-id="<?= $product['id'] ?>">
                    <i class="fas fa-shopping-cart mr-1"></i> Thêm vào giỏ
                </button>
            </div>
            <?php endif; ?>

            <!-- Thông tin thêm -->
            <div class="border rounded p-3 small">
                <div class="row mb-1">
                    <div class="col-5 text-muted">SKU:</div>
                    <div class="col-7"><?= htmlspecialchars($product['sku']) ?></div>
                </div>
                <div class="row mb-1">
                    <div class="col-5 text-muted">Danh mục:</div>
                    <div class="col-7"><?= htmlspecialchars($product['category_name']) ?></div>
                </div>
                <div class="row">
                    <div class="col-5 text-muted">Tình trạng:</div>
                    <div class="col-7"><?= $product['stock'] > 0 ? 'Còn ' . $product['stock'] . ' sản phẩm' : 'Hết hàng' ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm tương tự -->
    <?php if (!empty($related)): ?>
    <div class="mt-5">
        <h5 class="font-weight-bold mb-3">Sản phẩm tương tự</h5>
        <div class="row">
            <?php foreach ($related as $p): ?>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <a href="/webdev/public/product/detail/<?= $p['id'] ?>">
                        <img src="<?= htmlspecialchars($p['image'] ?? 'https://placehold.co/400x400?text=No+Image') ?>"
                             class="card-img-top p-2"
                             style="height:150px;object-fit:contain;"
                             alt="<?= htmlspecialchars($p['name']) ?>">
                    </a>
                    <div class="card-body p-2">
                        <p class="small mb-1 text-truncate">
                            <a href="/webdev/public/product/detail/<?= $p['id'] ?>" class="text-dark text-decoration-none">
                                <?= htmlspecialchars($p['name']) ?>
                            </a>
                        </p>
                        <p class="text-danger small font-weight-bold mb-0">
                            <?= number_format($p['price'], 0, ',', '.') ?>đ
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Qty buttons
$('#qtyMinus').click(function() {
    let val = parseInt($('#qty').val());
    if (val > 1) $('#qty').val(val - 1);
});
$('#qtyPlus').click(function() {
    let val = parseInt($('#qty').val());
    let max = parseInt($('#qty').attr('max'));
    if (val < max) $('#qty').val(val + 1);
});

// Buy now
$('#buyNowBtn').click(function() {
    const id  = $(this).data('id');
    const qty = parseInt($('#qty').val());
    $.ajax({
        url: '/webdev/public/cart/add',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: id, quantity: qty }),
        success: function(res) {
            if (res.success) {
                window.location.href = '/webdev/public/cart';
            }
        }
    });
});
</script>