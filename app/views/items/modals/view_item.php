<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal View Item -->
<div class="modal fade" id="modal-view-item" role="dialog" aria-labelledby="modal-view-itemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-view-itemLabel">View Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="view-item">
                <input type="hidden" id="id">
                <div class="modal-body">
                    <div class="row">
                        <!-- grid span 12 -->
                        <div class="col-md-6 col-xs-12">
                            <div class="user-item">
                                <!-- user image -->
                                <img id="item_image" alt="image" width="60%" class="rounded-circle mr-1">
                                <div class="user-details">
                                    <div class="item-name"></div>
                                    <div class="item-status text-muted"></div>
                                    <br>
                                    <button class="btn btn-primary" type="button">Change Image</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">

                            <div class="form-group">
                                <label for="item_price"><strong>Price</strong></label>
                                <div id="item_price"></div>
                            </div>

                            <div class="form-group">
                                <label for="item_description"><strong>Description</strong></label>
                                <div id="item_description" class="user-description"></div>
                            </div>

                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>