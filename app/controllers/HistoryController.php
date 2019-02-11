<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class History
     */
    class History extends Controller {

        private $error = array();
        private $notif = array();
        private $message = NULL;
        private $success = false;

        /**
         * Construct
         * Load default library
         */
        public function __construct() {
            $this->auth();
            $this->auth->checkAuth();
            $this->helper();
            $this->validation();
            $this->model('OrdersModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            $this->list();
        }

        /**
         * 
         */
        private function list() {
            $this->view('history/list', $data = null);
        }

    }
    