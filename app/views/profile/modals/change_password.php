<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add Item -->
<div class="modal fade" id="modal-change-password" role="dialog" aria-labelledby="modal-change-itemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-change-itemLabel">Form Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="change-password">
                <input type="hidden" id="id">
                <div class="modal-body">
                    
                    <!-- old password -->
                    <div class="form-group">
                        <label for="name">Old Password</label>
                        <input type="password" id="name" class="form-control field" placeholder="Please insert Old Password">
                        <div class="message message-name"></div>
                    </div>

                    <!-- new password -->
                    <div class="form-group">
                        <label for="name">New Password</label>
                        <input type="password" id="name" class="form-control field" placeholder="Please insert New Password">
                        <div class="message message-name"></div>
                    </div>

                    <!-- confirm password -->
                    <div class="form-group">
                        <label for="name">Confirm Password</label>
                        <input type="password" id="name" class="form-control field" placeholder="Please insert Confirm Password">
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