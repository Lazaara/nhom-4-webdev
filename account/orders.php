<div class="container mt-4 mb-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include BASE_PATH . '/src/Views/account/sidebar.php'; ?>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-4">Lịch sử đơn hàng</h5>

                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="/webdev/public/product" class="btn btn-danger">Mua sắm ngay</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                        <div class="card mb-3 border">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="font-weight-bold">Đơn #<?= $order['id'] ?></span>
                                    <span class="text-muted small ml-2">
                                        <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                    </span>
                                </div>
                                <?php
                                $statusMap = [
                                    'pending'    => ['label' => 'Chờ xác nhận', 'class' => 'warning'],
                                    'processing' => ['label' => 'Đang xử lý',   'class' => 'info'],
                                    'shipped'    => ['label' => 'Đang giao',     'class' => 'primary'],
                                    'delivered'  => ['label' => 'Đã giao',       'class' => 'success'],
                                    'cancelled'  => ['label' => 'Đã hủy',        'class' => 'danger'],
                                ];
                                $s = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => 'secondary'];
                                ?>
                                <span class="badge badge-<?= $s['class'] ?> px-2 py-1">
                                    <?= $s['label'] ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 small text-muted">Giao đến:</p>
                                        <p class="mb-0 small"><?= htmlspecialchars($order['recipient_name']) ?> - <?= htmlspecialchars($order['phone']) ?></p>
                                        <p class="mb-0 small"><?= htmlspecialchars($order['line1']) ?></p>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <p class="mb-1 small text-muted">Tổng tiền:</p>
                                        <p class="text-danger font-weight-bold mb-0">
                                            <?= number_format($order['total'], 0, ',', '.') ?>đ
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-right">
                                <a href="/webdev/public/account/order-detail/<?= $order['id'] ?>"
                                   class="btn btn-sm btn-outline-danger">
                                    Chi tiết đơn →
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>