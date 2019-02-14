<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Login &mdash; Mas'D Order</title>

        <!-- <link rel="icon" href="<?= BASE_URL."assets/images/"; ?>" type='image/x-icon'> -->
        <?php require_once "app/views/layout/css/initCss.php"; ?>
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

                                        <!-- username -->
                                        <div class="form-group has-feedback">
                                            <label for="username">Username</label>
                                            <input id="username" type="text" class="form-control field" tabindex="1" autofocus>
                                            <div class="message-username"></div>
                                        </div>

                                        <!-- password -->
                                        <div class="form-group has-feedback">
                                            <label for="password">Password</label>
                                            <input id="password" type="password" class="form-control field" tabindex="2">
                                            <div class="message-password"></div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <button type="submit" id="submit-login" class="btn btn-primary btn-lg btn-block" tabindex="3">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-5 text-muted text-center">
                                Don't have an username? <a href="#" id="btn-form-register">Register and Tell Mas'D</a>
                            </div>
                            <div class="simple-footer">
                                <strong>Mas'D Order | Copyright &copy; <?php echo date("Y"); ?> <a href="<?= BASE_URL ?>">Team iSure++</a>.</strong> All rights reserved. | Powered By i-SystemAsia</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include_once('register.php'); ?>

        <script>
            const BASE_URL = "<?php print BASE_URL; ?>";
            var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
        </script>
        <?php require_once "app/views/layout/js/initJs.php"; ?>
        <script src="<?= BASE_URL."app/views/auth/js/initLogin.js"; ?>"></script>
        <script src="<?= BASE_URL."app/views/auth/js/initRegister.js"; ?>"></script>
    </body>
</html>