<?php

    date_default_timezone_set('Asia/Jakarta');
    session_start();

    /**
     * Default Define
     */
    define("BASE_PATH", true);
	define('ROOT', dirname(__FILE__)); // root file web
    define('DS', DIRECTORY_SEPARATOR); // pemisah direktori '\'
    define('ACCESS_DENIED', json_encode(array('success' => false, 'message' => 'Access Denied'), JSON_PRETTY_PRINT));
    /**
     * TYPE ENVIROMENT DEVELOPMENT
     * DEV --> for Local development
     * DEV_LIVE --> for Live development
     * TEST --> for Testing (Pre Production)
     * PROD --> for Production
     */
    define('TYPE', 'DEV');

    /**
     * Default Load Config and Library
     */
    require_once "app/configs/config.php";  
    require_once "app/configs/route.php";
    require_once "app/libraries/Auth.class.php";
    require_once "app/libraries/Controller.class.php";
    require_once "app/libraries/Database.class.php";
    require_once "app/libraries/DataTable.class.php";
    require_once "app/libraries/Page.class.php";
    require_once "app/libraries/Validation.class.php";
    require_once "app/libraries/Helper.class.php";
    require_once "app/libraries/Excel.class.php";

    $request = isset($_SERVER['PATH_INFO']) ? preg_replace("|/*(.+?)/*$|", "\\1", $_SERVER['PATH_INFO']) : DEFAULT_CONTROLLER;

	$route = new Route();
	$route->setUri($request)->getController();
