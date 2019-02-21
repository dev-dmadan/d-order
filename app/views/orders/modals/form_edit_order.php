<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Edit Status Order -->
<div class="modal fade" id="modal-status-order" role="dialog" aria-labelledby="modal-status-orderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-order-detailLabel">Form Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-order">
                <div class="modal-body">
                    <!-- Detail Order -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list-group detail-orders">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="submit" id="btn-submit-edit-order" class="btn btn-success">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>