document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function() {
        const $formAuthentication = $(".log-in");

        if ($formAuthentication.length) {
            FormValidation.formValidation($formAuthentication[0], {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: "Please enter username"
                            },
                            stringLength: {
                                min: 6,
                                message: "Username must be more than 6 characters"
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Please enter your email"
                            },
                            emailAddress: {
                                message: "Please enter valid email address"
                            }
                        }
                    },
                    "email-username": {
                        validators: {
                            notEmpty: {
                                message: "Please enter email / username"
                            },
                            stringLength: {
                                min: 6,
                                message: "Username must be more than 6 characters"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Please enter your password"
                            },
                            stringLength: {
                                min: 6,
                                message: "Password must be more than 6 characters"
                            }
                        }
                    },
                    "confirm-password": {
                        validators: {
                            notEmpty: {
                                message: "Please confirm password"
                            },
                            identical: {
                                compare: function() {
                                    return $formAuthentication.find('[name="password"]').val();
                                },
                                message: "The password and its confirm are not the same"
                            },
                            stringLength: {
                                min: 6,
                                message: "Password must be more than 6 characters"
                            }
                        }
                    },
                    terms: {
                        validators: {
                            notEmpty: {
                                message: "Please agree terms & conditions"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: "",
                        rowSelector: ".mb-3"
                    }),
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: function(e) {
                    e.on("plugins.message.placed", function(e) {
                        if ($(e.element).parent().hasClass("input-group")) {
                            $(e.element).parent().after(e.messageElement);
                        }
                    });
                }
            });
        }

        const $numeralMasks = $(".numeral-mask");
        if ($numeralMasks.length) {
            $numeralMasks.each(function() {
                new Cleave($(this)[0], {
                    numeral: true
                });
            });
        }
    });
});

$(document).on('click', '#show-password', function() {
    const $passwordInput = $('#password');
    const $icon = $(this).find('i');

    if ($passwordInput.attr('type') === 'password') {
        $passwordInput.attr('type', 'text');
        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        $passwordInput.attr('type', 'password');
        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
    }
});

$(document).on('click', '#show-password-confirm', function() {
    const $passwordInput = $('#retype-password');
    const $icon = $(this).find('i');

    if ($passwordInput.attr('type') === 'password') {
        $passwordInput.attr('type', 'text');
        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        $passwordInput.attr('type', 'password');
        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
    }
});