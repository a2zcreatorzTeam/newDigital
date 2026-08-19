(function (global) {
    function jq() {
        return global.jQuery;
    }

    function digitsOnly(value) {
        return String(value == null ? '' : value).replace(/\D/g, '');
    }

    function isValidPhoneNumber(phoneNumber) {
        return /^\d{11}$/.test(digitsOnly(phoneNumber));
    }

    function isValidCNIC(cnic) {
        return /^\d{13}$/.test(digitsOnly(cnic));
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email == null ? '' : email));
    }

    function isHiddenType($el) {
        var type = ($el.attr('type') || '').toLowerCase();
        return type === 'hidden' || type === 'button' || type === 'submit' || type === 'reset';
    }

    function isFieldApplicable($el, $container) {
        var el = $el[0];
        if (!el || el.disabled || isHiddenType($el)) {
            return false;
        }

        // Walk parents so Select2-hidden <select>s still validate, while
        // skipping fields inside hidden conditional wrappers.
        var node = el.parentElement;
        var containerEl = $container[0];
        while (node && node !== containerEl) {
            var style = global.getComputedStyle(node);
            if (style.display === 'none' || style.visibility === 'hidden') {
                return false;
            }
            node = node.parentElement;
        }

        return true;
    }

    function errorAnchor($el) {
        var $s2 = $el.next('.select2-container');
        return $s2.length ? $s2 : $el;
    }

    function markInvalid($el, message) {
        var $anchor = errorAnchor($el);
        $anchor.after('<p class="error-message">' + message + '</p>');
        $el.addClass('error-border');
        $anchor.addClass('error-border');
    }

    function radioGroupChecked($container, name) {
        var found = false;
        $container.find('input[type="radio"]').each(function () {
            if (this.name === name && this.checked) {
                found = true;
                return false;
            }
        });
        return found;
    }

    function isEmptyRequired($el, $container) {
        if ($el.is(':checkbox')) {
            return !$el.is(':checked');
        }
        if ($el.is(':radio')) {
            return !radioGroupChecked($container, $el.attr('name'));
        }
        if (($el.attr('type') || '').toLowerCase() === 'file') {
            return !(elFiles($el).length);
        }
        if ($el.is('select')) {
            var selected = $el.val();
            if (selected === null || selected === undefined) {
                return true;
            }
            if (Array.isArray(selected)) {
                return selected.length === 0 || selected.every(function (item) {
                    return String(item).trim() === '';
                });
            }
            return String(selected).trim() === '';
        }
        var val = $el.val();
        if (val === null || val === undefined) {
            return true;
        }
        return String(val).trim() === '';
    }

    function elFiles($el) {
        var el = $el[0];
        return (el && el.files) ? el.files : [];
    }

    function fieldName($el) {
        return $el.attr('name') || '';
    }

    function isPhoneField(name) {
        return name === 'phno' || name === 'mobile_number' || name === 'appointee_mobile';
    }

    function isCnicField(name) {
        return name === 'cnic' || name === 'cnic_number' || name === 'appointee_cnic';
    }

    function isEmailField(name) {
        return name === 'email' || name === 'user_email' || name === 'life_proposed_email';
    }

    function validatePolicyStepFields(container) {
        var $ = jq();
        if (!$ || !container) {
            return true;
        }

        var $container = container.jquery ? container : $(container);
        if (!$container.length) {
            return true;
        }

        $container.find('.error-message').remove();
        $container.find('.error-border').removeClass('error-border');

        var isValid = true;
        var processedRadios = {};

        $container.find('select[required], input[required], textarea[required]').each(function () {
            var $el = $(this);
            if (!isFieldApplicable($el, $container)) {
                return;
            }

            var name = fieldName($el);
            if ($el.is(':radio')) {
                if (!name || processedRadios[name]) {
                    return;
                }
                processedRadios[name] = true;
            }

            if (isEmptyRequired($el, $container)) {
                markInvalid($el, 'This field is required.');
                isValid = false;
                return;
            }

            if (isPhoneField(name) && !isValidPhoneNumber($el.val())) {
                markInvalid($el, 'Invalid phone number. Please enter 11 digits.');
                isValid = false;
                return;
            }

            if (isCnicField(name) && !isValidCNIC($el.val())) {
                markInvalid($el, 'Invalid CNIC. Please enter 13 digits.');
                isValid = false;
                return;
            }

            if (isEmailField(name) && !isValidEmail($el.val())) {
                markInvalid($el, 'Invalid email address. Please enter a valid email.');
                isValid = false;
                return;
            }

            if (name === 'age_nearest_date') {
                var ageVal = parseInt($el.val(), 10);
                if (!isNaN(ageVal) && ageVal < 18) {
                    markInvalid($el, 'Proposer must be 18 years or older.');
                    isValid = false;
                    return;
                }
            }

            var el = $el[0];
            if (el && typeof el.checkValidity === 'function' && !el.checkValidity()) {
                markInvalid($el, el.validationMessage || 'This field is required.');
                isValid = false;
            }
        });

        return isValid;
    }

    global.validatePolicyStepFields = validatePolicyStepFields;
    global.isValidPhoneNumber = isValidPhoneNumber;
    global.isValidCNIC = isValidCNIC;
    global.isValidEmail = isValidEmail;
})(window);

$(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        if (validateFields(current_fs)) {
            // Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            // Show the next fieldset
            next_fs.show();

            // Hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    // For making fieldset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });

            setProgressBar(++current);
        }
    });

    $(".buy").click(function () {
        current_fs = $(this).closest("fieldset");
        next_fs = current_fs.next();
    
        if (validateFields(current_fs)) {
            // Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    
            // Show the next fieldset
            next_fs.show();
    
            // Hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    // For making fieldset appear animation
                    opacity = 1 - now;
    
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
    
            setProgressBar(++current);
        }
    });

    
    $(".previous").click(function () {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        // Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        // Show the previous fieldset
        previous_fs.show();

        // Hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // For making fieldset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 500
        });

        setProgressBar(--current);
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%");
    }

    function validateFields(current_fs) {
        if (typeof window.validatePolicyStepFields === 'function') {
            return window.validatePolicyStepFields(current_fs);
        }
        return true;
    }
    function isValidAge(dateOfBirth, lowerLimit, upperLimit) {
        var today = new Date();
        var birthDate = new Date(dateOfBirth);
        var age = today.getFullYear() - birthDate.getFullYear();
    
        // Check if the age is within the specified limits
        return age >= lowerLimit && age < upperLimit;
    }


    $(".submit").click(function () {
        return false;
    });

});