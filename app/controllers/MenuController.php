<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class menu
     */
    class Menu extends Controller
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
            $this->model('MenuModel');
            $this->model('DataTableModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            if($_SESSION['sess_level'] === 'ADMIN') { $this->list(); }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        private function list() {            
            $this->view('menu/list', $data = null);
        }

        /**
         * 
         */
        public function get_list() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $config = array(
					'tabel' => 'v_menu',
					'kolomOrder' => array(null, 'name', 'price', 'description', 'kota', 'total', 'progress', 'status', null),
					'kolomCari' => array('id', 'pemilik', 'tgl', 'pembangunan', 'luas_area', 'kota', 'total', 'status', 'progress'),
					'orderBy' => array('id' => 'desc', 'status' => 'asc'),
					'kondisi' => false,
                );
                
                $dataMenu = $this->DataTableModel->getAllDataTable($config);

                $data = array();
                $no_urut = $_POST['start'];
                foreach($dataMenu as $row) {
                    $no_urut++;

                    $status = (strtolower($row['status']) == 'ACTIVE') ? '<div class="badge badge-success">'.$row['status'].'</div>' : 
                        ($row['status'] == '' || empty($row['status'])) ? '<div class="badge badge-danger">NOT SET</div>' :
                        '<div class="badge badge-danger">'.$row['status'].'</div>';

                    $btnEdit = '';
                    $btnDelete = '';
                    $btnAction = '<div class="btn-group">'.$btnEdit.$btnDelete.'</div>';

                    $dataRow = array();
                    $dataRow[] = null;
                    $dataRow['no'] = $no_urut;
                    $dataRow['name'] = $row['name'];
                    $dataRow['price'] = $row['price'];
                    $dataRow['status'] = $row['description'];
                    $dataRow['description'] = $status;
                    $dataRow['images'] = $btnAction;

                    $data[] = $dataRow;
                }

                $output = array(
					'draw' => $_POST['draw'],
					'recordsTotal' => $this->DataTableModel->recordTotal(),
					'recordsFiltered' => $this->DataTableModel->recordFilter(),
					'data' => $data,
				);

				echo json_encode($output);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function action_add() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function edit($id) {

        }

        /**
         * 
         */
        public function action_edit() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function detail($id) {

        }

        /**
         * 
         */
        public function get_menu_select() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data_menu = $this->MenuModel->getAll();
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
        public function get_price() {
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $menu = $this->MenuModel->getById($id);
                $this->success = (empty($menu)) ? false : true;

                $result = array(
                    'success' => $this->success,
                    'data' => ($this->success) ? (($menu['price'] == '' || empty($menu['price'])) ? 0 : $menu['price']) : 0
                );

                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        private function set_validation($data) {

        }
    }
    