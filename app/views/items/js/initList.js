var table_item_list = $("#table-item-list").DataTable({
    // "responsive": true,
    "lengthMenu": [ 10, 25, 75, 100 ],
    "pageLength": 10,
    "order": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": BASE_URL+"items/get-list/",
        "type": 'POST',
        "data": {}
    },
    "columns": [
        { data: "no" },
        { data: "name" },
        { data: "price" },
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
        for(var i = 0; i < 5; i++) {
            if(i == 0 || i == 2) { 
                $('td:eq('+i+')', row).addClass('text-right'); 
            }
        }
    }
});

$(document).ready(function() {

    // event on click refresh table
    $('#refreshTable').on('click', function() {
        refreshTable($(this), table_item_list);
    });
    
});

/**
 * 
 */
function getView(id) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };
    if(id == '' || id == undefined) { setNotif(notifError, 'swal'); }
    else {
        // setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
        $.ajax({
            url: BASE_URL+'items/get-detail/'+id,
            type: 'post',
            dataType: 'json',
            data: {},
            beforeSend: function() {
            },
            success: function(response) {
                console.log("%cResponse getView: ", "color: green; font-weight: bold", response);
                if(response.success) {
                    setView(response.data);
                }
                else {
                    setNotif(response.notif, 'swal');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('%cResponse Error actionDelete: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
                setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
            }
        });
    }
}

/**
 * 
 */
function setView(data) {
    $('#item_image').attr('src', data.image);
    $('#item_price').html(data.price);
    $('.item-name').html(data.name);
    $('.item-status').html(data.status_name);
    $('#item_description').html(data.description);
    $('#modal-view-item').modal({backdrop: 'static'});
}

/**
 * 
 */
function getDelete(id) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };
    if(id == '' || id == undefined) { setNotif(notifError, 'swal'); }
    else {
        swal({
            title: 'Are you sure?',
            text: '',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if(willDelete) {
                actionDelete(id, function(response) {
                    if(response.success) { $("#table-item-list").DataTable().ajax.reload(); }
                    setNotif(response.notif, 'swal');
                })
            }
        });
    }
}

/**
 * 
 */
function actionDelete(id, callback) {
    $.ajax({
        url: BASE_URL+'items/delete/'+id,
        type: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function() {
        },
        success: function(response) {
            console.log("%cResponse getDelete: ", "color: green; font-weight: bold", response);
            callback(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error actionDelete: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
        }
    });
}