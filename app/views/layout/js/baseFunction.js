/**
 * Method setActiveMenu
 * @param {object} url windows.location.href
 * @param {string} level level user
 */
function setActiveMenu(url, level) {
    var newUrl = [];
    
    $.each(url, function(index, item) {
        if(item != "localhost" && item.toLowerCase() != "isystemasia") {
            newUrl.push(item);
        }
    });

    // menu order list
    if(newUrl[3] == 'orders' && newUrl[4] == undefined) {
        // default admin
        if(LEVEL == 'ADMIN') {
            $('.menu-orders-list').addClass('active');
        }
        // default member
        else if(LEVEL == 'MEMBERS') {
            $('.menu-orders-form').addClass('active');
        }
    }
    // menu order form
    else if(newUrl[3] == 'orders' && newUrl[4] == 'form') {
        $('.menu-orders-form').addClass('active');
    }
    // menu order history
    else if(newUrl[3] == 'orders' && newUrl[4] == 'history') {
        $('.menu-orders-history').addClass('active');
    }
    // menu item
    else if(newUrl[3] == 'items') {
        $('.menu-items').addClass('active');
    }
    // menu user
    else if(newUrl[3] == 'user') {
        $('.menu-user').addClass('active');
    }
    else {
        // default admin
        if(newUrl[3] == '' && LEVEL == 'ADMIN') {
            $('.menu-orders-list').addClass('active');
        }
        // default member
        else if(newUrl[3] == '' && LEVEL == 'MEMBERS') {
            $('.menu-orders-form').addClass('active');
        }
    }
    
}

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
    $.each(error, function(index, item) {
        if(item != "") {
            $('#'+index).removeClass('is-invalid').removeClass('is-valid').addClass('is-invalid');
            $('.message-'+index).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text(item);
        }
        else {
            $('#'+index).removeClass('is-invalid').removeClass('is-valid').addClass('is-valid');
            $('.message-'+index).removeClass('valid-feedback').removeClass('invalid-feedback').addClass('valid-feedback').text(item);
        }
    });
}