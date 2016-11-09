$(document).ready(function() {
    $('.tab a').on('click', function(e) {
        e.preventDefault();
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        target = $(this).attr('href');

        $('.tab-content > div').not(target).hide();

        $(target).fadeIn(600);
    });
    $('#education').validate({
        rules: {
            eduDetail: {
                required: true,
                validInfo: true
            },
        },
        messages: {}
    });
    $('#project').validate({
        rules: {
            projectData: Rule
        },
        messages: {
            projectData: Message
        }
    });
    $('#form3').validate({
        rules: {
            hobby: Rule
        },
        messages: {
            hobby: Message
        }
    });
});


var Rule = {
    required: true,
    validInfo: true
};
var Message = {
    required: "this field can't be empty!",
};
jQuery.validator.addMethod("validInfo", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]{20,}$/.test(value);
}, "Information is Invalid.");