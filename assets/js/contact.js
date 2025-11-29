(function ($) {
    "use strict";

    jQuery(document).ready(function ($) {
        $(document).on('submit', '#contact_form_submit', function (e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            var phone = $('#phone').val();
            var check = $('#check').is(':checked') ? 'Yes' : 'No';

            if (name && email && message) {
                $.ajax({
                    type: "POST",
                    url: 'mail.php',
                    data: {
                        'name': name,
                        'email': email,
                        'subject': subject,
                        'message': message,
                        'phone': phone,
                        'recieveCommunications': check,
                    },
                    success: function (data) {
                        $('#contact_form_submit').children('.email-success').remove();
                        $('#contact_form_submit').prepend('<span class="alert alert-success email-success">' + data + '</span>');
                        $('#name').val('');
                        $('#email').val('');
                        $('#message').val('');
                        $('#subject').val('');
                        $('#phone').val('');
                        //$('#check').prop('checked', false);
                        // $('#map').height('576px');
                        $('.email-success').fadeOut(3000);
                    },
                    error: function (res) {

                    }
                });
            } else {
                $('#contact_form_submit').children('.email-success').remove();
                $('#contact_form_submit').prepend('<span class="alert alert-danger email-success">All Fields are Required.</span>');
                // $('#map').height('576px');
                $('.email-success').fadeOut(3000);
            }

        });
    })

}(jQuery));
