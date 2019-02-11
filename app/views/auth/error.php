<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title><?= $error; ?> &mdash; D'Order</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap/css/bootstrap.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/fontawesome/css/all.min.css"; ?>">

        <!-- CSS Libraries -->

        <!-- Template CSS -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/style.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/components.css"; ?>">
    </head>

    <body>
        <div id="app">
            <section class="section">
                <div class="container mt-5">
                    <div class="page-error">
                        <div class="page-inner">
                            <h1><?= $error; ?></h1>
                            <div class="page-description">
                                <?= $message; ?>
                            </div>
                            <div class="page-search">
                                <div class="mt-3">
                                    <a href="<?= BASE_URL; ?>" role="button" class="btn btn-primary btn-lg">
                                        Back to Home
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simple-footer mt-5">
                        <strong>Mas'D Order | Copyright &copy; <?php echo date("Y"); ?> <a href="<?= BASE_URL ?>">Team iSure++</a>.</strong> All rights reserved. </br>Powered By i-SystemAsia</a>
                    </div>
                </div>
            </section>
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

        <!-- Page Specific JS File -->
        
        <!-- Template JS File -->
        <script src="<?= BASE_URL."assets/dist/js/scripts.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/js/custom.js"; ?>"></script>
    </body>
</html>