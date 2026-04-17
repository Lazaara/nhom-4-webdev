<div class="container mt-4 mb-5">
    <h4 class="font-weight-bold mb-4">Giỏ hàng của bạn</h4>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
            <p class="text-muted">Giỏ hàng trống!</p>
            <a href="/webdev/public/product" class="btn btn-danger">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
    <div class="row">
        <!-- Danh sách sản phẩm -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                            <?php foreach ($items as $item): ?>
                            <tr id="row-<?= $item['product_id'] ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/60x60') ?>"
                                             style="width:60px;height:60px;object-fit:contain;" class="mr-3">
                                        <div>
                                            <p class="mb-0 font-weight-bold small"><?= htmlspecialchars($item['name']) ?></p>
                                            <p class="mb-0 text-muted small">SKU: <?= $item['sku'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <?= number_format($item['unit_price'], 0, ',', '.') ?>đ
                                </td>
                                <td class="text-center align-middle">
                                    <div class="input-group input-group-sm justify-content-center" style="width:110px;margin:auto;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary qty-btn" data-action="minus"
                                                    data-id="<?= $item['product_id'] ?>">-</button>
                                        </div>
                                        <input type="number" class="form-control text-center qty-input"
                                               value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>"
                                               data-id="<?= $item['product_id'] ?>"
                                               data-price="<?= $item['unit_price'] ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary qty-btn" data-action="plus"
                                                    data-id="<?= $item['product_id'] ?>">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle font-weight-bold text-danger item-total-<?= $item['product_id'] ?>">
                                    <?= number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-sm btn-outline-danger remove-btn"
                                            data-id="<?= $item['product_id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="/webdev/public/product" class="btn btn-outline-secondary mt-3">
                <i class="fas fa-arrow-left mr-1"></i> Tiếp tục mua sắm
            </a>
        </div>

        <!-- Tổng tiền -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Tóm tắt đơn hàng</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span id="cartTotal"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-danger" id="cartTotalFinal"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <a href="/webdev/public/checkout" class="btn btn-danger btn-block mt-3">
                        Thanh toán ngay <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Qty buttons
$(document).on('click', '.qty-btn', function() {
    const action = $(this).data('action');
    const id     = $(this).data('id');
    const input  = $('.qty-input[data-id="' + id + '"]');
    let qty      = parseInt(input.val());
    const max    = parseInt(input.attr('max'));

    if (action === 'minus' && qty > 1) qty--;
    else if (action === 'plus' && qty < max) qty++;
    else return;

    input.val(qty);
    updateCart(id, qty, parseFloat(input.data('price')));
});

$(document).on('change', '.qty-input', function() {
    const id    = $(this).data('id');
    const qty   = parseInt($(this).val());
    const price = parseFloat($(this).data('price'));
    if (qty >= 1) updateCart(id, qty, price);
});

function updateCart(productId, qty, price) {
    $.ajax({
        url: '/webdev/public/cart/update',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: productId, quantity: qty }),
        success: function(res) {
            if (res.success) {
                const itemTotal = (price * qty).toLocaleString('vi-VN') + 'đ';
                $('.item-total-' + productId).text(itemTotal);
                $('#cartTotal, #cartTotalFinal').text(res.total);
                $('.navbar .badge').text(res.cart_count);
            }
        }
    });
}

// Remove item
$(document).on('click', '.remove-btn', function() {
    const id = $(this).data('id');
    $.ajax({
        url: '/webdev/public/cart/remove',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: id }),
        success: function(res) {
            if (res.success) {
                $('#row-' + id).fadeOut(300, function() { $(this).remove(); });
                $('#cartTotal, #cartTotalFinal').text(res.total);
                $('.navbar .badge').text(res.cart_count);
            }
        }
    });
});

// Add to cart (global - dùng cho tất cả trang)
$(document).on('click', '.add-to-cart', function() {
    const id = $(this).data('id');
    $.ajax({
        url: '/webdev/public/cart/add',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: id, quantity: 1 }),
        success: function(res) {
            if (res.success) {
                $('.navbar .badge').text(res.cart_count);
                alert('Đã thêm vào giỏ hàng!');
            } else {
                alert(res.message);
            }
        }
    });
});
</script>