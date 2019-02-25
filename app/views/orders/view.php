<?php 
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    $orders = $this->data['orders'];
    $detail = $this->data['detail'];
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
                <div class="breadcrumb-item"><a href="<?= BASE_URL.'orders/history'; ?>">Order</a></div>
                <div class="breadcrumb-item active">View Order</div>
            </div>
        </div>

        <div class="section-body">
            <!-- row body 1 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <button class="btn btn-danger" onclick="goBack();"><i class="fas fa-undo"></i> Back</button>
                            </div>
                        </div>
                        <!-- End Header -->

                        <form id="user-profile">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Invoice -->
                                    <div class="col-lg-12">
                                        <!-- Head Invoice -->
                                        <div class="invoice-title">
                                            <h2><?= $orders['order_number'] ?></h2>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong>Notes:</strong><br>
                                                    <?= $orders['notes'] ?>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Row 1 -->
                                                <div class="row">
                                                    <div class="col-sm-12 text-md-right">
                                                        <address>
                                                        <strong>For:</strong><br>
                                                        <?= $orders['user_name'] ?>
                                                        </address>
                                                    </div>
                                                </div>

                                                <!-- Row 2 -->
                                                <div class="row">
                                                    <div class="col-md-12 text-md-right">
                                                        <address>
                                                            <strong>Order Date:</strong><br>
                                                            <?= $orders['created_on'] ?> 
                                                        </address>
                                                    </div>
                                                </div>

                                                <!-- Row 3 -->
                                                <div class="row">
                                                    <div class="col-md-12 text-md-right">
                                                        <address>
                                                            <strong>Status:</strong><br>
                                                            <?= $orders['status_name'] ?>
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- End Invoice -->

                                        <!-- table view order -->
                                        <div class="section-title">Order Detail</div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-md" id="table-order-detail" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th>Order</th>
                                                        <th class="text-right">Price</th>
                                                        <th class="text-right" style="width: 5%">Qty</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 0;
                                                        foreach($detail as $row) {
                                                            $no++;
                                                            echo '<tr>';
                                                            echo '<td>'.$no.'</td>';
                                                            echo '<td>'.$row['order_item'].'</td>';
                                                            echo '<td class="text-right">'.$row['price_item'].'</td>';
                                                            echo '<td class="text-right">'.$row['qty'].'</td>';
                                                            echo '<td class="text-right">'.$row['subtotal'].'</td>';
                                                            echo '<tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="section-title">Payment</div>
                                        <!-- Money, Total, and Change Money -->
                                        <div class="text-right">
                                            <div style="margin-bottom: 15px;">
                                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Money</div>
                                                <div style="font-size: 18px; color: #34395e; font-weight: 700;"><?= $orders['money'] ?></div>
                                            </div>
                                            <div style="margin-bottom: 15px;">
                                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Change Money</div>
                                                <div style="font-size: 18px; color: #34395e; font-weight: 700;"><?= $orders['change_money'] ?></div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div style="margin-bottom: 15px;">
                                                <div style="letter-spacing: .3px; color: #98a6ad; margin-bottom: 4px;">Total</div>
                                                <div style="font-size: 24px; color: #34395e; font-weight: 700;"><?= $orders['total'] ?></div>
                                            </div>
                                        </div>
                                        <!-- End Money, Total, and Change Money -->
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
</div>
<!-- End Main Content -->