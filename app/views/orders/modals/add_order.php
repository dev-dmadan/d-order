<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add order -->
<div class="modal fade" id="modal-add-order" role="dialog" aria-labelledby="modal-add-orderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-orderLabel">Form Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-order-detail">
                <input type="hidden" id="detailId">
                <div class="modal-body">
                    <!-- menu -->
                    <div class="form-group">
                        <label for="menu">Menu</label>
                        <select class="form-control field" id="menu" style="width: 100%"></select>
                        <div class="message message-menu"></div>
                    </div>

                    <!-- menu name -->
                    <div class="form-group" style="display: none">
                        <label for="menu_name">Other</label>
                        <input id="menu_name" class="form-control field" placeholder="Please enter your custom menu">
                        <div class="message message-menu_name"></div>
                    </div>

                    <!-- Price & qty -->
                    <div class="form-row">

                        <!-- price -->
                        <div class="form-group col-md-8">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" id="price" class="form-control field input-mask-money" value="0" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                                <div class="message message-price"></div>
                            </div>
                        </div>

                        <!-- qty -->
                        <div class="form-group col-md-4">
                            <label for="qty">Qty</label>
                            <input type="number" id="qty" class="form-control field" value="1">
                            <div class="message message-qty"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" id="btn-reset-add-order" class="btn btn-outline-danger">Reset</button>
                        <button type="submit" id="btn-submit-add-order" class="btn btn-outline-success" value="action-add">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>