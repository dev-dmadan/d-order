/**
 * Method onChangeField
 * @param {object} scope
 */
function onChangeField(scope) {
    if(scope.value !== "") {
        $('#'+scope.id).removeClass('is-invalid').addClass('is-valid');
        $(".message-"+scope.id).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('valid-feedback').text('');
    }
    else {
        $('#'+scope.id).removeClass('is-invalid').removeClass('is-valid');
        $(".message-"+scope.id).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text('');
    }
}

/**
 * Method setNotif
 * @param {object} notif
 * @param {string} type set default: 'default'
 */
function setNotif(notif, type = 'default') {
    if(type === 'swal') { swal(notif.title, notif.message, notif.type); }
    else if(type === 'toastr') {
        switch(notif.type){
            case 'success':
                iziToast.success({
                    title: notif.title,
                    message: notif.message,
                    position: 'topRight'
                });
                break;
            case 'warning':
                iziToast.warning({
                    title: notif.title,
                    message: notif.message,
                    position: 'topRight'
                });
                break;
            case 'error':
                iziToast.error({
                    title: notif.title,
                    message: notif.message,
                    position: 'topRight'
                });
                break;
            default:
                iziToast.info({
                    title: notif.title,
                    message: notif.message,
                    position: 'topRight'
                });
                break; 
        }
    }
    else { alert(notif.message+": "+notif.title); }
}

/**
 * Method setError
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