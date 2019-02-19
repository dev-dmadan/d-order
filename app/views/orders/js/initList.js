var table_order_list = $("#table-order-list").DataTable({
    // "responsive": true,
    "lengthMenu": [ 10, 25, 75, 100 ],
    "pageLength": 10,
    "order": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": BASE_URL+"orders/get-list/",
        "type": 'POST',
        "data": {}
    },
    "columns": [
        {
            className: 'details-control',
            orderable: false,
            data: "order_number",
            defaultContent: '',
            render: function () {
                return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
            },
            width: "15px"
        },
        { 
            className: 'show-detail', 
            data: "name" 
        },
        { 
            className: 'show-detail', 
            data: "status", 
            render: function (data) { 
                var status = '';
                switch (data) {
                    case 'PENDING':
                        status = '<div class="badge badge-primary">' +data+ '</di>';
                        break;
                    case 'PROCESS':
                        status = '<div class="badge badge-info">' +data+ '</di>';
                        break;
                    case 'REJECT':
                        status = '<div class="badge badge-danger">' +data+ '</di>';
                        break;
                    case 'DONE':
                        status = '<div class="badge badge-success">' +data+ '</di>';
                        break;
                }

                return status;
            }
        }
    ],
    "columnDefs": [
        {   
            "targets": [0],
            "orderable": false,
        }
    ],
    "createdRow": function(row, data, dataIndex){
        console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
        for(var i = 0; i < 3; i++) {
            if(i > 0 && i < 3) { 
                $('td:eq('+i+')', row).addClass('text-center'); 
            }
        }
    }
});

