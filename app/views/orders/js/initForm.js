var indexDetail = 0;
var listDetail = [];

$(document).ready(function() {
    var table_detail_order = $("#table-order-detail").DataTable({
        "responsive": true,
        "searching": false,
        "info": false,
        "columns": [
            {"data": "no"},
            {"data": "order_item"},
            {"data": "price_full"},
            {"data": "qty"},
            {"data": "subtotal_full"},
            {"data": "option"},
        ],
        "order": [],
        "columnDefs": [
            {
                "targets":[0, 5],
                "orderable":false,
            }
        ],
        createdRow: function(row, data, dataIndex){
            console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
            for(var i = 0; i < 6; i++) {
                if(i == 0 || i == 2 || i == 3 || i == 4) { 
                    $('td:eq('+i+')', row).addClass('text-right'); 
                }
            }
        }
    });

    init();

    // event onkeyup money
    $('#money').on('keyup', function() {
        onKeyUpMoney();
    });

    // event onclick btn add detail
    $('#btn-add-order').on('click', function() {
        console.log("%cButton Add Order clicked...", "color: blue; font-style: italic");
        showFormOrder('action-add');
    });

    // event onclick btn show menu
    $('#btn-show-menu').on('click', function() {
        console.log("%cButton Show Menu clicked...", "color: blue; font-style: italic");
        // showMenu();
        setNotif({title: 'Message', message: 'Sorry, this feature still development :D', type: 'info'}, 'swal');
    });

    // event onchange menu
    $('#menu').on('change', function() {
        console.log('%cField Menu OnChange: ', 'color: blue; font-style: italic', $(this).val());
        if(this.value !== "" && this.value != null) {
            onChangeMenu($(this).val(), $(this).children("option").filter(":selected").text());
        }
    });

    // event onsubmit form add order
    $('#form-order-detail').on('submit', function(e) {
        console.log("%cButton Submit Order Detail clicked...", "color: blue; font-style: italic");
        e.preventDefault();
        if($('#btn-submit-add-order').val() == 'action-add') { addOrder(); }
        else if($('#btn-submit-add-order').val() == 'action-edit') { editDetail(); }

        return false;
    });

    // event on click reset button
    $('#btn-reset').on('click', function() {
        swal({
            title: 'Are you sure?',
            text: '',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((ok) => {
            if(ok) {
                reset();
            }
        });
    });

    // event on submit order
    $('#form-order').on('submit', function(e) {
        console.log("%cButton Submit Order clicked...", "color: blue; font-style: italic");
        e.preventDefault();
        submit();

		return false;
    });

    // event on change field
    $('.field').on('change', function(){
        onChangeField(this);
	});
});

/**
 * 
 */
function init() {
    console.log('%cFunction init run...', 'color: blue; font-style: blue');

    $('#menu').select2({
    	placeholder: "Choose Menu"
    });
    
    $('.input-mask-money').inputmask({ 
		alias : 'currency',
		prefix: '', 
		radixPoint: ',',
		digits: 0,
		groupSeparator: '.', 
		clearMaskOnLostFocus: true, 
		digitsOptional: false,
    });
    
    $('#btn-submit-add-order').val('action-add');
    $('#btn-submit-add-order').text('Add');
    
    setMenu();
    if($('#btn-submit').val() == 'action-edit') {
        getEdit($('#order_number').val().trim());
        $('#btn-submit').text('Edit Order');
    }
}

/**
 * 
 */
function onKeyUpMoney() {
    var money = ($('#money').inputmask) ? 
            ( parseFloat($('#money').inputmask('unmaskedvalue')) ?
                parseFloat($('#money').inputmask('unmaskedvalue')) : 
                $('#money').inputmask('unmaskedvalue')
            ) : $('#money').val().trim();

    var change_money = parseFloat(money)-parseFloat($('#total').val().trim());

    setRupiah(money, 'text_money');
    setRupiah(change_money, 'text_change_money');
}

/**
 * 
 */
function setRupiah(value, text) {
    $.ajax({
        url: BASE_URL+'orders/set-rupiah/'+value,
        type: 'get',
        dataType: 'json',
        beforeSend: function() {},
        success: function(response) {
            console.log('%cResponse setRupiah: ', 'color: blue; font-weight: bold', response);
			$('#'+text).text(response);
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
function showFormOrder(action = 'action-add') {
    resetFormOrder();
    $('#price').prop('readonly', true);
    if(action == 'action-add') {
        $('#btn-submit-add-order').val('action-add');
        $('#btn-submit-add-order').text('Add');
        $('#menu_name').parent().css('display', 'none');
    }
    else if(action == 'action-edit') {
        $('#btn-submit-add-order').val('action-edit');
        $('#btn-submit-add-order').text('Edit');
    }

    $('#modal-order-detail').modal({backdrop: 'static'});
}

/**
 * 
 */
function showMenu() {
    $('#modal-show-menu').modal({backdrop: 'static'});
}

/**
 * 
 */
function onChangeMenu(id, text) {
    if(text.toLowerCase() == 'others') { 
        $('#menu_name').val('');
        $('#menu_name').parent().css('display', 'block');
        $('#price').val(0);
        $('#price').prop('readonly', false); 
    }
    else {
        $('#menu_name').val(text);
        $('#menu_name').parent().css('display', 'none');
        $('#price').prop('readonly', true);
        setPrice(id);
    }
}

/**
 * 
 */
function setMenu() {
    $.ajax({
        url: BASE_URL+'items/get-menu-select',
        type: 'post',
        dataType: 'json',
        beforeSend: function() {},
        success: function(response) {
            response.push({id: '0', text: 'Others'})
            console.log('%cResponse setMenu: ', 'color: blue; font-weight: bold', response);
            $.each(response, function(index, item){
				var newOption = new Option(item.text, item.id);
				$('#menu').append(newOption);
			});
			$('#menu').val(null).trigger('change');
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
function setPrice(id) {
    $.ajax({
        url: BASE_URL+'items/get-price',
        type: 'get',
        data: {id: id},
        dataType: 'json',
        beforeSend: function() {},
        success: function(response) {
            console.log('%cResponse setPrice: ', 'color: blue; font-weight: bold', response);
            if(response.success) {
                $('#price').val(response.data).trigger('change');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error setPrice: ', 'color: red; font-weight: bold', jqXHR, textStatus, errorThrown);
            notif = {type: 'error', title: 'Error Message', message: 'Please try again'}
            setNotif(notif, 'swal');
        }
    });
}

/**
 * 
 */
function addOrder() {
    var index = indexDetail++;
    var menu = ($('#menu').val() != "" && $('#menu').val() != null) ? $('#menu').val().trim() : "";
    var price = ($('#price').inputmask) ? 
        ( parseFloat($('#price').inputmask('unmaskedvalue')) ?
            parseFloat($('#price').inputmask('unmaskedvalue')) : 
            $('#price').inputmask('unmaskedvalue')
        ) : $('#price').val().trim();
    var subtotal = price * $('#qty').val();
    
    var data = {
        index: index,
        id: '',
        order_id: $('#order_number').val().trim(),
        item: menu,
        order_item: $('#menu_name').val().trim(),
        price: price,
        price_full: '',
        qty: $('#qty').val(),
        subtotal: subtotal,
        subtotal_full: '',
        action: 'add',
        delete: false
    };

    console.log('%cResponse addOrder: ', 'color: green; font-weight: bold', 
        {
            index: index,
            indexDetail: indexDetail,
            data: data,
            listDetail: listDetail
        }
    );

    if(checkDuplicate(data.order_item)) { 
        indexDetail -= 1;
        setNotif({type: 'warning', title: 'Warning message', message: 'You have add this menu before'}, 'swal');
    }
    else { validDetail(data); }
}

/**
 * 
 */
function validDetail(data, action = 'action-add') {
    $.ajax({
        url: BASE_URL+'orders/action-add-detail/',
        type: 'post',
        dataType: 'json',
        data: data,
        beforeSend: function(){
        },
        success: function(response) {
            console.log('%cResponse validDetail: ', 'color: green; font-weight: bold', response);
            if(action == 'action-add') {
                if(response.success) {
                    listDetail.push(response.data);
                    var total = sum_subtotal(listDetail);
                    var money = ($('#money').inputmask) ? 
                        ( parseFloat($('#money').inputmask('unmaskedvalue')) ?
                            parseFloat($('#money').inputmask('unmaskedvalue')) : 
                            $('#money').inputmask('unmaskedvalue')
                        ) : $('#money').val().trim(); 
                    var change_money = parseFloat(money)-total;

                    $('#total').val(total);
                    $('#change_money').val(change_money);

                    setRupiah(total, 'text_total');
                    setRupiah(change_money, 'text_change_money');
                    renderTableDetail(listDetail);
                    $('#modal-order-detail').modal('hide');
                    resetFormOrder();
                }
                else {
                    indexDetail -= 1;
                    setError(response.error);
                }
            }
            else if(action == 'action-edit') {
                if(response.success) {
                    listDetail[data.index].item = data.item;
                    listDetail[data.index].order_item = data.order_item;
                    listDetail[data.index].price = data.price;
                    listDetail[data.index].price_full = response.data.price_full;
                    listDetail[data.index].qty = data.qty;
                    listDetail[data.index].subtotal = data.subtotal;
                    listDetail[data.index].subtotal_full = response.data.subtotal_full;
                    listDetail[data.index].action = data.action;

                    var total = sum_subtotal(listDetail);
                    var money = ($('#money').inputmask) ? 
                        ( parseFloat($('#money').inputmask('unmaskedvalue')) ?
                            parseFloat($('#money').inputmask('unmaskedvalue')) : 
                            $('#money').inputmask('unmaskedvalue')
                        ) : $('#money').val().trim(); 
                    var change_money = parseFloat(money)-total;

                    $('#total').val(total);
                    $('#change_money').val(change_money);

                    setRupiah(total, 'text_total');
                    setRupiah(change_money, 'text_change_money');
                    renderTableDetail(listDetail);
                    $('#modal-order-detail').modal('hide');
                    resetFormOrder();
                }
                else { setError(response.error); }
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            console.log('%cResponse Error validDetail: ', 'font-style: italic; color: red', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
        }
    });
}

/**
 * 
 */
function checkDuplicate(data) {
    var ada = false;

    $.each(listDetail, function(index, item){
        if(data.toLowerCase() == item.order_item.toLowerCase() && !item.delete) { ada = true; }
    });

    return ada;
}

/**
 * 
 */
function renderTableDetail(data) {
    var table = $("#table-order-detail").DataTable();
    
    // hapus semua data di table
    table.clear().draw();

    var i = 0;

    // render ulang
    $.each(data, function(index, item) {
        if(!item.delete) {
            var temp = item;
            i++;
            temp.no = i;
            temp.option = btnAction_detail(item.index);
            table.row.add(temp).draw();
        }
    });
    table.responsive.recalc();
}

/**
 * 
 */
function btnAction_detail(index) {
    var btnEdit = '<button type="button" class="btn btn-success btn-sm"'+
                ' title="Edit detail" onclick="get_edit_detail('+index+')">'+
                '<i class="fa fa-edit"></i></button>';
    var btnDelete = '<button type="button" class="btn btn-danger btn-sm"'+
                ' title="Delete item from detail" onclick="delete_detail('+index+', this)">'+
                '<i class="fa fa-trash"></i></button>';

    var btn = '<div class="btn-group">'+btnEdit+btnDelete+'</div>';
    return btn;
}

/**
 * 
 */
function get_edit_detail(index) {
    console.log('%cButton edit detail is clicked..', 'font-style: italic');
    
    var data = listDetail[index];
    showFormOrder('action-edit');
    setValue(data);
}

/**
 * 
 */
function editDetail() {
    var action = ($('#btn-submit-add-order').val() == 'action-add') ? 'add' : 'edit';
    var menu = ($('#menu').val() != "" && $('#menu').val() != null) ? $('#menu').val().trim() : "";
    var price = ($('#price').inputmask) ? 
			( parseFloat($('#price').inputmask('unmaskedvalue')) ?
				parseFloat($('#price').inputmask('unmaskedvalue')) : 
				$('#price').inputmask('unmaskedvalue')
			) : $('#price').val().trim();
    var subtotal = price * $('#qty').val();
            
    var data = {
        index: $('#index_detail').val().trim(),
        id: $('#detailId').val().trim(),
        order_id: $('#order_number').val().trim(),
        item: menu,
        order_item: $('#menu_name').val().trim(),
        price: price,
        price_full: '',
        qty: $('#qty').val(),
        subtotal: subtotal,
        subtotal_full: '',
        action: action,
        delete: false
    };

    validDetail(data, 'action-edit');
}

/**
 * 
 */
function setValue(value) {
    $('#index_detail').val(value.index);
    $('#detailId').val(value.id);
    $('#menu').val(value.item).trigger('change');
    $('#menu_name').val(value.order_item).trigger('change');
    $('#price').val(value.price).trigger('change');
    $('#qty').val(value.qty).trigger('change');
}

/**
 * 
 */
function delete_detail(index, value) {
    console.log('%cButton delete detail is clicked..', 'font-style: italic');
    swal({
        title: 'Are you sure?',
        text: '',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if(willDelete) {
            listDetail[index].delete = true;

            var total = sum_subtotal(listDetail);
            var money = ($('#money').inputmask) ? 
                ( parseFloat($('#money').inputmask('unmaskedvalue')) ?
                    parseFloat($('#money').inputmask('unmaskedvalue')) : 
                    $('#money').inputmask('unmaskedvalue')
                ) : $('#money').val().trim(); 
            var change_money = parseFloat(money)-total;

            $('#total').val(total);
            $('#change_money').val(change_money);

            setRupiah(total, 'text_total');
            setRupiah(change_money, 'text_change_money');
            renderTableDetail(listDetail);
            
            console.log('%cDetail Deleted', 'font-style: italic');
        }
    });
}

/**
 * 
 */
function resetFormOrder() {
    $('#form-order-detail').trigger('reset');
    $('#menu').val(null).trigger('change');

    $('#form-order-detail .field').removeClass('is-invalid').removeClass('is-valid');
    $('#form-order-detail .message').removeClass('valid-feedback').removeClass('invalid-feedback').addClass('invalid-feedback').text('');
}

/**
 * 
 */
function sum_subtotal(listDetail) {
    var total = 0;
    $.each(listDetail, function(index, item) {
        if(!item.delete) {
            total += parseFloat(item.subtotal);
        }
    });

    return total;
}

/**
 * 
 */
function getDataForm() {
    var data = new FormData();

	var money = ($('#money').inputmask) ? 
		( parseFloat($('#money').inputmask('unmaskedvalue')) ?
			parseFloat($('#money').inputmask('unmaskedvalue')) : 
			$('#money').inputmask('unmaskedvalue')
		) : $('#money').val().trim();

	var dataOrder = {
        id: $('#order_number').val().trim(),
		date: $('#order_date').val().trim(),
		money: money,
        notes: $('#notes').val().trim(),
        change_money: $('#change_money').val().trim(),
        total: $('#total').val().trim(),
        status: $('#status').val().trim()
	}

	data.append('id', $('#order_number').val().trim());
	data.append('dataOrder', JSON.stringify(dataOrder));
	data.append('dataDetail', JSON.stringify(listDetail));
	data.append('action', $('#btn-submit').val().trim());

	return data;
}

/**
 * 
 */
function submit() {
    var data = getDataForm();

	$.ajax({
		url: BASE_URL+'orders/'+$('#btn-submit').val().trim()+'/',
		type: 'POST',
		dataType: 'json',
		data: data,
		contentType: false,
		cache :false,
		processData: false,
		beforeSend: function() {
			$('#btn-submit').prop('disabled', true);
			$('#btn-submit').prepend('<i class="fa fa-spin fa-refresh"></i> ');
		},
		success: function(response) {
			console.log('%cResponse submit: ', 'font-weight: bold; color: green;', response);

			$('#btn-submit').prop('disabled', false);
			$('#btn-submit').html($('#btn-submit').text());

			if(!response.cek.order_detail) { setNotif(response.notif.order_detail, 'toastr'); }			

			if(!response.success) {
                setError(response.error);
                var type;
                if(response.notif.order.type == 'error') { type = 'swal'; }
                else { type = 'toastr'; } 

                setNotif(response.notif.order, type);
			}
			else { 
                if(LEVEL == 'ADMIN') { window.location.href = BASE_URL; }
                else { window.location.href = BASE_URL+'orders/history'; } 
            }
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('%cResponse Error submit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
			$('#btn-submit').prop('disabled', false);
			$('#btn-submit').html($('#btn-submit').text());
		}

	});
}

/**
 * 
 */
function getEdit(id) {
    $.ajax({
        url: BASE_URL+'orders/get-edit/'+id.toLowerCase(),
        type: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function() {
        },
        success: function(response) {
            console.log("%cResponse getEdit: ", "color: green; font-weight: bold", response);
            if(response.success) {
                $.each(response.data, function(i, data) {
                    var index = indexDetail++;
                    var item = (data.item_id == null || data.item_id == '') ? '0' : data.item_id;
                    var dataDetail = {
                        index: index,
                        id: data.id,
                        order_id: data.order_number,
                        item: item,
                        order_item: data.order_item,
                        price: data.price_item,
                        price_full: data.price_full,
                        qty: data.qty,
                        subtotal: data.subtotal,
                        subtotal_full: data.subtotal_full,
                        action: 'edit',
                        delete: false
                    }
                    listDetail.push(dataDetail);
                });
                renderTableDetail(listDetail);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error getEdit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
        }
    });
}

/**
 * 
 */
function resetForm() {
    var order_number = $('#order_number').val();
    var order_date = $('#order_date').val();
    $('#order-form').trigger('reset');
    $('.message').removeClass('valid-feedback').removeClass('invalid-feedback').text('');
    $('#order_number').val(order_number);
    $('#order_date').val(order_date);
}

/**
 * 
 */
function reset() {
    resetForm();
    resetFormOrder();
    $('#table-order-detail tbody tr').remove();
    indexDetail = 0;
    listDetail = [];
}