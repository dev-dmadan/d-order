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

                                        <!-- <div class="form-group">
                                            <label for="email"><strong>Email</strong></label>
                                            <div class="user-email">udin@i-systemasia.com</div>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone"><strong>Phone</strong></label>
                                            <div class="user-phone">080989999</div>
                                        </div>

                                        <div class="form-group">
                                            <label for="birthday"><strong>Birthday</strong></label>
                                            <div class="user-birthday">01/02/2019</div>
                                        </div> -->
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
                                            <button id="exportExcel" class="btn btn-success"><i class=""></i> Export Excel</button>
                                            <button id="refreshTable" class="btn btn-info"><i class=""></i> Refresh</button>
                                        </div>
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
                                                        <div class="card-body">75</div>
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
                                                        <div class="card-body">Rp 9.750.000,00</div>
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

                                                                    <li class="media">
                                                                        <img alt="image" src="http://memoriacode.com/image/star.png" width="3%">
                                                                        <div class="media-body">
                                                                            <div class="media-right">100</div>
                                                                            <div class="media-title"><a href="#"> Warteg</a></div>
                                                                        </div>
                                                                    </li>

                                                                    <li class="media">
                                                                        <img alt="image" src="http://memoriacode.com/image/star.png" width="3%">
                                                                        <div class="media-body">
                                                                            <div class="media-right">77</div>
                                                                            <div class="media-title"><a href="#"> Paket Ayam</a></div>
                                                                        </div>
                                                                    </li>

                                                                    <li class="media">
                                                                        <img alt="image" src="http://memoriacode.com/image/star.png" width="3%">
                                                                        <div class="media-body">
                                                                            <div class="media-right">54</div>
                                                                            <div class="media-title"><a href="#"> Mie Aceh</a></div>
                                                                        </div>
                                                                    </li>

                                                                    <li class="media">
                                                                        <img alt="image" src="http://memoriacode.com/image/star.png" width="3%">
                                                                        <div class="media-body">
                                                                            <div class="media-right">32</div>
                                                                            <div class="media-title"><a href="#"> Soto Betawi</a></div>
                                                                        </div>
                                                                    </li>

                                                                    <li class="media">
                                                                        <img alt="image" src="http://memoriacode.com/image/star.png" width="3%">
                                                                        <div class="media-body">
                                                                            <div class="media-right">12</div>
                                                                            <div class="media-title"><a href="#"> Mc Donald's</a></div>
                                                                        </div>
                                                                    </li>

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
                                                <h4>Status List</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="summary">
                                                    <div class="summary-item">
                                                        <ul class="list-unstyled list-unstyled-border">

                                                            <li class="media">
                                                                <img alt="image" src="http://memoriacode.com/image/star.png" width="10%">
                                                                <div class="media-body">
                                                                    <div class="media-right">10</div>
                                                                    <div class="media-title"><a href="#">Pending</a></div>
                                                                </div>
                                                            </li>

                                                            <li class="media">
                                                                <img alt="image" src="http://memoriacode.com/image/star.png" width="10%">
                                                                <div class="media-body">
                                                                    <div class="media-right">25</div>
                                                                    <div class="media-title"><a href="#">Process</a></div>
                                                                </div>
                                                            </li>

                                                            <li class="media">
                                                                <img alt="image" src="http://memoriacode.com/image/star.png" width="10%">
                                                                <div class="media-body">
                                                                    <div class="media-right">50</div>
                                                                    <div class="media-title"><a href="#">Reject</a></div>
                                                                </div>
                                                            </li>

                                                            <li class="media">
                                                                <img alt="image" src="http://memoriacode.com/image/star.png" width="10%">
                                                                <div class="media-body">
                                                                    <div class="media-right">100</div>
                                                                    <div class="media-title"><a href="#">Done</a></div>
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
                                                <h4>Statistics</h4>
                                                <div class="card-header-action">
                                                    <div class="btn-group">
                                                    <a href="#" class="btn btn-primary">Week</a>
                                                    <a href="#" class="btn">Month</a>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                            </div>
                                                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                            </div>
                                                        </div>
                                                    <canvas id="myChart" height="286" width="472" class="chartjs-render-monitor" style="display: block; width: 472px; height: 286px;">
                                                    </canvas>
                                                    <div class="statistic-details mt-sm-4">
                                                    <div class="statistic-details-item">
                                                    
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