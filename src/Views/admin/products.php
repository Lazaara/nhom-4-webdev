<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Quản lý sản phẩm</h4>
    <a href="/webdev/public/admin/product-add" class="btn btn-danger">
        <i class="fas fa-plus mr-1"></i> Thêm sản phẩm
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>SKU</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><code><?= $p['sku'] ?></code></td>
                    <td><?= htmlspecialchars($p['category_name']) ?></td>
                    <td class="text-danger"><?= number_format($p['price'], 0, ',', '.') ?>đ</td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <a href="/webdev/public/admin/product-edit/<?= $p['id'] ?>"
                           class="btn btn-sm btn-outline-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger delete-product"
                                data-id="<?= $p['id'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('click', '.delete-product', function() {
    if (!confirm('Xóa sản phẩm này?')) return;
    const id = $(this).data('id');
    $.ajax({
        url: '/webdev/public/admin/product-delete',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id }),
        success: function(res) {
            if (res.success) location.reload();
        }
    });
});
</script>