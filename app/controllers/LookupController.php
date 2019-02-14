<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class Lookup
     */
    class Lookup extends Controller
    {
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
            $this->model('LookupModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            echo json_encode(array(
                'success' => true,
                'message' => 'Please choose lookup what you want to get',
                'lookup' => array(
                    array(
                        'method' => 'get_active_status_select',
                        'request' => 'POST',
                        'param' => '',
                        'output' => 'JSON'
                    ),
                    array(
                        'method' => 'get_order_status_select',
                        'request' => 'POST',
                        'param' => '',
                        'output' => 'JSON'
                    ) 
                ),
                'error' => NULL
            ), JSON_PRETTY_PRINT);
        }

        /**
         * 
         */
        public function get_active_status_select() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data_menu = $this->LookupModel->getAll_activeStatus();
                $data = array();

                foreach($data_menu as $row) {
                    $dataRow = array();
                    $dataRow['id'] = $row['id'];
                    $dataRow['text'] = $row['name'];

                    $data[] = $dataRow;
                }

                echo json_encode($data);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function get_order_status_select() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data_menu = $this->LookupModel->getAll_orderStatus();
                $data = array();

                foreach($data_menu as $row) {
                    $dataRow = array();
                    $dataRow['id'] = $row['id'];
                    $dataRow['text'] = $row['name'];

                    $data[] = $dataRow;
                }

                echo json_encode($data);
            }
            else { die(ACCESS_DENIED); }
        }
    }
    