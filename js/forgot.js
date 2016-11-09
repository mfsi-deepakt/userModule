$(document).ready(function() {
    $('#forgotPass').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {

        }
    });
});