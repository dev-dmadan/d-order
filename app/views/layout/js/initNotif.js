/**
 * Method setNotif
 * @param {object} notif
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