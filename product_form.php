<div class="d-flex align-items-center mb-4">
    <a href="/webdev/public/admin/products" class="btn btn-outline-secondary mr-3">←</a>
    <h4 class="font-weight-bold mb-0"><?= $product ? 'Sửa sản phẩm' : 'Thêm sản phẩm' ?></h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div id="formError" class="alert alert-danger d-none"></div>
        <div id="formSuccess" class="alert alert-success d-none"></div>

        <?php if ($product): ?>
        <input type="hidden" id="productId" value="<?= $product['id'] ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" id="pName" class="form-control"
                           value="<?= htmlspecialchars($product['name'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" id="pSku" class="form-control"
                           value="<?= htmlspecialchars($product['sku'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Giá (VNĐ)</label>
                    <input type="number" id="pPrice" class="form-control"
                           value="<?= $product['price'] ?? '' ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tồn kho</label>
                    <input type="number" id="pStock" class="form-control"
                           value="<?= $product['stock'] ?? 0 ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select id="pCategory" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= (isset($product['category_id']) && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>URL hình ảnh</label>
                    <input type="text" id="pImage" class="form-control"
                           placeholder="https://..."
                           value="<?= htmlspecialchars($product['image'] ?? '') ?>">
                </div>
            </div>
        </div>

        <button class="btn btn-danger" id="saveBtn">
            <i class="fas fa-save mr-1"></i> Lưu sản phẩm
        </button>
    </div>
</div>

<script>
$('#saveBtn').on('click', function() {
    const isEdit  = $('#productId').length > 0;
    const url     = isEdit ? '/webdev/public/admin/product-update'
                           : '/webdev/public/admin/product-store';
    const payload = {
        name:        $('#pName').val().trim(),
        sku:         $('#pSku').val().trim(),
        price:       parseFloat($('#pPrice').val()),
        stock:       parseInt($('#pStock').val()),
        category_id: parseInt($('#pCategory').val()),
        image:       $('#pImage').val().trim(),
    };
    if (isEdit) payload.id = parseInt($('#productId').val());

    $.ajax({
        url, method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(res) {
            if (res.success) {
                $('#formSuccess').removeClass('d-none').text('Lưu thành công!');
                setTimeout(() => window.location.href = '/webdev/public/admin/products', 1000);
            } else {
                $('#formError').removeClass('d-none').text(res.message);
            }
        }
    });
});
</script>