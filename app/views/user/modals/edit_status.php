<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Edit Status -->
<div class="modal fade" id="modal-edit-status" role="dialog" aria-labelledby="modal-edit-statusLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-statusLabel">Form Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user">
                <input type="hidden" id="id">
                <div class="modal-body">

                    <!-- status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control field" id="status" style="width: 100%"></select>
                        <div class="message message-status"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-submit" class="btn btn-outline-success">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>