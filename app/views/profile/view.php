<?php 
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    $total_orders = $this->data['total_orders'];
    $amount_spend = $this->data['amount_spend'];
    $top_orders = $this->data['top_orders'];
    $total_status = $this->data['total_status'];
    $average = $this->data['average'];
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
                <div class="breadcrumb-item active">Profile</div>
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
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Action</a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="#" id="btn-edit-profile" class="dropdown-item has-icon"><i class="fas fa-edit"></i> Edit Profile</a>
                                        <a href="#" id="btn-edit-photo" class="dropdown-item has-icon"><i class="fas fa-camera"></i> Edit Photo Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" id="btn-change-password" class="dropdown-item has-icon text-danger"><i class="fas fa-key"></i> Change Password</a>
                                    </div>
                                </div>
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
                                                <div class="user-name"><?= $_SESSION['sess_id'] ?></div>
                                                <div class="text-job text-muted"><?= $_SESSION['sess_status'] ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- grid span 8 -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="user-name"><strong>Name</strong></label>
                                            <div class="user-name"><?= $_SESSION['sess_name'] ?></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user-username"><strong>Username</strong></label>
                                            <div class="user-name"><?= $_SESSION['sess_id'] ?></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user-level"><strong>Level</strong></label>
                                            <div class="user-name"><?= $_SESSION['sess_level'] ?></div>
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
                        <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Order History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link show" id="analytic-tab" data-toggle="tab" href="#analytic" role="tab" aria-controls="analytic" aria-selected="false">Analytics Order</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- content history -->
                            <div class="tab-pane fade active show" id="history" role="tabpanel" aria-labelledby="history-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="float-right mb-3">
                                            <button id="exportExcel" class="btn btn-success"><i class="far fa-file-excel"></i> Export Excel</button>
                                            <button id="refreshTable" class="btn btn-info"><i class="fas fa-sync-alt"></i> Refresh</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-md" id="table-order-history" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th style="width: 5%" class="text-right">No</th>
                                                        <th>Order Number</th>
                                                        <th class="text-righst">Money</th>
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

                            <!-- content analytic -->
                            <div class="tab-pane fade" id="analytic" role="tabpanel" aria-labelledby="analytic-tab">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card card-statistic-1" style="box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);">
                                                    <div class="card-icon bg-primary">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                    <div class="card-wrap">
                                                        <div class="card-header"><h4>Total Orders</h4></div>
                                                        <div class="card-body"><?= $total_orders ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-statistic-1" style="box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);">
                                                    <div class="card-icon bg-primary">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                    <div class="card-wrap">
                                                        <div class="card-header"><h4>Amount Spend</h4></div>
                                                        <div class="card-body"><?= $amount_spend ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                
                                                <div class="card" style="box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);">
                                                    <div class="card-header">
                                                        <h4>Top 5 Food Orders</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="summary">
                                                            <div class="summary-item">
                                                                <ul class="list-unstyled list-unstyled-border">

                                                                    <?php
                                                                        if($top_orders) {
                                                                            foreach($top_orders as $item) {
                                                                                ?>
                                                                                <li class="media">
                                                                                    <a href="javascript:void(0)">
                                                                                        <img class="mr-3 rounded" alt="image" src="<?= $item['image'] ?>" width="50">
                                                                                    </a>
                                                                                    <div class="media-body">
                                                                                        <div class="media-right"><span class="badge badge-primary badge-pill"><?= $item['total_order'] ?></span></div>
                                                                                        <div class="media-title"><a href="javascript:void(0)"> <?= $item['item_name'] ?></a></div>
                                                                                    </div>
                                                                                </li>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else {

                                                                        }
                                                                    ?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card" style="box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);">
                                            <div class="card-header">
                                                <h4>Total Order Status</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="summary">
                                                    <div class="summary-item">
                                                        <ul class="list-unstyled list-unstyled-border">
                                                            
                                                            <li class="media">
                                                                <div class="media-body">
                                                                    <div class="media-right"><span class="badge badge-primary badge-pill"><?= $total_status['DONE'] ?></span></div>
                                                                    <div class="media-title"><div class="badge badge-success">DONE</div></div>
                                                                </div>
                                                            </li>
                                                            
                                                            <li class="media">
                                                                <div class="media-body">
                                                                    <div class="media-right"><span class="badge badge-primary badge-pill"><?= $total_status['PROCESS'] ?></span></div>
                                                                    <div class="media-title"><div class="badge badge-info">PROCESS</div></div>
                                                                </div>
                                                            </li>

                                                            <li class="media">
                                                                <div class="media-body">
                                                                    <div class="media-right"><span class="badge badge-primary badge-pill"><?= $total_status['PENDING'] ?></span></div>
                                                                    <div class="media-title"><div class="badge badge-primary">PENDING</div></div>
                                                                </div>
                                                            </li>

                                                            <li class="media">
                                                                <div class="media-body">
                                                                    <div class="media-right"><span class="badge badge-primary badge-pill"><?= $total_status['REJECT'] ?></span></div>
                                                                    <div class="media-title"><div class="badge badge-danger">REJECT</div></div>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);">
                                            <div class="card-header">
                                                <h4>Statistics Amount Spend</h4>
                                                <div class="card-header-action">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0);" id="get_week" class="btn btn-primary">Week</a>
                                                        <a href="javascript:void(0);" id="get_month" class="btn">Month</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart" height="182"></canvas>
                                                <div class="statistic-details mt-sm-4">
                                                    <div class="statistic-details-item">
                                                        <span class="text-muted"><span class="<?= $average['today']['color'] ?>"><i class="<?= $average['today']['icon'] ?>"></i></span> <?= $average['today']['percent'] ?></span>
                                                        <div class="detail-value"><?= $average['today']['value'] ?></div>
                                                        <div class="detail-name">Total This Today's</div>
                                                    </div>
                                                    <div class="statistic-details-item">
                                                        <span class="text-muted"><span class="<?= $average['week']['color'] ?>"><i class="<?= $average['week']['icon'] ?>"></i></span> <?= $average['week']['percent'] ?></span>
                                                        <div class="detail-value"><?= $average['week']['value'] ?></div>
                                                        <div class="detail-name">This Week's average</div>
                                                    </div>
                                                    <div class="statistic-details-item">
                                                        <span class="text-muted"><span class="<?= $average['month']['color'] ?>"><i class="<?= $average['month']['icon'] ?>"></i></span> <?= $average['month']['percent'] ?></span>
                                                        <div class="detail-value"><?= $average['month']['value'] ?></div>
                                                        <div class="detail-name">This Month's average</div>
                                                    </div>
                                                    <div class="statistic-details-item">
                                                        <span class="text-muted"><span class="<?= $average['year']['color'] ?>"><i class="<?= $average['year']['icon'] ?>"></i></span> <?= $average['year']['percent'] ?></span>
                                                        <div class="detail-value"><?= $average['year']['value'] ?></div>
                                                        <div class="detail-name">This Year's average</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<?php include_once('modals/edit_profile.php'); ?>
<?php include_once('modals/edit_photo_profile.php'); ?>
<?php include_once('modals/change_password.php'); ?>