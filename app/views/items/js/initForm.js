$(document).ready(function() {

    init();

	// event onclick btn add item
    $('#btn-add-item').on('click', function() {
        console.log("%cButton Add Item clicked...", "color: blue; font-style: italic");
        showFormItem('action-add');
    });

    // event onclick btn reset
    $('#btn-reset').on('click', function() {
        console.log("%cButton Reset clicked...", "color: blue; font-style: italic");
        reset();
    });

    // event on submit item
    $('#form-item').on('submit', function(e) {
        console.log("%cButton Submit Item clicked...", "color: blue; font-style: italic");
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
    
    $('#status').select2({
        placeholder: "Choose Status"
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
    
    setStatus();

    $('#btn-submit').val('action-add');
    $('#btn-submit').text('Add');
}

/**
 *
 */
function showFormItem(action) {
    reset();
    if(action == 'action-add') {
        $('#btn-submit').val('action-add');
        $('#btn-submit').text('Add');
        $('#image').parent().css('display', 'block');
    }
    else if(action == 'action-edit') {
        $('#btn-submit').val('action-edit');
        $('#btn-submit').text('Edit');
        $('#image').parent().css('display', 'none');
    }

    $('#modal-form-item').modal({backdrop: 'static'});
}

/**
 * 
 */
function getDataForm() {
    var data = new FormData();

    var price = ($('#price').inputmask) ? 
		( parseFloat($('#price').inputmask('unmaskedvalue')) ?
			parseFloat($('#price').inputmask('unmaskedvalue')) : 
			$('#price').inputmask('unmaskedvalue')
        ) : $('#price').val().trim();
    var status = ($('#status').val() != "" && $('#status').val() != null) ? $('#status').val().trim() : "";

    data.append('id', $('#id').val().trim());
    data.append('name', $('#name').val().trim());
    data.append('price', price);
    data.append('description', $('#description').val().trim());
    
    if($('#btn-submit').val().trim().toLowerCase() == "action-add") { data.append('image', $('#image')[0].files[0]); }

    data.append('status', status);
    data.append('action', $('#btn-submit').val().trim());

    return data;
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
            url: BASE_URL+'items/edit/'+id,
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
function submit() {
    var data = getDataForm();

    $.ajax({
        url: BASE_URL+'items/'+$('#btn-submit').val().trim()+'/',
		type: 'POST',
		dataType: 'json',
		data: data,
		contentType: false,
		cache :false,
		processData: false,
		beforeSend: function(){
            $('#btn-submit').prop('disabled', true);
            $('#btn-reset').prop('disabled', true);
			// $('#btn-submit').prepend('<i class="fa fa-spin fa-refresh"></i> ');
		},
		success: function(response) {
			console.log('%cResponse submit: ', 'font-weight: bold; color: green;', response);

            $('#btn-submit').prop('disabled', false);
            $('#btn-reset').prop('disabled', false);
			// $('#btn-submit').html($('#btn-submit').text());		

			if(!response.success) { setError(response.error); }
			else { 
                $('#modal-form-item').modal('hide');
                $("#table-item-list").DataTable().ajax.reload(); 
            }
            setNotif(response.notif, 'toastr');
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('%cResponse Error submit: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
            $('#btn-submit').prop('disabled', false);
            $('#btn-reset').prop('disabled', false);
            // $('#btn-submit').html($('#btn-submit').text());
            $('#modal-form-item').modal('hide');
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
function setValue(value) {
    $('#id').val(value.id);
    $('#name').val(value.name).trigger('change');
    $('#price').val(parseFloat(value.price)).trigger('change');
    $('#description').val(value.description).trigger('change');
    $('#status').val(value.status_id).trigger('change');
}

/**
 * 
 */
function reset() {
    $('#form-item').trigger('reset');
    $('.field').removeClass('is-invalid').removeClass('is-valid');
    $('.message').removeClass('valid-feedback').removeClass('invalid-feedback').text('');
    $('#status').val(null).trigger('change');
}