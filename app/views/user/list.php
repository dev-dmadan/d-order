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
                <div class="breadcrumb-item active">User List</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <button id="exportExcel" class="btn btn-success"><i class="far fa-file-excel"></i> Export Excel</button>
                        <button id="refreshTable" class="btn btn-info"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
                <form id="order-form">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- <table class="table table-bordered table-hover table-md dt-responsive nowrap" id="table-order-list" style="width: 100%"> -->
                            <table class="table table-bordered table-hover table-md" id="table-user-list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-right">No</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
<?php include_once('modals/edit_status.php') ?>