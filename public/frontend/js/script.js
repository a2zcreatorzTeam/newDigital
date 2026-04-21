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
        // Remove previous error messages and red borders
        current_fs.find(".error-message").remove();
        current_fs.find(".error-border").removeClass("error-border");

        // Add your validation logic here
        var isValid = true;

        current_fs.find("select[required], input[required]").each(function () {
            if ($(this).is('select') && $(this).val() === null) {
                // Handle select elements differently
                $(this).after('<p class="error-message">This field is required.</p>');
                $(this).addClass("error-border");
                isValid = false;
            } else if ($(this).val().trim() === "") {
                // Show error for empty field
                $(this).after('<p class="error-message">This field is required.</p>');
                $(this).addClass("error-border");
                isValid = false;
            } else if ($(this).attr('name') === 'phno' && !isValidPhoneNumber($(this).val())) {
                // Show error for invalid phone number
                $(this).after('<p class="error-message">Invalid phone number. Please enter 11 digits.</p>');
                $(this).addClass("error-border");
                isValid = false;
            } else if ($(this).attr('name') === 'cnic' && !isValidCNIC($(this).val())) {
                // Show error for invalid CNIC
                $(this).after('<p class="error-message">Invalid CNIC. Please enter 13 digits.</p>');
                $(this).addClass("error-border");
                isValid = false;
            } else if ($(this).attr('name') === 'email' && !isValidEmail($(this).val())) {
                // Show error for invalid email
                $(this).after('<p class="error-message">Invalid email address. Please enter a valid email.</p>');
                $(this).addClass("error-border");
                isValid = false;
            } else if ($(this).attr('name') === 'DOB' && !isValidAge($(this).val(), 18, 60)) {
                // Show error for age less than 18 or 60+
                $(this).after('<p class="error-message">You must be 18 years or older and less than 60 years to proceed.</p>');
                $(this).addClass("error-border");
                isValid = false;
            }
        });

        return isValid;
    }

    function isValidPhoneNumber(phoneNumber) {
        // Check if the phone number contains 11 digits
        return /^\d{11}$/.test(phoneNumber);
    }

    function isValidCNIC(cnic) {
        // Check if the CNIC contains 13 digits
        return /^\d{13}$/.test(cnic);
    }
    function isValidEmail(email) {
        // Use a simple regular expression to check for a valid email format
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
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