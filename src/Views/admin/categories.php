<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Quản lý danh mục</h4>
    <button class="btn btn-danger" data-toggle="modal" data-target="#addCategoryModal">
        <i class="fas fa-plus mr-1"></i> Thêm danh mục
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><code><?= $cat['slug'] ?></code></td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger delete-category"
                                data-id="<?= $cat['id'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm danh mục</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div id="catError" class="alert alert-danger d-none"></div>
                <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" id="catName" class="form-control" placeholder="VD: Điện thoại">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button class="btn btn-danger" id="saveCatBtn">Thêm</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#saveCatBtn').on('click', function() {
    const name = $('#catName').val().trim();
    if (!name) { $('#catError').removeClass('d-none').text('Tên không được trống.'); return; }
    $.ajax({
        url: '/webdev/public/admin/category-store',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ name }),
        success: function(res) {
            if (res.success) location.reload();
            else $('#catError').removeClass('d-none').text(res.message);
        }
    });
});

$(document).on('click', '.delete-category', function() {
    if (!confirm('Xóa danh mục này?')) return;
    const id = $(this).data('id');
    $.ajax({
        url: '/webdev/public/admin/category-delete',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id }),
        success: function(res) { if (res.success) location.reload(); }
    });
});
</script>