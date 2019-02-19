$(document).ready(function() {
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

    // event on click button show detail
    $('#table-order-list tbody').on('click', 'td.details-control', function () {
        onClickShowDetailDataTable(table_order_list, this);
    });

    $('#table-order-list tbody').on('click', 'td.show-detail', function () {
        onClickShowDetailDataTable(table_order_list, this);
    });

    // event on click view detail
    $()
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
    var action = '<div class="dropdown text-right">' +
        '<a href="#" data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle" aria-expanded="false">Action</a>' +
        '<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">' +
            '<a href="#" onclick="getView(\''+data.main.order_number+'\')" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View Detail</a>' +
            '<a href="#" id="btn-edit-order" class="dropdown-item has-icon"><i class="fas fa-edit"></i> Edit Order</a>' +
            '<div class="dropdown-divider"></div>' +
            '<a href="#" id="btn-success-order" class="dropdown-item has-icon text-success"><i class="fas fa-thumbs-up"></i> Complete Order</a>' +
        '</div>' +
    '</div>';

    var header = '<div class="section-title">Notes</div>' + data.main.notes;
    var footer = '<div class="section-title">Payment</div>' + 
            '<p><strong>Money</strong> ' +data.main.money_full+ '</p>' +
            '<p><strong>Total</strong> ' +data.main.total_full+ '</p>' +
            '<p><strong>Change Money</strong> ' +data.main.change_money_full+ '</p>';
    var detail = 'Order doesnt have detail..';
    if(data.detail.length > 0) {
        detail = '<div class="section-title">Order Detail</div><ul class="list-group list-group-flush detail-orders">';
        $.each(data.detail, function(index, item) {
            detail += '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        item.order_item + ' &mdash; ' + item.subtotal_full + 
                        '<span class="badge badge-primary badge-pill">' + item.qty + '</span>';
        });
        detail += '</ul>';
    }

    return action + header + detail + footer;
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
    console.log(id);
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