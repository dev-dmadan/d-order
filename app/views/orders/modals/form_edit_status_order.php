<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Edit Status Order -->
<div class="modal fade" id="modal-status-order" role="dialog" aria-labelledby="modal-status-orderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-order-detailLabel">Form Edit Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-order">
                <div class="modal-body">
                    <!-- order -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Order Number -->
                            <div style="padding: .75rem 1.25rem;">
                                <label><strong>Order number</strong></label>
                                <label id="order_number">Order Number</label>
                            </div>
                            
                            <!-- Name -->
                            <div style="padding: .75rem 1.25rem;">
                                <label><strong>Name</strong></label>
                                <label id="name">Name</label>
                            </div>

                            <!-- Money -->
                            <div style="padding: .75rem 1.25rem;">
                                <label><strong>Money</strong></label>
                                <label id="money">Money</label>
                            </div>

                            <!-- Status -->
                            <div style="padding: .75rem 1.25rem;">
                                <input type="hidden" id="status_id">
                                <label><strong>Status</strong></label>
                                <label id="status_name">status</label>
                            </div>

                            <!-- Button -->
                            <div class="text-right" style="padding: .75rem 1.25rem;">
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Change Status</a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>

                    <!-- detail -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush detail-orders">
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>