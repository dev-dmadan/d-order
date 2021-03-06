var table_order_history = $("#table-order-history").DataTable({
    // "responsive": true,
    "lengthMenu": [ 10, 25, 75, 100 ],
    "pageLength": 10,
    "order": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": BASE_URL+"orders/get-list-history/",
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
            "targets": [0, 1, 7],
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

    // event on click button show detail
    $('#table-order-history tbody').on('click', 'td.details-control', function () {
        onClickShowDetailDataTable(table_order_history, this);
    });

    // event on click refresh table
    $('#refreshTable').on('click', function() {
        refreshTable($(this), table_order_history);
    });

    // auto refresh every 1 minutes
    setInterval( function () {
        console.log('%cAutomatically refresh table..', 'color: blue; font-style: italic');
        table_order_history.ajax.reload(null, false);
    }, 60000 );

});

/**
 * 
 */
function onClickShowDetailDataTable(table, value) {
    var tr = $(value).closest('tr');
    var row = table.row(tr);

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child(showDetailDataTable(row.data())).show();
        tr.addClass('shown');
    }
}

/**
 * 
 * @param {*} data
 */
function showDetailDataTable(data) {
    var content = $('<div/>')
        .addClass( 'loading' )
        .text('Loading...');
 
    $.ajax({
        url: BASE_URL+'orders/get-list-detail/'+data.order_number.toLowerCase(),
        type: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function() {
            console.log("%cRequest showDetailDataTable Loading...", "color: blue; font-style: italic");
        },
        success: function(response) {
            console.log('%cResponse showDetailDataTable:', 'color: green; font-weight: green', response);
            if(response.success) {
                content.html(renderTableDetail(response.data)).removeClass('loading');
            }
            else {

            }
        }
    });
 
    return content;
}

/**
 * 
 */
function renderTableDetail(data) {
    var notes = '<div class="section-title">Notes</div>' + data.main.notes;
    var detail = 'Order doesnt have detail..';
    if(data.detail.length > 0) {
        detail = '<div class="section-title">Order Detail</div><div class="list-group">';
        $.each(data.detail, function(index, item) {
            detail += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                        '<h6 class="mb-1">' +item.order_item+ '</h6>' +
                        '<small class="text-muted"><span class="badge badge-primary badge-pill">' +item.qty+ '</span></small></div>' +
                        '<p class="mb-1">' +item.subtotal_full+ '</p></a>';
        });
        detail += '</div>';
    }

    return data.main.order_date_full + notes + detail;
}

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
    else{
        // setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
        window.location.href = BASE_URL+'orders/detail/'+id.toLowerCase();
    }
}

/**
 * 
 */
function getEdit(id, status) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };
    if(id == '' || id == undefined) { setNotif(notifError, 'swal'); }
    else{
        // setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
        if(status === 'PENDING') { window.location.href = BASE_URL+'orders/form/'+id.toLowerCase(); }
        else { setNotif(notifError, 'swal'); }
    }
}

/**
 * 
 */
function getDelete(id, status) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };
    if(id == '' || id == undefined) { setNotif(notifError, 'swal'); }
    else {
        if(status === 'PENDING' || status === 'REJECT') {
            swal({
                title: 'Are you sure?',
                text: '',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if(willDelete) {
                    actionDelete(id, function(response) {
                        if(response.success) { table_order_history.ajax.reload(); }
                        setNotif(response.notif, 'swal');
                    });
                }
            });
        }
        else { setNotif(notifError, 'swal'); }
    }
}

/**
 * 
 */
function actionDelete(id, callback) {
    $.ajax({
        url: BASE_URL+'orders/delete/'+id.toLowerCase(),
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