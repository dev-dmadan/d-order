$(document).ready(function() {
	// event onclick btn add item
    $('#btn-add-item').on('click', function() {
        console.log("%cButton Add Order clicked...", "color: blue; font-style: italic");
        showFormItem('action-add');
    });
});

/**
 *
 */
function showFormItem(action) {
	$('#modal-add-item').modal();
}