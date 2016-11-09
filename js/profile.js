$(document).ready(function() {
    $('#profile').validate({
        rules: {
            firstName: {
                required: true,
                validName: true
            },
            lastName: {
                required: true,
                validName: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                validPhone: true
            },
            city: {
                required: true,
                validName: true
            },
            gender: {
                selectcheck: true
            },
        },
        messages: {


        }
    });
});

jQuery.validator.addMethod("validName", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]*$/.test(value);
}, "Name is Invalid.");

jQuery.validator.addMethod("validPhone", function(value, element) {
    return this.optional(element) || /^[1-9]{1}\d{9}$/.test(value);
}, "Invalid mobile number.");
jQuery.validator.addMethod('selectcheck', function(value) {
    return (value != '0');
}, "Gender required");


var Rule = {
    required: true,
    minlength: 10
};
var Message = {
    required: "this field can't be empty!",
    minlength: "Detail is too small!"
};