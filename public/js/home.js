(function() {

    'use strict';

    var Home = function() {

    };

    Home.prototype = {
        init: function() {
            this.bindEvents();
        },
        bindEvents: function() {
            var productElements = document.getElementsByClassName('product');
            for (var i = 0; i < productElements.length; i++) {
                productElements[i].addEventListener('click', function() {
                    var productId = this.getElementsByClassName('input-product-id')[0].value;
                    window.location.href = '/product/' + productId;
                });
            }
        }
    }

    var app = new Home;
    app.init();
})();