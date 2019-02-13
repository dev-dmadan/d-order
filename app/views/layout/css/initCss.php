<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- General CSS Files -->
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap/css/bootstrap.min.css"; ?>">
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/fontawesome/css/all.min.css"; ?>">

<!-- CSS Libraries -->
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/izitoast/css/iziToast.min.css"; ?>">
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/select2/dist/css/select2.min.css"; ?>">
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/modules/bootstrap-daterangepicker/daterangepicker.css"; ?>">

<!-- Custom CSS -->
<?php 
    if(method_exists($this, 'getCSS')) { $this->getCSS(); } 
?>

<!-- Template CSS -->
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/style.css"; ?>">
<link rel="stylesheet" href="<?= BASE_URL."assets/dist/css/components.css"; ?>">