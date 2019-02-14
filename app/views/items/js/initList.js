$(document).ready(function() {
    var table_item_list = $("#table-item-list").DataTable({
        // "responsive": true,
        "lengthMenu": [ 10, 25, 75, 100 ],
        "pageLength": 10,
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": BASE_URL+"items/get-list/",
            "type": 'POST',
            "data": {}
        },
        "columns": [
            { data: "no" },
            { data: "name" },
            { data: "price" },
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
            for(var i = 0; i < 5; i++) {
                if(i == 0 || i == 2) { 
                    $('td:eq('+i+')', row).addClass('text-right'); 
                }
            }
        }
    });
});