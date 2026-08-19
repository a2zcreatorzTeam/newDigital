window.showSignInAuthForm = function () {
    $(".otp-form").hide();
    $(".lost-password").hide();
    $(".signup-form").hide();
    $(".signin-form").show();
};

window.showSignUpAuthForm = function () {
    $(".otp-form").hide();
    $(".lost-password").hide();
    $(".signin-form").hide();
    $(".signup-form").show();
};

$(document).ready(function () {
    $("#show_hide_password a").on("click", function (event) {
        event.preventDefault();
        if ($("#show_hide_password input").attr("type") == "text") {
            $("#show_hide_password input").attr("type", "password");
            $("#show_hide_password i").addClass("fa-eye-slash");
            $("#show_hide_password i").removeClass("fa-eye");
        } else if ($("#show_hide_password input").attr("type") == "password") {
            $("#show_hide_password input").attr("type", "text");
            $("#show_hide_password i").removeClass("fa-eye-slash");
            $("#show_hide_password i").addClass("fa-eye");
        }
    });
    // Function to show/hide the lost password section
    $("#lostPasswordLink").click(function () {
        $("#lostPasswordSection").toggle();
    });

    // Function to cancel the lost password action
    $("#cancelLostPassword").click(function () {
        $("#lostPasswordSection").hide();
    });
    function togglePassword() {
        var passwordField = $("#inputPassword");
        var passwordFieldType = passwordField.attr("type");
        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
        } else {
            passwordField.attr("type", "password");
        }
    }

    $(document).on("click", ".js-show-signup", function () {
        window.showSignUpAuthForm();
    });
    $(document).on("click", ".js-show-signin", function () {
        window.showSignInAuthForm();
    });
    $("#lostPasswordLink").click(function () {
        $(".lost-password").show();
        $(".signin-form").hide();
        $(".signup-form").hide();
    });
    $("#cancelLostPassword").click(function () {
        $(".lost-password").hide();
        $(".signup-form").hide();
        $(".signin-form").show();
    });

    $("#hide").click(function () {
        $(".target-text").hide();
    });
});
