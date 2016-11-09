$(document).ready(function() {
    $('.tab a').on('click', function(e) {
        e.preventDefault();
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        target = $(this).attr('href');

        $('.tab-content > div').not(target).hide();

        $(target).fadeIn(600);
    });

    $('#signUp').validate({
        rules: {
            fname: {
                required: true,
                validName: true
            },
            lname: {
                required: true,
                validName: true
            },
            email: {
                required: true,
                email: true
            },
            pass: {
                required: true,
                pass: true
            }
        },
        messages: {

        }
    });
    $('#loginUs').validate({
        rules: {
            emailLogin: {
                required: true,
                email: true
            },
            passLogin: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            passLogin: {
                required: "Please enter password!",
                minlength: "Password is too small!"
            }
        }
    });
});

jQuery.validator.addMethod("validName", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]*$/.test(value);
}, "Name is Invalid.");

jQuery.validator.addMethod("pass", function(value, element) {
    return this.optional(element) || /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value);
}, "Minimum 8 characters at least 1 Alphabet and 1 Number!");