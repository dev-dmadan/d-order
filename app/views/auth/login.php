<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Login &mdash; Mas'D Order</title>

        <!-- <link rel="icon" href="<?= BASE_URL."assets/images/69design_icon.ico"; ?>" type='image/x-icon'> -->
        <!-- General CSS Files -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap/css/bootstrap.min.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/fontawesome/css/all.min.css"; ?>">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap-social/bootstrap-social.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/izitoast/css/iziToast.min.css"; ?>">

        <!-- Template CSS -->
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/style.css"; ?>">
        <link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/components.css"; ?>">
    </head>
    <body>
        <div id="app">
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            <div class="login-brand">
                                <!-- <img src="<?= BASE_URL."assets/images/isure2.jpeg" ?>" alt="logo" width="100" class="shadow-light"> -->
                            </div>
                            <div class="card card-primary">
                                <div class="card-header"><h4>Login</h4></div>
                            
                                <div class="card-body">
                                    <form id="form-login">
                                        <div class="form-group has-feedback">
                                            <label for="username">Username</label>
                                            <input id="username" type="text" class="form-control field" tabindex="1" autofocus>
                                            <div class="message-username"></div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <button type="submit" id="submit-login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-5 text-muted text-center">
                                Don't have an username? <a href="auth-register.html">Register and Tell Mas'D</a>
                            </div>
                            <div class="simple-footer">
                                <strong>Mas'D Order | Copyright &copy; <?php echo date("Y"); ?> <a href="<?= BASE_URL ?>">Team iSure++</a>.</strong> All rights reserved. | Powered By i-SystemAsia</a>
                            </div>
                        </div>
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
        <script src="<?= BASE_URL."assets/dist/modules/sweetalert/sweetalert.min.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/modules/izitoast/js/iziToast.min.js"; ?>"></script>

        <!-- Page Specific JS File -->
        
        <!-- Template JS File -->
        <script src="<?= BASE_URL."assets/dist/js/scripts.js"; ?>"></script>
        <script src="<?= BASE_URL."assets/dist/js/custom.js"; ?>"></script>
        
        <!-- JS Login -->
        <script>
            const BASE_URL = "<?php print BASE_URL; ?>";
		    var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
        </script>
        <script src="<?= BASE_URL."app/views/layout/js/initNotif.js"; ?>"></script>
        <script src="<?= BASE_URL."app/views/auth/js/initLogin.js"; ?>"></script>
    </body>
</html>