<?php 
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    $sess_welcome = isset($_SESSION['sess_welcome']) ? $_SESSION['sess_welcome'] : false;
    $sess_notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : false;
	unset($_SESSION['sess_welcome']);
	unset($_SESSION['notif']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Order List &mdash; Mas'D Order</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap/css/bootstrap.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/fontawesome/css/all.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/datatables/datatables.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"; ?>">
        
        <!-- CSS Libraries -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/izitoast/css/iziToast.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/select2/dist/css/select2.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap-daterangepicker/daterangepicker.css"; ?>">

        <!-- Template CSS -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/style.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/components.css"; ?>">

        <style>
            td.details-control {
                text-align:center;
                color:forestgreen;
                cursor: pointer;
            }
            tr.shown td.details-control {
                text-align:center; 
                color:red;
            }
        </style>
    </head>

    <body class="layout-3">
        <div id="app">
            <div class="main-wrapper container">
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <a href="<?= BASE_URL ?>" class="navbar-brand sidebar-gone-hide">D'Order</a>
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                    <div class="ml-auto"></div>
                    <ul class="navbar-nav navbar-right">
                        <!-- add class beep for notification -->
                        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                <div class="dropdown-header">Notifications</div>
                                <div class="dropdown-list-content">
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <!-- <img alt="image" src="<?= BASE_URL."assets/dist/img/avatar/avatar-1.png"; ?>" class="rounded-circle dropdown-item-img"> -->
                                        <div class="dropdown-item-desc">
                                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                                            <div class="time">10 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <!-- <img alt="image" src="<?= BASE_URL."assets/dist/img/avatar/avatar-2.png"; ?>" class="rounded-circle dropdown-item-img"> -->
                                        <div class="dropdown-item-desc">
                                            <b>Ujang Maman</b> has moved task <b>Fix bug footer</b> to <b>Progress</b>
                                            <div class="time">12 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <!-- <img alt="image" src="<?= BASE_URL."assets/dist/img/avatar/avatar-3.png"; ?>" class="rounded-circle dropdown-item-img"> -->
                                        <div class="dropdown-item-desc">
                                            <b>Agung Ardiansyah</b> has moved task <b>Fix bug sidebar</b> to <b>Done</b>
                                            <div class="time">12 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <!-- <img alt="image" src="<?= BASE_URL."assets/dist/img/avatar/avatar-4.png"; ?>" class="rounded-circle dropdown-item-img"> -->
                                        <div class="dropdown-item-desc">
                                            <b>Ardian Rahardiansyah</b> has moved task <b>Fix bug navbar</b> to <b>Done</b>
                                            <div class="time">16 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <!-- <img alt="image" src="<?= BASE_URL."assets/dist/img/avatar/avatar-5.png"; ?>" class="rounded-circle dropdown-item-img"> -->
                                        <div class="dropdown-item-desc">
                                            <b>Alfa Zulkarnain</b> has moved task <b>Add logo</b> to <b>Done</b>
                                            <div class="time">Yesterday</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= $_SESSION['sess_images'] ?>" width="30" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['sess_name'] ?></div></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title"></div>
                                <a href="features-profile.html" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?= BASE_URL."login/logout" ?>" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <nav class="navbar navbar-secondary navbar-expand-lg">
                    <div class="container">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a href="<?= BASE_URL."orders" ?>" class="nav-link"><i class="far fa-file-alt"></i><span>Order List</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL."orders/form" ?>" class="nav-link"><i class="far fa-file-alt"></i><span>Order Form</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL."orders/history" ?>" class="nav-link"><i class="fas fa-history"></i><span>Order History</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL."menu" ?>" class="nav-link"><i class="fas fa-file-alt"></i><span>Menu</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL."user" ?>" class="nav-link"><i class="fas fa-history"></i><span>User</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        <div class="section-header">
                            <h1>Order List Today..</h1>
                            <div class="section-header-breadcrumb">
                                <div class="breadcrumb-item"><a href="<?= BASE_URL; ?>">D'Order</a></div>
                                <div class="breadcrumb-item active">Order List</div>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="card">
                                <form id="order-form">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!-- <table class="table table-bordered table-hover table-md dt-responsive nowrap" id="table-order-list" style="width: 100%"> -->
                                            <table class="table table-bordered table-hover table-md" id="table-order-list" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th style="width: 5%" class="text-right">No</th>
                                                        <th>Order Number</th>
                                                        <th>User</th>
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
                <footer class="main-footer">
                    <div class="footer-left">
                        <strong>Mas'D Order | Copyright &copy; <?php echo date("Y"); ?> <a href="<?= BASE_URL ?>">Team iSure++</a>.</strong> All rights reserved. </br>Powered By i-SystemAsia</a>
                    </div>
                    <div class="footer-right">
                        <?= VERSION; ?>
                    </div>
                </footer>
            </div>
        </div>

        <!-- General JS Scripts -->
        <script src="<?= BASE_URL."assets/dist/modules/jquery.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/popper.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/tooltip.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/bootstrap/js/bootstrap.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/nicescroll/jquery.nicescroll.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/moment.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/js/stisla.js"; ?>"></script>
        
        <!-- JS Libraies -->
        <script src="<?= BASE_URL."assets/dist/modules/sweetalert/sweetalert.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/izitoast/js/iziToast.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/bootstrap-daterangepicker/daterangepicker.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/select2/dist/js/select2.full.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/input-mask/jquery.inputmask.bundle.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/datatables/datatables.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"; ?>"></script>

        <!-- Page Specific JS File -->
        
        <!-- Template JS File -->
        <script src="<?= BASE_URL."assets/dist/js/scripts.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/js/custom.js"; ?>"></script>

        <!-- JS Form -->
        <script>
            const BASE_URL = "<?php print BASE_URL; ?>";
            var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
        </script>
        <script src="<?= BASE_URL."app/views/layout/js/init.js"; ?>"></script>

        <?php
            if($sess_welcome){
		        ?>
				<script type="text/javascript">
					/**
					 * Init toastr selamat datang ke sistem
					 */
			    	$(document).ready(function(){
                        var welcomeNotif = {type: 'success', 'title': '', 'message': "Welcome to D'Order"};
                        setNotif(welcomeNotif, 'toastr');
			    	});
                </script>
                <?php
            }
        ?>
        <script src="<?= BASE_URL."app/views/orders/js/initList.js"; ?>"></script>
    </body>
</html>