</main>
<!-- END Main content -->

<!-- FOOTER -->
<footer class="bg-danger text-white mt-5 pt-4 pb-0">
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-10 d-flex justify-content-around text-center flex-wrap align-items-start">
				<div class="mb-3">
					<h6 class="font-weight-bold">Công ty</h6>
					<ul class="list-unstyled small">
						<li><a href="/webdev/public/page/about" class="text-white-50">Về chúng tôi</a></li>
					</ul>
				</div>
				<div class="mb-3">
					<h6 class="font-weight-bold">Thông tin</h6>
					<ul class="list-unstyled small">
						<li><a href="/webdev/public/page/faq" class="text-white-50">FAQ</a></li>
					</ul>
				</div>
				<div class="mb-0">
					<h6 class="font-weight-bold">Liên lạc với chúng tôi</h6>
					<ul class="list-unstyled small text-left">
						<li><i class="fas fa-map-marker-alt mr-1"></i> 27/44 Âu Dương Lân, P.3, Q.8, TP. HCM</li>
						<li><i class="fas fa-phone mr-1"></i> +0845126767</li>
						<li><i class="fas fa-envelope mr-1"></i> nanotech@gmail.com</li>
					</ul>
				</div>
			</div>
		</div>
        <hr class="border-light">
        <div class="text-center small text-white-50">
            © 2026 NanoTech. All rights reserved.
        </div>
    </div>
</footer>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <ul class="nav nav-tabs mb-3" id="authTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#loginTab">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#registerTab">Tạo tài khoản</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="loginTab">
                        <h5 class="mb-3">Đăng nhập vào NanoTech</h5>
                        <div id="loginError" class="alert alert-danger d-none"></div>
                        <div class="form-group">
                            <input type="email" id="loginEmail" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" id="loginPassword" class="form-control" placeholder="Mật khẩu">
                        </div>
                        <button class="btn btn-primary btn-block" id="loginBtn">Đăng nhập</button>
                    </div>
                    <div class="tab-pane fade" id="registerTab">
                        <h5 class="mb-3">Tạo tài khoản mới</h5>
                        <div id="registerError" class="alert alert-danger d-none"></div>
                        <div id="registerSuccess" class="alert alert-success d-none"></div>
                        <div class="form-group">
                            <input type="text" id="registerName" class="form-control" placeholder="Tên người dùng">
                        </div>
                        <div class="form-group">
                            <input type="email" id="registerEmail" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" id="registerPassword" class="form-control" placeholder="Mật khẩu">
                        </div>
                        <button class="btn btn-primary btn-block" id="registerBtn">Tạo tài khoản</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Chat Button -->
<div id="chatWidget" style="position:fixed;bottom:24px;right:24px;z-index:9999;">

    <!-- Chat bubble button -->
    <button id="chatToggle" class="btn btn-danger rounded-circle shadow-lg"
            style="width:56px;height:56px;font-size:1.3rem;">
        <i class="fas fa-robot"></i>
    </button>

    <!-- Chat box -->
    <div id="chatBox" style="
        display:none;
        position:absolute;
        bottom:70px;right:0;
        width:320px;
        background:white;
        border-radius:16px;
        box-shadow:0 8px 32px rgba(0,0,0,0.15);
        overflow:hidden;
    ">
        <!-- Header -->
        <div class="bg-danger text-white p-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-robot mr-2"></i>
                <div>
                    <p class="mb-0 font-weight-bold small">NanoTech AI</p>
                    <p class="mb-0" style="font-size:11px;opacity:0.8;">Tư vấn sản phẩm</p>
                </div>
            </div>
            <button id="chatClose" class="btn btn-sm text-white p-0">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Messages -->
        <div id="chatMessages" style="height:280px;overflow-y:auto;padding:12px;">
            <div class="d-flex mb-2">
                <div class="bg-light rounded p-2 small" style="max-width:85%;">
                    Xin chào! Tôi có thể giúp bạn tìm sản phẩm phù hợp. Bạn đang tìm gì? 😊
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-2 border-top d-flex">
            <input type="text" id="chatInput" class="form-control form-control-sm mr-2"
                   placeholder="Nhập câu hỏi...">
            <button class="btn btn-danger btn-sm" id="chatSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/webdev/public/js/main.js?v=<?= time() ?>"></script>
</body>
</html>