$(document).ready(function() {

    // event on click button show detail
    $('#table-order-list tbody').on('click', 'td.details-control', function () {
        onClickShowDetailDataTable(table_order_list, this);
    });

    $('#table-order-list tbody').on('click', 'td.show-detail', function () {
        onClickShowDetailDataTable(table_order_list, this);
    });

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
        url: BASE_URL+'orders/get-list-detail/',
        type: 'get',
        dataType: 'json',
        data: {
            order_number: data.order_number
        },
        beforeSend: function() {
            console.log("%cRequest showDetailDataTable Loading...", "color: blue; font-style: italic");
        },
        success: function(response) {
            console.log('%cResponse showDetailDataTable:', 'color: green; font-weight: green', response);
            if(response.success) {
                content.html(renderTableDetail(response.data)).removeClass('loading').text();
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
    var action = renderButtonAction(data.main.status_name, data.main.order_number);

    var notes = '<div class="section-title">Notes</div>' + data.main.notes;
    var money =   '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                    '<div class="d-flex w-100 justify-content-between">' +
                    '<h6 class="mb-1">Money</h6></div>' +
                    '<p class="mb-1">' +data.main.money_full+ '</p></a>';
    var total = '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                    '<div class="d-flex w-100 justify-content-between">' +
                    '<h6 class="mb-1">Total</h6></div>' +
                    '<p class="mb-1">' +data.main.total_full+ '</p></a>';
    var change_money = '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                    '<div class="d-flex w-100 justify-content-between">' +
                    '<h6 class="mb-1">Change Money</h6></div>' +
                    '<p class="mb-1">' +data.main.change_money_full+ '</p></a>';

    var payment = '<div class="section-title">Payment</div>' + '<div class="list-group detail-orders">' + money + total + change_money + '</div>';
    var detail = 'Order doesnt have detail..';
    if(data.detail.length > 0) {
        detail = '<div class="section-title">Order Detail</div><div class="list-group detail-orders">';
        $.each(data.detail, function(index, item) {
            detail += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                        '<h6 class="mb-1">' +item.order_item+ '</h6>' +
                        '<small class="text-muted"><span class="badge badge-primary badge-pill">' +item.qty+ '</span></small></div>' +
                        '<p class="mb-1">' +item.subtotal_full+ '</p></a>';
        });
        detail += '</div>';
    }

    return action + notes + detail + payment;
}

/**
 * 
 */
function renderButtonAction(status, order_number) {
    let button = '<div class="dropdown text-right">' +
        '<a href="#" data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle" aria-expanded="false">Action</a>' +
        '<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">';

        switch (status) {
            case 'PENDING':
                button += '<a href="#" onclick="setStatus(\''+order_number+'\', \'process\')" class="dropdown-item has-icon"><i class="fas fa-truck"></i> Process Order</a>';
                button += '</div></div>';
                break;
            case 'PROCESS':
                button += '<a href="#" onclick="getEdit(\''+order_number+'\')" class="dropdown-item has-icon text-primary"><i class="fas fa-edit"></i> Edit Order</a>' +
                    '<a href="#" onclick="setStatus(\''+order_number+'\', \'process\')" class="dropdown-item has-icon"><i class="fas fa-truck"></i> Process Order</a>' +
                    '<a href="#" onclick="setStatus(\''+order_number+'\', \'reject\')" class="dropdown-item has-icon text-danger"><i class="fas fa-times-circle"></i> Reject Order</a>' +
                    '<div class="dropdown-divider"></div>' +
                    '<a href="#" onclick="setStatus(\''+order_number+'\', \'done\')" class="dropdown-item has-icon text-success"><i class="fas fa-thumbs-up"></i> Complete Order</a>';
                button += '</div></div>';
                break;
            case 'REJECT':
            case 'DONE':
                button = '';
                break;
        }

    return button;
}

/**
 * 
 */
function showFormItem() {
    reset();
    $('#modal-status-order').modal({backdrop: 'static'});
}

/**
 * 
 */
function setValue(value) {
    $('#order_number').text(value.orders.order_number);
    $('#name').text(value.orders.user_name);
    $('#money').text(value.orders.money);
    $('#status_name').text(value.orders.status_name);
    $('#status_id').val(value.orders.status_id);

    var detail = '';

    $.each(value.detail, function(index, item) {
        detail += '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                item.order_item + ' &mdash; ' + item.subtotal + 
                '<span class="badge badge-primary badge-pill">' + item.qty + '</span>';
    });

    $('.detail-orders').html(detail).text();
}

/**
 * 
 */
function getEdit(id) {
    var notifError = {
        title: 'Error Message',
        message: 'Access Denied',
        type: 'error'
    };
    if(id == '' || id == undefined) { setNotif(notifError, 'swal'); }
    else {
        $.ajax({
            url: BASE_URL+'orders/edit/'+id.toLowerCase(),
            type: 'POST',
            dataType: 'JSON',
            data: {},
            beforeSend: function() {
                $('#btn-submit').prop('disabled', true);
                $('#btn-reset').prop('disabled', true);
            },
            success: function(response) {
                console.log('%cResponse getEdit: ', 'font-weight: bold; color: green;', response);
                if(response.success) {
                    $('#btn-submit').prop('disabled', false);
                    $('#btn-reset').prop('disabled', false);
                    showFormItem('action-edit');
                    setValue(response.data);
                }
                else {
                    setNotif(response.notif, 'swal');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('%cResponse Error getEdit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
                setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
                $('#btn-submit').prop('disabled', false);
                $('#btn-reset').prop('disabled', false);
                // $('#btn-submit').html($('#btn-submit').text());
                $('#modal-form-item').modal('hide');
            }
        });
    }
}

/**
 * 
 */
function getView(id) {
    
}

/**
 * 
 */
function setStatus(id, status) {
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
        }).then((response) => {
            if(response) {
                $.ajax({
                    url: BASE_URL+'orders/set-status/'+id.toLowerCase(),
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        status: status.toUpperCase()
                    },
                    beforeSend: function() {
                    },
                    success: function(response) {
                        console.log('%cResponse setDone: ', 'font-weight: bold; color: green;', response);
                        if(response.success) {
                            table_order_list.ajax.reload();
                            setNotif(response.notif, 'toastr');
                        }
                        else {
                            setNotif(response.notif, 'swal');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('%cResponse Error setDone: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
                        setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
                    }
                });
            }
        });
    }
}

/**
 * 
 */
function submit() {

}

/**
 * 
 */
function reset() {

}