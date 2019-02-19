<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add Item -->
<div class="modal fade" id="modal-edit-photo-profile" role="dialog" aria-labelledby="modal-form-itemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-itemLabel">Form Edit Photo Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-photo-profile">
                <input type="hidden" id="id">
                <div class="modal-body">
                    
                    <!-- image -->
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" class="form-control field">
                        <div class="message message-image"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" id="btn-reset" class="btn btn-outline-danger">Reset</button>
                        <button type="submit" id="btn-submit" class="btn btn-outline-success" value="action-add">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>