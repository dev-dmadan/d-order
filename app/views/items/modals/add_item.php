<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal Add Item -->
<div class="modal fade" id="modal-add-item" role="dialog" aria-labelledby="modal-add-ItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-ItemLabel">Form Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-Item-detail">
                <input type="hidden" id="detailId">
                <div class="modal-body">
                    
                    <!-- name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control field" placeholder="Please insert your name">
                        <div class="message message-name"></div>
                    </div>

                    <!-- price -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
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
                    </div>

                    <!-- description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" class="form-control field" placeholder="Please fill description">
                        </textarea>
                        <div class="message message-description"></div>
                    </div>


                    <!-- status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control field" id="status" style="width: 100%"></select>
                        <div class="message message-status"></div>
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
                        <button type="button" id="btn-reset-add-Item" class="btn btn-outline-danger">Reset</button>
                        <button type="submit" id="btn-submit-add-Item" class="btn btn-outline-success" value="action-add">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>