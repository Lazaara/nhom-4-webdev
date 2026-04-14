<h4 class="font-weight-bold mb-4">Dashboard</h4>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <i class="fas fa-box fa-2x text-danger mb-2"></i>
            <h3 class="font-weight-bold"><?= $totalProducts ?></h3>
            <p class="text-muted mb-0">Sản phẩm</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <i class="fas fa-shopping-bag fa-2x text-danger mb-2"></i>
            <h3 class="font-weight-bold"><?= $totalOrders ?></h3>
            <p class="text-muted mb-0">Đơn hàng</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="font-weight-bold mb-3">Đơn hàng gần đây</h6>
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['full_name']) ?></td>
                    <td class="text-danger"><?= number_format($order['total'], 0, ',', '.') ?>đ</td>
                    <td><span class="badge badge-warning"><?= $order['status'] ?></span></td>
                    <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>