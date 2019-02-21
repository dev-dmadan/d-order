<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add Item -->
<div class="modal fade" id="modal-edit-profile" role="dialog" aria-labelledby="modal-edit-profileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-profile">Form Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-profile">
                <input type="hidden" id="id">
                <div class="modal-body">
                    
                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert your Name">
                        <div class="message message-name"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" id="btn-reset-profile" class="btn btn-outline-danger">Reset</button>
                        <button type="submit" id="btn-submit-profile" class="btn btn-outline-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>