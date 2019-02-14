$(document).ready(function() {
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
});