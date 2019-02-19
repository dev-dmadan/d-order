<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add Item -->
<div class="modal fade" id="modal-edit-profile" role="dialog" aria-labelledby="modal-form-itemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-itemLabel">Form Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-profile">
                <input type="hidden" id="id">
                <div class="modal-body">
                    
                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert Name">
                        <div class="message message-name"></div>
                    </div>

                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert Email">
                        <div class="message message-name"></div>
                    </div>

                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Phone</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert Phone">
                        <div class="message message-name"></div>
                    </div>

                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Birth date</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert Birth date">
                        <div class="message message-name"></div>
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