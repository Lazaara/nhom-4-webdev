<h4 class="font-weight-bold mb-4">Quản lý đơn hàng</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td>
                        <p class="mb-0 font-weight-bold"><?= htmlspecialchars($order['full_name']) ?></p>
                        <p class="mb-0 small text-muted"><?= htmlspecialchars($order['email']) ?></p>
                    </td>
                    <td class="small"><?= htmlspecialchars($order['line1']) ?></td>
                    <td class="text-danger font-weight-bold">
                        <?= number_format($order['total'], 0, ',', '.') ?>đ
                    </td>
                    <td>
                        <select class="form-control form-control-sm status-select"
                                data-id="<?= $order['id'] ?>" style="width:140px;">
                            <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                                <?= ['pending'=>'Chờ xác nhận','processing'=>'Đang xử lý',
                                     'shipped'=>'Đang giao','delivered'=>'Đã giao',
                                     'cancelled'=>'Đã hủy'][$s] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="small"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('change', '.status-select', function() {
    const id     = $(this).data('id');
    const status = $(this).val();
    $.ajax({
        url: '/webdev/public/admin/order-status',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id, status }),
        success: function(res) {
            if (res.success) alert('✅ Cập nhật trạng thái thành công!');
        }
    });
});
</script>