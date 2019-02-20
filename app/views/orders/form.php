<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>
                <?= $this->propertyPage['main'] ?>
                <small><?= $this->propertyPage['sub'] ?></small>
            </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="<?= BASE_URL; ?>">D'Order</a></div>
                <div class="breadcrumb-item active">Order Form</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form id="form-order">
                    <div class="card-body">
                        <!-- Order Number and Order Date -->
                        <div class="form-row">
                            <input type="hidden" id="status" value="<?= $this->data['status']['id'] ?>">
                            <input type="hidden" id="status_name" value="<?= $this->data['status']['name'] ?>">
                            <!-- Order Number -->
                            <div class="form-group col-md-6">
                                <label for="order_number">Order Number</label>
                                <input type="text" id="order_number" class="form-control field" placeholder="Order Number" value="<?= $this->data['order_number']; ?>" readonly>
                                <div class="message message-order_number"></div>
                            </div>
    
                            <!-- Order Date -->
                            <div class="form-group col-md-6">
                                <label for="order_date">Order Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" id="order_date" class="form-control field" placeholder="Order Date (yyyy-mm-dd)" value="<?= $this->data['order_date']; ?>" readonly>
                                </div>
                                <div class="message message-order_date"></div>
                            </div>
                        </div>

                        <!-- Money -->
                        <div class="form-row">  
                            <div class="form-group col-md-6">
                                <label for="money">Money</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="money" class="form-control field input-mask-money" value="<?= $this->data['money']; ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                    <div class="message message-money"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea id="notes" class="form-control field" placeholder="Please fill notes"><?= $this->data['notes']; ?></textarea>
                            <div class="message message-notes"></div>
                        </div>

                        <!-- button add order detail and show menu -->                                        
                        <div class="btn-group mb-3" role="group">
                            <button type="button" id="btn-add-order" class="btn btn-outline-success">Add Order</button>
                            <button type="button" id="btn-show-menu" class="btn btn-outline-info">Show Menu</button>
                        </div>
                        
                        <!-- table order detail -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-md" id="table-order-detail" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Order</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right" style="width: 5%">Qty</th>
                                        <th class="text-right">Subtotal</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- Money, Total, and Change Money -->
                        <div class="text-right">
                            <div style="margin-bottom: 15px;">
                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Money</div>
                                <div id="text_money" style="font-size: 18px; color: #34395e; font-weight: 700;"><?= (isset($this->data['text_money'])) ? $this->data['text_money'] : 'Rp 0,00'; ?></div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Change Money</div>
                                <div id="text_change_money" style="font-size: 18px; color: #34395e; font-weight: 700;"><?= (isset($this->data['text_change_money'])) ? $this->data['text_change_money'] : 'Rp 0,00'; ?></div>
                                <input type="hidden" id="change_money" value="<?= (isset($this->data['change_money'])) ? $this->data['change_money'] : 0; ?>">
                            </div>
                            <hr class="mt-2 mb-2">
                            <div style="margin-bottom: 15px;">
                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Total</div>
                                <div id="text_total" style="font-size: 24px; color: #34395e; font-weight: 700;"><?= (isset($this->data['text_total'])) ? $this->data['text_total'] : 'Rp 0,00'; ?></div>
                                <input type="hidden" id="total" value="<?= (isset($this->data['total'])) ? $this->data['total'] : 0; ?>">
                            </div>
                        </div>

                        <!-- button back, submit and reset -->
                        <?php if($this->data['action'] == 'action-edit') { ?> 
                            <a href="<?= BASE_URL."orders/history/" ?>" class="btn btn-secondary mb-3" role="button">Back</a> 
                        <?php } ?>
                        <div class="btn-group float-right mb-3" role="group">
                            <button id="btn-reset" class="btn btn-secondary" type="button">Reset</button>
                            <button id="btn-submit" class="btn btn-primary" type="submit" value="<?= $this->data['action']; ?>">Order</button>
                        </div>
                        <!-- </div> -->
                    </div>
                    
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
                 
<!-- modal add detail dan show menu -->
<?php 
    include_once("modals/form_order_detail.php");
    include_once("modals/show_menu.php"); 
?>