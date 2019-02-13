<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

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
<script src="<?= BASE_URL."assets/dist/modules/jquery-ui/jquery-ui.min.js"; ?>"></script>

<!-- Template JS File -->
<script src="<?= BASE_URL."assets/dist/js/scripts.js"; ?>"></script>

<!-- Base Function -->
<script src="<?= BASE_URL."app/views/layout/js/baseFunction.js"; ?>"></script>
<!-- Page Specific JS File -->
<?php 
    if(method_exists($this, 'getJS')) { $this->getJS(); }
?>

<script src="<?= BASE_URL."assets/dist/js/custom.js"; ?>"></script>