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
        <title><?= $this->title; ?></title>

        <!-- load default css -->
        <?php require_once "layout/css/initCss.php"; ?>

    </head>

    <body class="layout-3">

        <div id="app">
            <div class="main-wrapper container">

                <?php
                    echo $this->header;
                    echo $this->sidebar;
                    echo $this->content;
                    echo $this->footer;
                ?>

            </div>
            <!-- end main-wrapper container -->

        </div>
        <!-- end id app -->

        <!-- load default js -->
        <script>
            const BASE_URL = "<?php print BASE_URL; ?>";
            const USER_ID = "<?php print $_SESSION['sess_id']; ?>";
            const LEVEL = "<?php print $_SESSION['sess_level']; ?>";
            var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;    
        </script>
        
        <?php
            require_once "layout/js/initJs.php";
            ?>
                <script>
                    $(document).ready(function() {
                        setActiveMenu($(location).attr("href").split('/'), LEVEL);
                    });
                </script>
            <?php
            if($sess_welcome) {
                ?>
                <script>
                    $(document).ready(function() {
                        var notifWelcome = {type: 'success', title: '', message: 'Welcome to D\'Order'};
                        setNotif(notifWelcome, 'toastr');
                    });
                </script>
                <?php
            }

            if($sess_notif) {
                ?>
                <script>
                    var sessNotif = <?php echo json_encode($sess_notif);?>;
                    $(document).ready(function() {
                        setNotif(sessNotif, 'toastr');
                    });
                </script>
                <?php
            }
        ?>
        
    </body>
</html>