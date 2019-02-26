let listDetail = [];
let indexDetail = 0;
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
            data: "name", 
            render: function(data) {
                var split = data.split('|');
                // console.log(split);
                return '<img alt="image" src="'+split[1]+'" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="'+split[0]+'"><p class="text-danger"><strong>'+split[0]+'</strong></p>';
            }
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

    // event on click refresh table
    $('#refreshTable').on('click', function() {
        refreshTable($(this), table_order_list);
    });

    // submit
    $('#form-edit-order').on('submit', function(e) {
        e.preventDefault();
        submit();

        return false;
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

    var payment = '<div class="section-title">Payment</div>' + '<div class="list-group">' + money + total + change_money + '</div>';
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

    return data.main.order_date_full + action + notes + detail + payment;
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
                button += '<a href="#" onclick="setStatus(\''+order_number+'\', \'process\')" class="dropdown-item has-icon"><i class="fas fa-truck"></i> Process Order</a>' + 
                        '<a href="#" onclick="setStatus(\''+order_number+'\', \'reject\')" class="dropdown-item has-icon text-danger"><i class="fas fa-times-circle"></i> Reject Order</a>';
                button += '</div></div>';
                break;
            case 'PROCESS':
                button += '<a href="#" onclick="getEdit(\''+order_number+'\')" class="dropdown-item has-icon text-primary"><i class="fas fa-edit"></i> Edit Order</a>' +
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
    $('#modal-status-order').modal({backdrop: 'static'});
}

/**
 * 
 */
function setValue(value) {
    var detail = '';
    listDetail = [];
    indexDetail = 0;

    $('#order_number').val(value.main.order_number);
    $('#money').val(parseFloat(value.main.money));

    $.each(value.detail, function(index, item) {
        var index = indexDetail++;
        var temp = {
            index: index,
            id: item.id,
            order_number: item.order_number,
            item: item.item_id,
            order_item: item.order_item,
            price: item.price_item,
            qty: item.qty,
            subtotal: item.subtotal
        };
        listDetail.push(temp);
        detail += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start">' +
                '<div class="d-flex w-100 justify-content-between">' +
                '<h6 class="mb-1">' +item.order_item+ '</h6></div>' +
                renderInputPriceQty(item, index) +
                '<p class="mb-1 field-subtotal">' +item.subtotal_full+ '</p></a>';
    });

    $('.detail-orders').html(detail).text();
    console.log('List Detail: ', listDetail);
}

/**
 * 
 */
function renderInputPriceQty(data, index) { 
    let input = '<div class="form-group">' +
                '<div class="input-group">' +
                '<input onchange="onChangePrice(\''+index+'\', this)" type="number" class="form-control field" value='+parseFloat(data.price_item)+'>' +
                '<input onchange="onChangeQty(\''+index+'\', this)" type="number" class="form-control field" value='+data.qty+' min="1">' +
                '</div></div>';          

    return input;
}

/**
 * 
 */
function onChangePrice(index, scope) {
    console.log('onChange Price: ', {index: index, this: scope});
    listDetail[index].price_item = scope.value;
    listDetail[index].subtotal = parseFloat(scope.value) * parseFloat(listDetail[index].qty);
    setRupiah(listDetail[index].subtotal, function(response) {
        scope.parentNode.parentNode.parentNode.getElementsByClassName('field-subtotal')[0].innerHTML = response;
    });
    console.log('Update listDetail: ', listDetail);
}

/**
 * 
 */
function onChangeQty(index, scope) {
    console.log('onChange Qty: ', {index: index, this: scope});
    listDetail[index].qty = scope.value;
    listDetail[index].subtotal = parseFloat(scope.value) * parseFloat(listDetail[index].price);
    setRupiah(listDetail[index].subtotal, function(response) {
        console.log(response);
        scope.parentNode.parentNode.parentNode.getElementsByClassName('field-subtotal')[0].innerHTML = response;
    });
    console.log('Update listDetail: ', listDetail);
}

/**
 * 
 */
function setRupiah(value, callback) {
    $.ajax({
        url: BASE_URL+'orders/set-rupiah/'+value,
        type: 'get',
        dataType: 'json',
        beforeSend: function() {},
        success: function(response) {
            console.log('%cResponse setRupiah: ', 'color: blue; font-weight: bold', response);
			callback(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error setRupiah: ', 'color: red; font-weight: bold', jqXHR, textStatus, errorThrown);
            notif = {type: 'error', title: 'Error Message', message: 'Please try again'}
            setNotif(notif, 'swal');
        }
    });
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
            url: BASE_URL+'orders/get-list-detail/'+id.toLowerCase(),
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
                    showFormItem();
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
                        console.log('%cResponse setStatus: ', 'font-weight: bold; color: green;', response);
                        if(response.success) {
                            table_order_list.ajax.reload();
                            setNotif(response.notif, 'toastr');
                        }
                        else {
                            setNotif(response.notif, 'swal');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('%cResponse Error setStatus: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
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
    console.log('List Detail Submit: ', listDetail);
    var data = {
        order: {
            order_number: $('#order_number').val().trim(),
            money: $('#money').val().trim()
        },
        detail: JSON.stringify(listDetail)
    };
	$.ajax({
		url: BASE_URL+'orders/action-edit-orders',
		type: 'POST',
		dataType: 'json',
		data: data,
		beforeSend: function() {
            $('#btn-submit-edit-order').addClass('disabled btn-progress');
            $('.detail-orders input').prop('disabled', true);
		},
		success: function(response) {
			console.log('%cResponse submit: ', 'font-weight: bold; color: green;', response);

            $('#btn-submit-edit-order').removeClass('disabled btn-progress');
            $('.detail-orders input').prop('disabled', false);

            if(response.success) {
                setNotif(response.notif, 'toastr');
                $('#modal-status-order').modal('hide');
                table_order_list.ajax.reload();
            }
            else { setNotif(response.notif, 'swal'); }
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('%cResponse Error submit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
            $('#btn-submit-edit-order').removeClass('disabled btn-progress');
            $('.detail-orders input').prop('disabled', false);
		}

	});
}