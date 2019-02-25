<?php 
    Defined("BASE_PATH") or die(ACCESS_DENIED); 
    $user = $this->data;
?>

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
                <div class="breadcrumb-item"><a href="<?= BASE_URL.'user/'; ?>">User</a></div>
                <div class="breadcrumb-item active">User Detail</div>
            </div>
        </div>

        <div class="section-body">
            <!-- row body 1 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <button class="btn btn-danger" onclick="goBack();"><i class="fas fa-undo"></i> Back</button>
                            </div>
                        </div>
                        <form id="user-profile">
                            <div class="card-body">
                                <div class="row">
                                    <!-- grid span 4 -->
                                    <div class="col-md-4">
                                        <div class="user-item">
                                            <!-- user image -->
                                            <img alt="image" src="<?= $_SESSION['sess_image'] ?>" width="75%%" class="rounded-circle mr-1">
                                            <div class="user-details">
                                                <div class="user-name"><?= $user['name'] ?></div>
                                                <div class="text-job text-muted"><?= $user['status_name'] ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- grid span 8 -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name"><strong>Name</strong></label>
                                            <div class="user-name"><?= $user['name'] ?></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username"><strong>Username</strong></label>
                                            <div class="user-username"><?= $user['username'] ?></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="level"><strong>Level</strong></label>
                                            <div class="user-level"><?= $user['level_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- row body 2 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <button id="exportExcel" class="btn btn-success"><i class="far fa-file-excel"></i> Export Excel</button>
                        <button id="refreshTable" class="btn btn-info"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>

                        <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Order History</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-12">
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
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->