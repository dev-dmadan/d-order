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

    // auto refresh every 1 minutes
    setInterval( function () {
        console.log('%cAutomatically refresh table..', 'color: blue; font-style: italic');
        table_item_list.ajax.reload(null, false);
    }, 60000 );
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
        $('#modal-view-item').modal({backdrop: 'static'});
    }
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