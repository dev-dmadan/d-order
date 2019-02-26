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

var statistic_chart = document.getElementById('myChart').getContext('2d');

$(document).ready(function() {
    init();

    // event on click button show detail
    $('#table-order-history tbody').on('click', 'td.details-control', function () {
        onClickShowDetailDataTable(table_order_history, this);
    });

    // event on click btn edit profil
    $('#btn-edit-profile').on('click', function() {
        getProfile();
    });

    $('#btn-reset-profile').on('click', function() {
        reset('edit-profile');
    });

    // event on click btn edit photo
    $('#btn-edit-photo').on('click', function() {
        $('#modal-edit-photo-profile').modal({backdrop: 'static'});
    });

    // event on click btn change password
    $('#btn-change-password').on('click', function() {
        $('#modal-change-password').modal({backdrop: 'static'});
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

    // event on click refresh table
    $('#refreshTable').on('click', function() {
        refreshTable($(this), table_order_history);
    });

    // auto refresh every 1 minutes
    setInterval( function () {
        console.log('%cAutomatically refresh table..', 'color: blue; font-style: italic');
        table_order_history.ajax.reload(null, false);
    }, 60000 );

    // event on click get week
    $('#get_week').on('click', function() {
        changeDataChart('week');
    });

    // event on click get month
    $('#get_month').on('click', function() {
        changeDataChart('month');
    });

});

/**
 * 
 */
function changeDataChart(action) {
    if(action == 'week') {
        $('#get_week').removeClass('btn-primary').addClass('btn-primary');
        $('#get_month').removeClass('btn-primary');
    }
    else if(action == 'month') {
        $('#get_month').removeClass('btn-primary').addClass('btn-primary');
        $('#get_week').removeClass('btn-primary');
    }

    getData_chart(action, function(response) {
        console.log(response);
        if(response.success) {
            loadChart(response.data);
        }
    });
}

/**
 * 
 */
function init() {
    getData_chart('week', function(response) {
        console.log(response);
        if(response.success) {
            loadChart(response.data);
        }
    });
}

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

/**
 * 
 */
function getData_chart(action, callback) {
    $.ajax({
        url: BASE_URL+'profile/get-chart/'+USER_ID,
        type: 'POST',
        dataType: 'JSON',
        data: {
            action: action
        },
        beforeSend: function() {
        },
        success: function(response) {
            callback(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('%cResponse Error getData_chart: ', 'font-weight: bold; color: red;', jqXHR, textStatus, errorThrown);
            setNotif({type: 'error', title: 'Error Message', message: 'Please try again'}, 'swal');
            callback({success: false});
        }
    });
}

/**
 * 
 */
function loadChart(data) {
    var myChart = new Chart(statistic_chart, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Amount Spend',
                data: data.datasets.data,
                borderWidth: 5,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                   label: function(t, d) {
                      var yLabel = t.yLabel >= 1000 ? 'Rp ' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp ' + t.yLabel;
                      return yLabel;
                   }
                }
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            if(parseInt(value) >= 1000) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                            else { return value; }
                        },
                        stepSize: data.steps
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            }
        }
    });
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
        url: BASE_URL+'profile/get-edit-profile/'+USER_ID,
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
                $('#name').val(response.data.name);
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