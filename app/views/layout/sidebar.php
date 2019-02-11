<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- secondary navbar / sidebar -->
<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <!-- <ul class="navbar-nav">
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
        </ul> -->
        <?php $this->getSidebar(); ?>
    </div>
</nav>
<!-- end secondary navbar -->