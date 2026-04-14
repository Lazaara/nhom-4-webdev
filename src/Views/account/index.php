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
                    <h5 class="font-weight-bold mb-4">Thông tin cá nhân</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Họ và tên</label>
                            <p class="font-weight-bold"><?= htmlspecialchars($user['full_name']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="font-weight-bold"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Số điện thoại</label>
                            <p class="font-weight-bold"><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Ngày tham gia</label>
                            <p class="font-weight-bold"><?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>