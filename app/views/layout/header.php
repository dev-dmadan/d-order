<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<div class="navbar-bg"></div>

<!-- main navbar -->
<nav class="navbar navbar-expand-lg main-navbar">
    <a href="<?= BASE_URL ?>" class="navbar-brand sidebar-gone-hide">D'Order</a>
    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    <div class="ml-auto"></div>

    <!-- right navbar -->
    <ul class="navbar-nav navbar-right">
        
        <!-- Notifications, add class beep for notification -->
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
        <!-- end Notifications -->

        <!-- Profile -->
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= $_SESSION['sess_image'] ?>" width="30" class="rounded-circle mr-1">
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
        <!-- End Profile -->

    </ul>
    <!-- end right navbar -->

</nav>
<!-- end main navbar -->

