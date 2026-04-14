<div class="container mt-4 mb-5">
    <h4 class="font-weight-bold mb-4">Thanh toán</h4>

    <div class="row">
        <!-- Form thông tin -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Thông tin giao hàng</h6>
                    <div id="checkoutError" class="alert alert-danger d-none"></div>

                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" id="shipName" class="form-control"
                               value="<?= htmlspecialchars($_SESSION['user_name']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" id="shipPhone" class="form-control" placeholder="0xxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ giao hàng</label>
                        <input type="text" id="shipAddress" class="form-control"
                               placeholder="Số nhà, đường, phường, quận, tỉnh/thành phố">
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Phương thức thanh toán</h6>
                    <div class="border rounded p-3 d-flex align-items-center">
                        <input type="radio" checked disabled class="mr-2">
                        <i class="fas fa-money-bill-wave text-success mr-2"></i>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Đơn hàng của bạn</h6>

                    <?php foreach ($items as $item): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/40x40') ?>"
                                 style="width:40px;height:40px;object-fit:contain;" class="mr-2">
                            <div>
                                <p class="mb-0 small"><?= htmlspecialchars($item['name']) ?></p>
                                <p class="mb-0 text-muted small">x<?= $item['quantity'] ?></p>
                            </div>
                        </div>
                        <span class="small font-weight-bold">
                            <?= number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') ?>đ
                        </span>
                    </div>
                    <?php endforeach; ?>

                    <hr>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Tạm tính:</span>
                        <span><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-danger"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>

                    <button class="btn btn-danger btn-block mt-3" id="placeOrderBtn">
                        Đặt hàng <i class="fas fa-check ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>