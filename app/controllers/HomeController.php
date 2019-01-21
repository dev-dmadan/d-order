<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class home
     * Default class
     */
    class Home extends Controller
    {
        private $username;
        private $password;
        private $error = array();
        private $notif = array();
        private $success = false;

        /**
         * Construct
         * Load default library
         */
        public function __construct() {
            $this->auth();
            $this->auth->checkAuth();
            $this->validation();
            $this->model('OrdersModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            if($_SESSION['sess_level'] === '') {

            }
        }
    }
    