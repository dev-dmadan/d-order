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
                <div class="breadcrumb-item active">Menu Item List</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form id="order-form">
                    <div class="card-body">
                        <!-- button add item -->                                        
                            <div class="btn-group mb-3" role="group">
                                <button type="button" id="btn-add-item" class="btn btn-outline-success">Add Item</button>
                            </div>
                        <!-- <div class="table-responsive"> -->
                            <table class="table table-bordered table-hover table-md dt-responsive nowrap" id="table-menu-list" style="width: 100%">
                            <!-- <table class="table table-bordered table-hover table-md" id="table-order-list" style="width: 100%"> -->
                                <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-right">No</th>
                                        <th>Name</th>
                                        <th class="text-right">Price</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        <!-- </div> -->
                    </div>
                    
                    <div class="card-footer bg-whitesmoke text-right">   
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
<?php include_once('modals/add_item.php'); ?>