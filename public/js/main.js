$(document).ready(function () {
    // Toggle search bar
    $('#searchToggle').on('click', function (e) {
        e.preventDefault();
        $('#searchBar').toggleClass('d-none');
    });

    // AJAX Login
    $('#loginBtn').on('click', function () {
        const email = $('#loginEmail').val().trim();
        const password = $('#loginPassword').val().trim();

        if (!email || !password) {
            $('#loginError').removeClass('d-none').text('Vui lòng nhập đầy đủ thông tin.');
            return;
        }

        $.ajax({
            url: '/webdev/public/auth/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email, password }),
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    $('#loginError').removeClass('d-none').text(res.message);
                }
            },
            error: function () {
                $('#loginError').removeClass('d-none').text('Có lỗi xảy ra, thử lại sau.');
            }
        });
    });

    // AJAX Register
    $('#registerBtn').on('click', function () {
        const name = $('#registerName').val().trim();
        const email = $('#registerEmail').val().trim();
        const password = $('#registerPassword').val().trim();

        if (!name || !email || !password) {
            $('#registerError').removeClass('d-none').text('Vui lòng nhập đầy đủ thông tin.');
            return;
        }

        $.ajax({
            url: '/webdev/public/auth/register',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ name, email, password }),
            success: function (res) {
                if (res.success) {
                    $('#registerError').addClass('d-none');
                    $('#registerSuccess').removeClass('d-none').text('Tạo tài khoản thành công! Đang đăng nhập...');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    $('#registerError').removeClass('d-none').text(res.message);
                }
            },
            error: function () {
                $('#registerError').removeClass('d-none').text('Có lỗi xảy ra, thử lại sau.');
            }
        });
    });

    // Add to cart (global)
    $(document).on('click', '.add-to-cart', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/webdev/public/cart/add',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ product_id: id, quantity: 1 }),
            success: function (res) {
                if (res.success) {
                    $('.navbar .badge').text(res.cart_count);
                    alert('✅ Đã thêm vào giỏ hàng!');
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Có lỗi xảy ra!');
            }
        });
    });

    // Cart qty buttons (+/-)
    $(document).on('click', '.qty-btn', function () {
        const action = $(this).data('action');
        const id     = $(this).data('id');
        const input  = $('.qty-input[data-id="' + id + '"]');
        let qty      = parseInt(input.val());
        const max    = parseInt(input.attr('max'));

        if (action === 'minus' && qty > 1) qty--;
        else if (action === 'plus' && qty < max) qty++;
        else return;

        input.val(qty);
        updateCart(id, qty, parseFloat(input.data('price')));
    });

    // Cart qty input change
    $(document).on('change', '.qty-input', function () {
        const id    = $(this).data('id');
        const qty   = parseInt($(this).val());
        const price = parseFloat($(this).data('price'));
        if (qty >= 1) updateCart(id, qty, price);
    });

    function updateCart(productId, qty, price) {
        $.ajax({
            url: '/webdev/public/cart/update',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ product_id: productId, quantity: qty }),
            success: function (res) {
                if (res.success) {
                    const itemTotal = (price * qty).toLocaleString('vi-VN') + 'đ';
                    $('.item-total-' + productId).text(itemTotal);
                    $('#cartTotal, #cartTotalFinal').text(res.total);
                    $('.navbar .badge').text(res.cart_count);
                }
            }
        });
    }

    // Cart remove item
    $(document).on('click', '.remove-btn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/webdev/public/cart/remove',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ product_id: id }),
            success: function (res) {
                if (res.success) {
                    $('#row-' + id).fadeOut(300, function () { $(this).remove(); });
                    $('#cartTotal, #cartTotalFinal').text(res.total);
                    $('.navbar .badge').text(res.cart_count);
                }
            }
        });
    });

    // Checkout
    if ($('#placeOrderBtn').length) {
        $('#placeOrderBtn').on('click', function () {
            const name    = $('#shipName').val().trim();
            const phone   = $('#shipPhone').val().trim();
            const address = $('#shipAddress').val().trim();

            if (!name || !phone || !address) {
                $('#checkoutError').removeClass('d-none').text('Vui lòng nhập đầy đủ thông tin giao hàng.');
                return;
            }

            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang xử lý...');

            $.ajax({
                url: '/webdev/public/checkout/place',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ name, phone, address }),
                success: function (res) {
                    if (res.success) {
                        window.location.href = '/webdev/public/account/orders';
                    } else {
                        $('#checkoutError').removeClass('d-none').text(res.message);
                        $('#placeOrderBtn').prop('disabled', false).html('Đặt hàng <i class="fas fa-check ml-1"></i>');
                    }
                },
                error: function () {
                    $('#checkoutError').removeClass('d-none').text('Có lỗi xảy ra, thử lại sau.');
                    $('#placeOrderBtn').prop('disabled', false).html('Đặt hàng <i class="fas fa-check ml-1"></i>');
                }
            });
        });
    }

    // Search suggest
    let searchTimeout;
    $('#searchBar input[name="q"]').on('input', function () {
        clearTimeout(searchTimeout);
        const q = $(this).val().trim();

        if (q.length < 2) {
            $('#searchSuggest').remove();
            return;
        }

        searchTimeout = setTimeout(function () {
            $.ajax({
                url: '/webdev/public/search/suggest',
                method: 'GET',
                data: { q },
                success: function (res) {
                    $('#searchSuggest').remove();
                    if (!res.length) return;

                    let html = '<div id="searchSuggest" class="position-absolute bg-white border rounded shadow-sm w-100" style="z-index:9999;top:100%">';
                    res.forEach(function (p) {
                        html += `
                            <a href="/webdev/public/product/detail/${p.id}"
                               class="d-flex align-items-center p-2 text-dark text-decoration-none border-bottom suggest-item">
                                <img src="${p.image || 'https://placehold.co/40x40'}"
                                     style="width:40px;height:40px;object-fit:contain;" class="mr-2">
                                <div>
                                    <p class="mb-0 small font-weight-bold">${p.name}</p>
                                    <p class="mb-0 small text-danger">${p.price}</p>
                                </div>
                            </a>`;
                    });
                    html += '</div>';

                    $('#searchBar .d-flex').addClass('position-relative').append(html);
                }
            });
        }, 300);
    });

    // Ẩn suggest khi click ra ngoài
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#searchBar').length) {
            $('#searchSuggest').remove();
        }
    });

    // Mega menu show/hide
    const megaWrapper = document.getElementById('megaMenuWrapper');
    const megaMenu    = document.getElementById('megaMenu');
    let megaTimeout;

    if (megaWrapper && megaMenu) {
        megaWrapper.addEventListener('mouseover', function () {
            clearTimeout(megaTimeout);
            megaMenu.style.display = 'block';
        });

        megaWrapper.addEventListener('mouseout', function (e) {
            if (!megaWrapper.contains(e.relatedTarget) && !megaMenu.contains(e.relatedTarget)) {
                megaTimeout = setTimeout(function () { megaMenu.style.display = 'none'; }, 200);
            }
        });

        megaMenu.addEventListener('mouseover', function () {
            clearTimeout(megaTimeout);
        });

        megaMenu.addEventListener('mouseout', function (e) {
            if (!megaMenu.contains(e.relatedTarget) && !megaWrapper.contains(e.relatedTarget)) {
                megaTimeout = setTimeout(function () { megaMenu.style.display = 'none'; }, 200);
            }
        });
    }

    // Mega menu - hover load products
    $(document).on('mouseover', '.mega-cat-item', function () {
        const id   = $(this).data('id');
        const name = $(this).find('span').text();

        $('.mega-cat-item').css('background', '');
        $(this).css('background', '#fff5f5');

        $('#megaMenuProducts').html('<p class="text-muted small mt-2">Đang tải...</p>');

        $.ajax({
            url: '/webdev/public/product/by-category-ajax',
            method: 'GET',
            data: { id: id },
            success: function (products) {
                if (!products.length) {
                    $('#megaMenuProducts').html('<p class="text-muted small mt-2">Chưa có sản phẩm.</p>');
                    return;
                }
                let html = `<p class="font-weight-bold text-danger mb-3">${name}</p><div class="row">`;
                products.forEach(function (p) {
                    const img   = p.image || 'https://placehold.co/120x120?text=No+Image';
                    const price = parseInt(p.price).toLocaleString('vi-VN') + 'đ';
                    html += `
                        <div class="col-md-3 mb-2">
                            <a href="/webdev/public/product/detail/${p.id}" class="text-decoration-none text-dark">
                                <div class="card border-0 shadow-sm h-100">
                                    <img src="${img}" class="card-img-top p-2" style="height:100px;object-fit:contain;">
                                    <div class="card-body p-2">
                                        <p class="small mb-1 text-truncate">${p.name}</p>
                                        <p class="small text-danger font-weight-bold mb-0">${price}</p>
                                    </div>
                                </div>
                            </a>
                        </div>`;
                });
                html += '</div>';
                $('#megaMenuProducts').html(html);
            }
        });
    });

    // Price range filter
    $(document).on('change', '.filter-input[name="price_range"]', function () {
        const parts = $(this).val().split('_');
        $('#minPriceInput').val(parts[0]);
        $('#maxPriceInput').val(parts[1]);
    });

    // Chat widget
    $('#chatToggle').on('click', function () {
        $('#chatBox').toggle();
        if ($('#chatBox').is(':visible')) {
            $('#chatInput').focus();
        }
    });

    $('#chatClose').on('click', function () {
        $('#chatBox').hide();
    });

    function sendChatMessage() {
        const message = $('#chatInput').val().trim();
        if (!message) return;

        $('#chatMessages').append(`
            <div class="d-flex justify-content-end mb-2">
                <div class="bg-danger text-white rounded p-2 small" style="max-width:85%;">
                    ${message}
                </div>
            </div>
        `);

        $('#chatInput').val('');
        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);

        $('#chatMessages').append(`
            <div class="d-flex mb-2" id="chatLoading">
                <div class="bg-light rounded p-2 small">
                    <i class="fas fa-spinner fa-spin"></i> Đang trả lời...
                </div>
            </div>
        `);
        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);

        $.ajax({
            url: '/webdev/public/chat/ask',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ message }),
            success: function (res) {
                $('#chatLoading').remove();
                if (res.success) {
                    $('#chatMessages').append(`
                        <div class="d-flex mb-2">
                            <div class="bg-light rounded p-2 small" style="max-width:85%;">
                                ${res.reply.replace(/\n/g, '<br>')}
                            </div>
                        </div>
                    `);
                } else {
                    $('#chatMessages').append(`
                        <div class="d-flex mb-2">
                            <div class="bg-light rounded p-2 small text-danger" style="max-width:85%;">
                                Xin lỗi, có lỗi xảy ra!
                            </div>
                        </div>
                    `);
                }
                $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
            },
            error: function () {
                $('#chatLoading').remove();
                $('#chatMessages').append(`
                    <div class="d-flex mb-2">
                        <div class="bg-light rounded p-2 small text-danger" style="max-width:85%;">
                            Không thể kết nối, thử lại sau!
                        </div>
                    </div>
                `);
            }
        });
    }

    $('#chatSend').on('click', sendChatMessage);

    $('#chatInput').on('keypress', function (e) {
        if (e.which === 13) sendChatMessage();
    });

});
