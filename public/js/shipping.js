(function() {

    'use strict';

    var Shipping = function() {
        this.validationMessages = {
            name: {
                isEmpty: "Name is required"
            },
            address1: {
                isEmpty: "Address 1 is required"
            },
            city: {
                isEmpty: "City is required"
            },
            state: {
                isEmpty: "State is required"
            },
            country: {
                isEmpty: "Country is required"
            },
            shipping_method: {
                isEmpty: "Shipping Method is required"
            },
        };
    };

    Shipping.prototype = {
        init: function() {
            this.bindEvents();
        },
        saveShipping: function(name, address1, address2, address3, city, state, country, shippingMethod) {
            var params = {
                name: name,
                address1: address1,
                address2: address2,
                address3: address3,
                city: city,
                state: state,
                country: country,
                shipping_method: shippingMethod,
            };
            helpers.ajaxPost('/shipping/save', params, function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success === 1) {
                    window.location.href = "/payment";
                } else {
                    var errors = jsonResponse.errors;
                    for (var errorKey of Object.keys(errors)) {
                        for (var validatorKey of Object.keys(errors[errorKey])) {
                            document.getElementById(`error-${errorKey}`).textContent = errors[errorKey][validatorKey];
                            document.getElementById(`error-${errorKey}`).style.display = 'block';
                        }
                    }
                }
            }.bind(this));
        },
        bindEvents: function() {
            var shippingForm = document.getElementById('form-shipping');
            shippingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var errors = 0;
                var name = document.getElementById('input-name').value;
                var address1 = document.getElementById('input-address1').value;
                var address2 = document.getElementById('input-address2').value;
                var address3 = document.getElementById('input-address3').value;
                var city = document.getElementById('input-city').value;
                var state = document.getElementById('input-state').value;
                var country = document.getElementById('input-country').value;
                var shippingMethod = getCheckedRadioValue('option_shipping');
                
                hideFormErrors(shippingForm);

                if (name === "") {
                    document.getElementById('error-name').textContent = this.validationMessages.name.isEmpty;
                    document.getElementById('error-name').style.display = "block";
                    errors++;
                }
                if (address1 === "") {
                    document.getElementById('error-address1').textContent = this.validationMessages.address1.isEmpty;
                    document.getElementById('error-address1').style.display = "block";
                    errors++;
                }
                if (city === "") {
                    document.getElementById('error-city').textContent = this.validationMessages.city.isEmpty;
                    document.getElementById('error-city').style.display = "block";
                    errors++;
                }
                if (state === "") {
                    document.getElementById('error-state').textContent = this.validationMessages.state.isEmpty;
                    document.getElementById('error-state').style.display = "block";
                    errors++;
                }
                if (country === "") {
                    document.getElementById('error-country').textContent = this.validationMessages.country.isEmpty;
                    document.getElementById('error-country').style.display = "block";
                    errors++;
                }

                if (errors === 0) {
                    this.saveShipping.bind(this)(name, address1, address2, address3, city, state, country, shippingMethod);
                }
            }.bind(this));
        }
    }

    function hideFormErrors(form) {
        var formErrors = form.getElementsByClassName('input-error');
        for (var i = 0; i < formErrors.length; i++) {
            formErrors[i].textContent = "";
            formErrors[i].style.display = null;
        }
    }

    function getCheckedRadioValue(name) {
        var elements = document.getElementsByName(name);
    
        for (var i=0, len=elements.length; i<len; ++i)
            if (elements[i].checked) return elements[i].value;
    }

    var app = new Shipping;
    app.init();
})();