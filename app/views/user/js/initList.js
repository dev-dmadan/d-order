$(document).ready(function() {
    var table_user_list = $("#table-user-list").DataTable({
        // "responsive": true,
        "lengthMenu": [ 10, 25, 75, 100 ],
        "pageLength": 10,
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": BASE_URL+"user/get-list/",
            "type": 'POST',
            "data": {}
        },
        "columns": [
            { data: "no" },
            { data: "username" },
            { data: "name" },
            { data: "level" },
            { data: "status" },
            { data: "option" }
        ],
        "columnDefs": [
            {   
                "targets": [0, 5],
                "orderable": false,
            }
        ],
        "createdRow": function(row, data, dataIndex){
            console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
            for(var i = 0; i < 6; i++) {
                if(i == 0) { 
                    $('td:eq('+i+')', row).addClass('text-right'); 
                }
            }
        }
    });

    setStatus();
    
    // event on submit edit status
    $('#btn-submit').on('submit', function(e) {
        e.preventDefault();
        submit();
    });
});

/**
 * 
 */
function showFormUser(action = 'show') {
    reset();
    if(action == 'show') { $('#modal-edit-status').modal({backdrop: 'static'}); }
    else { $('#modal-edit-status').modal('hide') }
}

/**
 * 
 */
function getEdit(username) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };

    if(username == '' || username == undefined) { setNotif(notifError, 'swal'); }
    else {
        $.ajax({
            url: BASE_URL+'user/get-edit-status/'+username,
            type: 'post',
            dataType: 'json',
            data: {},
            beforeSend: function() {
            },
            success: function(response) {
                if(response.success) {
                    $('#status').val(response.data).trigger('change');
                    $('#username').val(username);
                    showFormUser();
                }
                else { setNotif(response.notif, 'swal'); }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('%cResponse Error actionEdit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
                var notif = {type: 'error', title: 'Error Message', message: 'Please try again'};
                setNotif(notif, 'swal');
                showFormUser('hide');
            }
        });
    }
}

/**
 * 
 */
function submit() {
    var status = ($('#status').val() != "" && $('#status').val() != null) ? $('#status').val().trim() : "";
    var data = {
        username: $('#username').val().trim(),
        status: status
    };
    $.ajax({
        url: BASE_URL+'user/action-edit-status/',
        type: 'get',
        dataType: 'json',
        data: data,
        beforeSend: function() {
        },
        success: function(response) {
            if(response.success) {
                setNotif(response.notif, 'swal');
                showFormUser('hide');
            }
            else { 
                setNotif(response.notif, 'toastr');
                setError(response.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error actionEdit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            var notif = {type: 'error', title: 'Error Message', message: 'Please try again'};
            setNotif(notif, 'swal');
            showFormUser('hide');
            callback({success: false, notif: notif});
        }
    });
}

/**
 * 
 */
function setStatus() {
    $.ajax({
        url: BASE_URL+'lookup/get-active-status-select',
        type: 'post',
        dataType: 'json',
        beforeSend: function() {},
        success: function(response) {
            console.log('%cResponse setStatus: ', 'color: blue; font-weight: bold', response);
            $.each(response, function(index, item){
				var newOption = new Option(item.text, item.id);
				$('#status').append(newOption);
			});
			$('#status').val(null).trigger('change');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error setMenu: ', 'color: red; font-weight: bold', jqXHR, textStatus, errorThrown);
            notif = {type: 'error', title: 'Error Message', message: 'Please try again'}
            setNotif(notif, 'swal');
        }
    });
}

/**
 * 
 */
function reset() {
    $('#form-user').trigger('reset');
    $('#status').val(null).trigger('change');
}