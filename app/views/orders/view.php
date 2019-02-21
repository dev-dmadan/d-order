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
                <div class="breadcrumb-item"><a href="<?= BASE_URL.'orders/history'; ?>">Order</a></div>
                <div class="breadcrumb-item active">View Order</div>
            </div>
        </div>

        <div class="section-body">
            <!-- row body 1 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <button class="btn btn-danger" onclick="goBack();"><i class="fas fa-undo"></i> Back</button>
                            </div>
                        </div>
                        <!-- End Header -->

                        <form id="user-profile">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Invoice -->
                                    <div class="col-lg-12">
                                        <!-- Head Invoice -->
                                        <div class="invoice-title">
                                            <h2>Order #12345</h2>
                                        </div>
                                        <hr>

                                        <!-- Row 1 -->
                                        <div class="row">
                                            <div class="col-sm-12 text-md-right">
                                                <address>
                                                <strong>For:</strong><br>
                                                Alibaba
                                                </address>
                                            </div>
                                        </div>

                                        <!-- Row 2 -->
                                        <div class="row">
                                            <div class="col-md-12 text-md-right">
                                                <address>
                                                    <strong>Order Date:</strong><br>
                                                    12:00 19 September 2018 
                                                </address>
                                            </div>
                                        </div>

                                        <!-- Row 3 -->
                                        <div class="row">
                                            <div class="col-md-12 text-md-right">
                                                <address>
                                                    <strong>Status:</strong><br>
                                                    Lunas
                                                </address>
                                            </div>
                                        </div>

                                        
                                        <!-- End Invoice -->

                                        <!-- table view order -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-md" id="table-order-detail" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th>Order</th>
                                                        <th class="text-right">Price</th>
                                                        <th class="text-right" style="width: 5%">Qty</th>
                                                        <th class="text-right">Subtotal</th>
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
                                        <!-- End Money, Total, and Change Money -->
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
</div>
<!-- End Main Content -->