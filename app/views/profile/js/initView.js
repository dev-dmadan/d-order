var table_order_history = $("#table-order-history").DataTable({
    // "responsive": true,
    "lengthMenu": [ 10, 25, 75, 100 ],
    "pageLength": 10,
    "order": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": BASE_URL+"profile/get-list-order-history/",
        "type": 'POST',
        "data": {}
    },
    "columns": [
        {
            className: 'details-control',
            orderable: false,
            data: null,
            defaultContent: '',
            render: function () {
                return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
            },
            width: "15px"
        },
        { data: "no" },
        { data: "order_number" },
        { data: "money" },
        { data: "total" },
        { data: "change_money" },
        { data: "status" },
        { data: "option" }
    ],
    "columnDefs": [
        {   
            "targets": [0, 4],
            "orderable": false,
        }
    ],
    "createdRow": function(row, data, dataIndex){
        console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
        for(var i = 0; i < 8; i++) {
            if(i == 1 || (i >= 3 && i <= 5)) { 
                $('td:eq('+i+')', row).addClass('text-right'); 
            }
        }
    }
});

$(document).ready(function() {
    init();

    // event on click btn edit profil
    $('#btn-edit-profile').on('click', function() {
        // getProfile();
        setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
    });

    // event on click btn edit photo
    $('#btn-edit-photo').on('click', function() {
        setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
    });

    // event on click btn change password
    $('#btn-change-password').on('click', function() {
        setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
    });

    // event on submit edit profile
    $('#form-edit-profile').on('submit', function(e) {
        e.preventDefault();
        submitProfile();

        return false;
    });

    // event on submit edit photo
    $('#form-edit-photo').on('submit', function(e) {
        e.preventDefault();
        submitPhoto();

        return false;
    });

    // event on submit change password
    $('#form-change-password').on('submit', function(e) {
        e.preventDefault();
        submitChangePassword();

        return false;
    });
});

/**
 * 
 */
function init() {

}

/**
 * 
 */
function getView(id) {
    setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
}

/**
 * 
 */
function showForm(form) {
    if(form == 'edit-profile') {
        reset('edit-profile');
        $('#modal-edit-profile').modal({backdrop: 'static'});
    }
    else if(form == 'edit-photo') {
        reset('edit-photo');
        $('#modal-edit-photo').modal({backdrop: 'static'});
    }
    else if(form == 'change-password') {
        reset('change-password');
        $('#modal-change-password').modal({backdrop: 'static'});
    }
    else {
        setNotif({title: 'Message', message: 'Please try again', type: 'info'}, 'swal');
    }
}

/**
 * 
 */
function reset(form) {
    if(form == 'edit-profile') {
        
    }
    else if(form == 'edit-photo') {
        
    }
    else if(form == 'change-password') {
        
    }
    else {
        setNotif({title: 'Message', message: 'Please try again', type: 'warning'}, 'swal');
    }
}

/**
 * 
 */
function getProfile() {
    $.ajax({
        url: BASE_URL+'profile/edit/'+USER_ID,
        type: 'POST',
        dataType: 'JSON',
        data: {},
        beforeSend: function() {
            $('#btn-submit').prop('disabled', true);
        },
        success: function(response) {
            if(response.success) {
                $('#btn-submit').prop('disabled', false);
                showForm('edit-profile');
                setValue(response.data);
            }
            else { setNotif(response.notif, 'swal'); }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error getEdit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
            $('#btn-submit').prop('disabled', false);
            // $('#btn-submit').html($('#btn-submit').text());
            $('#modal-edit-profile').modal('hide');
        }
    });
}

/**
 * 
 */
function submitProfile() {

}

/**
 * 
 */
function submitPhoto() {

}

/**
 * 
 */
function submitChangePassword() {

}