<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add registration -->
<div class="modal fade" id="modal-form-registration" role="dialog" aria-labelledby="modal-form-registrationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-registrationLabel">Form D'Order Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registration">
                <div class="modal-body">
                    
                    <!-- fullname -->
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" id="fullname" class="form-control field" placeholder="Please insert fullname">
                        <div class="message message-fullname"></div>
                    </div>

                    <!-- username_register -->
                    <div class="form-group">
                        <label for="username_register">Username</label>
                        <input type="text" id="username_register" class="form-control field" placeholder="Please insert username">
                        <div class="message message-username_register"></div>
                    </div>

                    <!-- password_register -->
                    <div class="form-group">
                        <label for="password_register">Password</label>
                        <input type="password" id="password_register" class="form-control field" placeholder="Please insert password">
                        <div class="message message-password_register"></div>
                    </div>

                    <!-- confirm_password -->
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" class="form-control field" placeholder="Please insert confirm password">
                        <div class="message message-confirm_password"></div>
                    </div>

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
                        <button type="submit" id="btn-register" class="btn btn-outline-success" value="action-add">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>