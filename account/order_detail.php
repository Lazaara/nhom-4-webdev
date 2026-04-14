<div class="container mt-4 mb-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include BASE_PATH . '/src/Views/account/sidebar.php'; ?>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <!-- Trạng thái đơn hàng -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-weight-bold mb-0">Đơn hàng #<?= $order['id'] ?></h5>
                        <a href="/webdev/public/account/orders" class="btn btn-sm btn-outline-secondary">
                            ← Quay lại
                        </a>
                    </div>

                    <!-- Progress bar trạng thái -->
                    <?php
                    $steps = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'delivered' => 3];
                    $currentStep = $steps[$order['status']] ?? 0;
                    $stepLabels = ['Đặt hàng', 'Đang xử lý', 'Đang giao', 'Đã giao'];
                    ?>
                    <div class="d-flex justify-content-between text-center mb-4 mt-3">
                        <?php foreach ($stepLabels as $i => $label): ?>
                        <div class="flex-fill">
                            <div class="rounded-circle mx-auto mb-1 d-flex align-items-center justify-content-center"
                                 style="width:40px;height:40px;background:<?= $i <= $currentStep ? '#dc3545' : '#dee2e6' ?>;">
                                <i class="fas <?= $i <= $currentStep ? 'fa-check' : 'fa-circle' ?> text-white small"></i>
                            </div>
                            <p class="small mb-0 <?= $i <= $currentStep ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                                <?= $label ?>
                            </p>
                        </div>
                        <?php if ($i < count($stepLabels) - 1): ?>
                        <div class="flex-fill d-flex align-items-start pt-2">
                            <hr class="w-100 <?= $i < $currentStep ? 'border-danger' : '' ?>">
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Info -->
                    <div class="row small">
                        <div class="col-md-6 mb-2">
                            <span class="text-muted">Mã đơn hàng:</span>
                            <span class="font-weight-bold ml-1">#<?= $order['id'] ?></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted">Ngày đặt:</span>
                            <span class="ml-1"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted">Giao đến:</span>
                            <span class="ml-1"><?= htmlspecialchars($order['recipient_name']) ?> - <?= htmlspecialchars($order['line1']) ?></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted">Thanh toán:</span>
                            <span class="ml-1">Thanh toán khi nhận hàng (COD)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Sản phẩm đã đặt</h6>
                    <?php foreach ($items as $item): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/60x60') ?>"
                                 style="width:60px;height:60px;object-fit:contain;" class="mr-3">
                            <div>
                                <p class="mb-0 font-weight-bold small"><?= htmlspecialchars($item['name']) ?></p>
                                <p class="mb-0 text-muted small">x<?= $item['quantity'] ?></p>
                            </div>
                        </div>
                        <span class="font-weight-bold text-danger">
                            <?= number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') ?>đ
                        </span>
                    </div>
                    <?php endforeach; ?>

                    <div class="d-flex justify-content-between font-weight-bold mt-2">
                        <span>Tổng cộng:</span>
                        <span class="text-danger"><?= number_format($order['total'], 0, ',', '.') ?>đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>