(function() {

    'use strict';

    var Login = function() {
        this.validationMessages = {
            register: {
                email: {
                    isEmpty: "Email is required"
                },
                password: {
                    isEmpty: "Password is required"
                },
                confirm_password: {
                    isEmpty: "Confirm Password is required",
                    doesNotMatch: "Confirm Password does not match with Password"
                },
                company_name: {
                    isEmpty: "Company Name is required",
                    stringLengthTooLong: "Company Name is too long",
                },
                first_name: {
                    isEmpty: "First Name is required",
                    stringLengthTooLong: "First Name is too long",
                },
                last_name: {
                    isEmpty: "Last Name is required",
                    stringLengthTooLong: "Last Name is too long",
                },
            },
            login: {
                email: {
                    isEmpty: "Email is required"
                },
                password: {
                    isEmpty: "Password is required"
                },
            }
        };
    };

    Login.prototype = {
        init: function() {
            this.bindEvents();
        },
        login: function(email, password) {
            var params = {
                email: email,
                password: password,
            };
            helpers.ajaxPost('/login/auth', params, function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success === 1) {
                    var redirect = document.getElementById('input-redirect').value;
                    if (redirect) {
                        window.location.href = redirect;
                    } else {
                        window.location.href = "/";
                    }
                } else {
                    var errors = jsonResponse.errors;
                    for (var errorKey of Object.keys(errors)) {
                        for (var validatorKey of Object.keys(errors[errorKey])) {
                            document.getElementById(`error-login-${errorKey}`).textContent = errors[errorKey][validatorKey];
                            document.getElementById(`error-login-${errorKey}`).style.display = 'block';
                        }
                    }
                }
            });
        },
        register: function(email, password, confirmPassword, companyName, firstName, lastName) {
            var params = {
                email: email,
                password: password,
                confirm_password: confirmPassword,
                company_name: companyName,
                first_name: firstName,
                last_name: lastName,
            };
            helpers.ajaxPost('/register', params, function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success === 1) {
                    var redirect = document.getElementById('input-redirect').value;
                    if (redirect) {
                        window.location.href = redirect;
                    } else {
                        window.location.href = "/";
                    }
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
            var loginForm = document.getElementById('form-login');
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var errors = 0;
                var email = document.getElementById('input-login-email').value;
                var password = document.getElementById('input-login-password').value;

                hideFormErrors(loginForm);

                if (email === "") {
                    document.getElementById('error-login-email').textContent = this.validationMessages.login.email.isEmpty;
                    document.getElementById('error-login-email').style.display = "block";
                    errors++;
                }
                if (password === "") {
                    document.getElementById('error-login-password').textContent = this.validationMessages.login.password.isEmpty;
                    document.getElementById('error-login-password').style.display = "block";
                    errors++;
                }

                if (errors === 0) {
                    this.login.bind(this)(email, password);
                }
            }.bind(this));

            var registerForm = document.getElementById('form-register');
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var errors = 0;
                var email = document.getElementById('input-email').value;
                var password = document.getElementById('input-password').value;
                var confirmPassword = document.getElementById('input-confirm-password').value;
                var companyName = document.getElementById('input-company-name').value;
                var firstName = document.getElementById('input-first-name').value;
                var lastName = document.getElementById('input-last-name').value;

                hideFormErrors(registerForm);

                if (email === "") {
                    document.getElementById('error-email').textContent = this.validationMessages.register.email.isEmpty;
                    document.getElementById('error-email').style.display = "block";
                    errors++;
                }
                if (password === "") {
                    document.getElementById('error-password').textContent = this.validationMessages.register.password.isEmpty;
                    document.getElementById('error-password').style.display = "block";
                    errors++;
                }
                if (confirmPassword === "") {
                    document.getElementById('error-confirm_password').textContent = this.validationMessages.register.confirm_password.isEmpty;
                    document.getElementById('error-confirm_password').style.display = "block";
                    errors++;
                } else if (password !== confirmPassword) {
                    document.getElementById('error-confirm_password').textContent = this.validationMessages.register.confirm_password.doesNotMatch;
                    document.getElementById('error-confirm_password').style.display = "block";
                    errors++;
                }
                if (firstName === "") {
                    document.getElementById('error-first_name').textContent = this.validationMessages.register.first_name.isEmpty;
                    document.getElementById('error-first_name').style.display = "block";
                    errors++;
                }
                if (lastName === "") {
                    document.getElementById('error-last_name').textContent = this.validationMessages.register.last_name.isEmpty;
                    document.getElementById('error-last_name').style.display = "block";
                    errors++;
                }

                if (errors === 0) {
                    this.register.bind(this)(email, password, confirmPassword, companyName, firstName, lastName);
                }
            }.bind(this));
        }
    }

    function hideFormErrors(form) {
        var formErrors = form.getElementsByClassName('input-error');
        for (var i = 0; i < formErrors.length; i++) {
            formErrors[i].style.display = null;
        }
    }

    var app = new Login;
    app.init();
})();