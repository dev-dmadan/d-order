<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);

    if(TYPE === 'DEV') {
        // config base url
        define('BASE_URL', 'http://localhost/iSystemAsia/d-order/'); // isi path dari web
        define('SITE_URL', BASE_URL.'index.php/'); // hilangkan index.php atau komentari SITE_URL jika sudah memakai .htaccess
        define('DEFAULT_CONTROLLER', 'orders'); // default controller yg diakses pertama kali
        define('VERSION', 'Beta v0.1');

        // config database
        define('DB_HOST', 'localhost'); // host db
        define('DB_USERNAME', 'root'); // username db
        define('DB_PASSWORD', ''); // password db
        define('DB_NAME', 'mas-d-order'); // db yang digunakan
    }
    else if(TYPE === 'DEV_LIVE') {
        // config base url
        define('BASE_URL', 'https://d-order.bpmonline.asia/dev/');
        define('SITE_URL', BASE_URL.'index.php/');
        define('DEFAULT_CONTROLLER', 'orders');
        define('VERSION', 'Beta v0.1');

        // config database
        define('DB_HOST', 'localhost');
        define('DB_USERNAME', 'bpmonlin_full');
        define('DB_PASSWORD', 'k6&e-71A])d7');
        define('DB_NAME', 'bpmonlin_mas-d-order.dev');
    }
    else if(TYPE === 'TEST') {
        // config base url
        define('BASE_URL', 'https://d-order.bpmonline.asia/test/');
        define('SITE_URL', BASE_URL.'index.php/');
        define('DEFAULT_CONTROLLER', 'orders');
        define('VERSION', 'Beta v0.1');

        // config database
        define('DB_HOST', 'localhost');
        define('DB_USERNAME', 'bpmonlin_full');
        define('DB_PASSWORD', 'k6&e-71A])d7');
        define('DB_NAME', 'bpmonlin_mas-d-order.test');
    }
    else if(TYPE === 'PROD') {
        // config base url
        define('BASE_URL', 'https://d-order.bpmonline.asia/');
        define('SITE_URL', BASE_URL.'index.php/');
        define('DEFAULT_CONTROLLER', 'orders');
        define('VERSION', 'v1.0');

        // config database
        define('DB_HOST', 'localhost');
        define('DB_USERNAME', 'bpmonlin_full');
        define('DB_PASSWORD', 'k6&e-71A])d7');
        define('DB_NAME', 'bpmonlin_mas-d-order');
    }
    else { die(ACCESS_DENIED); }