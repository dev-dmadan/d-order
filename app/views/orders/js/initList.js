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
                data: null,
                defaultContent: '',
                render: function () {
                    return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                },
                width: "15px"
            },
            { data: "no" },
            { data: "order_number" },
            { data: "user" },
            { data: "money" },
            { data: "total" },
            { data: "change_money" },
            { data: "status" },
            { data: "option" }
        ],
        "columnDefs": [
            {   
                "targets": [0, 1, 8],
                "orderable": false,
            }
        ],
        "createdRow": function(row, data, dataIndex){
            console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
            for(var i = 0; i < 9; i++) {
                if(i == 1 || (i >= 4 && i <= 6)) { 
                    $('td:eq('+i+')', row).addClass('text-right'); 
                }
            }
        }
    });

    // event on click button show detail
    $('#table-order-list tbody').on('click', 'td.details-control', function () {
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
    var detail = 'Order doesnt have detail..';

    if(data.length > 0) {
        var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        $.each(data, function(index, item) {
            table += '<tr>'+
                        '<td>'+item.order_item+' ('+item.qty+') - '+item.subtotal_full+'</td>'+
                    '</tr>';
        });
    
        table += '</table>';
        detail = table;
    }

    return detail;
}

/**
 * 
 */
function getEdit(id) {

}