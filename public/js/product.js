(function() {

    'use strict';

    var Product = function() {

    };

    Product.prototype = {
        init: function() {
            this.bindEvents();
        },
        addToCart: function(productId, qty) {
            var params = {
                product_id: productId,
                qty: qty,
            };
            helpers.ajaxPost('/cart/add-to-cart', params, function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success === 1) {
                    window.location.href = "/cart";
                }
            });
        },
        bindEvents: function() {
            var addToCartBtn = document.getElementById('btn-add-to-cart');
            var qtyInput = document.getElementById('input-qty');

            addToCartBtn.addEventListener('click', function() {
                var qty = qtyInput.value;
                    qty = parseInt(qty) || 0;
                if (qty > 0) {
                    var productId = document.getElementById('input-product-id').value;
                    this.addToCart.bind(this)(productId, qty);
                }
            }.bind(this));

            qtyInput.addEventListener('change', function() {
                var max = this.getAttribute('max');
                var price = document.getElementById('input-product-price').value;
                    price = parseFloat(price) || 0;
                var qty = qtyInput.value;
                    qty = parseInt(qty) || 0;

                if (qty > max) {
                    qty = max;
                    this.value = qty;
                }

                var totalPrice = price * qty;
                if (qty > 0) {
                    addToCartBtn.disabled = false;
                } else {
                    addToCartBtn.disabled = true;
                }
                document.getElementById('total-price').textContent = totalPrice.toFixed(2);
            });
        }
    }

    var app = new Product;
    app.init();
})();