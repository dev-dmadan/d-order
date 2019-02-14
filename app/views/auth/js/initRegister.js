$(document).ready(function() {
    // event on click register
    $('#btn-form-register').on('click', function() {
        showFormRegister();
    });

    // event on click reset
    $('#btn-reset').on('click', function() {
        reset();
    });

    // event on submit register
    $('#form-registration').on('submit', function(e) {
        e.preventDefault();
        submit_register();

		return false;
    });

});

/**
 * 
 */
function showFormRegister() {
    reset();
    $('#modal-form-registration').modal({backdrop: 'static'});
}

/**
 * 
 */
function getDataForm() {
    var data = new FormData();

    data.append('name', $('#fullname').val().trim());
    data.append('username', $('#username_register').val().trim());
    data.append('password', $('#password_register').val().trim());
    data.append('confirm_password', $('#confirm_password').val().trim());
    data.append('image', $('#image')[0].files[0]);

    return data;
}

/**
 * Method submit_login
 */
function submit_register() {
    var data = getDataForm();
    
    $.ajax({
        url: BASE_URL+'register/',
        type: 'POST',
        dataType: 'json',
        data: data,
        contentType: false,
		cache :false,
		processData: false,
        beforeSend: function(){
            $('#btn-reset').prop('disabled', true);
            $('#btn-register').prop('disabled', true);
            // $('#btn-register').prepend('<i class="fa fa-spin fa-refresh"></i> ');
        },
        success: function(response){
            console.log('%cResponse Submit Register: ', 'color: green; font-weight: bold', response);
            $('#btn-reset').prop('disabled', false);
            $('#btn-register').prop('disabled', false);
            if(response.success) { 
                setNotif(response.notif, 'swal');
                $('#modal-form-registration').modal('hide');
            }
            else {
                // $('#btn-register').html($('#btn-register').text());
                setError(response.error);
                setNotif(response.notif, 'toastr');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { // error handling
            console.log('%cError Response Submit Register: ', 'color: red; font-weight: bold', jqXHR, textStatus, errorThrown);
            var errorMessage = {type: 'error', title: 'Error Message', message: 'Please try again'};
            setNotif(errorMessage, 'swal');
            $('#btn-register').prop('disabled', false);
            // $('#btn-register').html($('#btn-register').text());
            $('#modal-form-registration').modal('hide');
        }
    });
}

/**
 * 
 */
function reset() {
    $('#form-registration').trigger('reset');
    $('#form-registration .field').removeClass('is-invalid').removeClass('is-valid');
    $('#form-registration .message').removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text('');
}