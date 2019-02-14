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
                <div class="breadcrumb-item active">Order History</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form id="order-form">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- <table class="table table-bordered table-hover table-md dt-responsive nowrap" id="table-order-list" style="width: 100%"> -->
                            <table class="table table-bordered table-hover table-md" id="table-order-history" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width: 5%" class="text-right">No</th>
                                        <th>Order Number</th>
                                        <th class="text-right">Money</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Change Money</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-whitesmoke text-right">   
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->