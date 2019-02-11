$(document).ready(function() {

    // event on submit login
    $('#form-login').on('submit', function(e) {
        e.preventDefault();
        submit_login();

		return false;
    });

    // event on change field
    $('.field').on('change', function(){
		if(this.value !== ""){
			$('#'+this.id).removeClass('is-invalid').addClass('is-valid');
			$(".message-"+this.id).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('valid-feedback').text('');
		}
		else{
			$('#'+this.id).removeClass('is-invalid').removeClass('is-valid');
			$(".message-"+this.id).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text('');
		}
	});
});

/**
 * Method submit_login
 */
function submit_login() {
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

/**
 * Method setError
 * Proses menampilkan pesan error di field-field yang terdapat kesalahan
 * @param {object} error 
 */
function setError(error) {
    $.each(error, function(index, item){
		if(item != ""){
			$('#'+index).removeClass('is-invalid').removeClass('is-valid').addClass('is-invalid');
			$('.message-'+index).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text(item);
		}
		else{
			$('#'+index).removeClass('is-invalid').removeClass('is-valid').addClass('is-valid');
			$('.message-'+index).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('valid-feedback').text(item);
		}
	});
}