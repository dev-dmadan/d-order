$(document).ready(function() {
    var table_item_list = $("#table-item-list").DataTable({
        // "responsive": true,
        "lengthMenu": [ 10, 25, 75, 100 ],
        "pageLength": 10,
        "order": [],
        // "processing": true,
        // "serverSide": true,
        // "ajax": {
        //     "url": BASE_URL+"items/get-list/",
        //     "type": 'POST',
        //     "data": {}
        // },
        // "columns": [
        //     {
        //         className: 'details-control',
        //         orderable: false,
        //         data: null,
        //         defaultContent: '',
        //         render: function () {
        //             return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
        //         },
        //         width: "15px"
        //     },
        //     { data: "no" },
        //     { data: "order_number" },
        //     { data: "user" },
        //     { data: "money" },
        //     { data: "total" },
        //     { data: "change_money" },
        //     { data: "status" },
        //     { data: "option" }
        // ],
        // "columnDefs": [
        //     {   
        //         "targets": [0, 1, 8],
        //         "orderable": false,
        //     }
        // ],
        // "createdRow": function(row, data, dataIndex){
        //     console.log("DataTable createdRow: ", {row: row, data: data, dataIndex: dataIndex});
        //     for(var i = 0; i < 9; i++) {
        //         if(i == 1 || (i >= 4 && i <= 6)) { 
        //             $('td:eq('+i+')', row).addClass('text-right'); 
        //         }
        //     }
        // }
    });
});