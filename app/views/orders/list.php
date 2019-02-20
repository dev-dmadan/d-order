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
                <div class="breadcrumb-item active">Order List</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <button id="exportExcel" class="btn btn-success"><i class=""></i> Export Excel</button>
                        <button id="refreshTable" class="btn btn-info"><i class=""></i> Refresh</button>
                    </div>
                </div>
                <form id="order-form">
                    <div class="card-body">
                        <!-- <div class="table-responsive"> -->
                            <table class="table table-bordered table-hover table-md" id="table-order-list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        <!-- </div> -->
                    </div>
 
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->

<?php include_once('modals/form_edit_status_order.php'); ?>