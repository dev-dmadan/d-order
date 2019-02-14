$(document).ready(function() {

    // event on submit register
    $('#form-registration').on('submit', function(e) {
        e.preventDefault();
        submit_register();

		return false;
    });

});

/**
 * Method submit_login
 */
function submit_register() {
    $.ajax({
        url: BASE_URL+'login/',
        type: 'POST',
        dataType: 'json',
        data:{
            'username': $('#username').val().trim(),
            'password': $('#username').val().trim(),
        },
        beforeSend: function(){
            $('#submit-login').prop('disabled', true);
            $('#submit-login').prepend('<i class="fa fa-spin fa-refresh"></i> ');
        },
        success: function(response){
            console.log('%cResponse Submit Login: ', 'color: green; font-weight: bold', response);
            if(response.success) { 
                document.location=BASE_URL;
            }
            else {
                $('#submit-login').prop('disabled', false);
                $('#submit-login').html($('#submit-login').text());
                setError(response.error);
                setNotif(response.notif, 'toastr');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { // error handling
            console.log('%cError Response Submit Login: ', 'color: red; font-weight: bold', jqXHR, textStatus, errorThrown);
            var errorMessage = {type: 'error', title: 'Error Message', message: 'Please try again'};
            setNotif(errorMessage, 'swal');
            $('#submit-login').prop('disabled', false);
            $('#submit-login').html($('#submit-login').text());
        }
    });
}