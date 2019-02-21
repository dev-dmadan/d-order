<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class Profile
     */
    class Profile extends Controller
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
            $this->model('UserModel');
            $this->model('DataTableModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            $this->detail();
        }

        /**
         * 
         */
        private function detail() {
            $config = array(
                'title' => 'Profile',
                'property' => array(
                    'main' => 'User Profile', 'sub' => ''
                ),
                'css' => array(
                    "assets/dist/modules/datatables/datatables.min.css",
                    "assets/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css",
                    "assets/dist/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css",
                    // "app/views/profile/css/cardCustom.css"
                ),
                'js' => array(
                    "assets/dist/modules/input-mask/jquery.inputmask.bundle.js",
                    "assets/dist/modules/datatables/datatables.min.js",
                    "assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
                    "assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js",
                    "app/views/profile/js/initView.js"
                ),
            );        
            $this->layout('profile/view', $config);
        }

        /**
         * 
         */
        public function get_list_order_history() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $config = array(
					'tabel' => 'v_orders',
					'kolomOrder' => array(null, null, 'order_number', 'money', 'total', 'change_money', 'status_id', null),
					'kolomCari' => array('order_number', 'order_date', 'total', 'money', 'change_money', 'status_name'),
					'orderBy' => array('order_number' => 'desc', 'status_id' => 'asc'),
                    'kondisi' => 'WHERE user = "'.$_SESSION['sess_id'].'"',
				);

				$dataOrder = $this->DataTableModel->getAllDataTable($config);

				$data = array();
				$no_urut = $_POST['start'];
				foreach($dataOrder as $row){
					$no_urut++;

                    // button aksi
					$btnDetail = '<button onclick="getView('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-info" title="View Detail"><i class="fa fa-eye"></i></button>';
					
					$option = '<div class="btn-group">'.$btnDetail.'</div>';

                    switch ($row['status_id']) {
                        // pending
                        case 1 :
                            $status = '<div class="badge badge-primary">';
                            break;
                        
                        // process
                        case 2 :
                            $status = '<div class="badge badge-info">';
                            break;

                        // delivered
                        case 3 :
                            $status = '<div class="badge badge-success">';
                            break;

                        // reject
                        default:
                            $status = '<div class="badge badge-danger">';
                            break;
                    }

                    $status .= $row['status_name'].'</div>';
					
                    $dataRow = array();
                    $dataRow[] = null;
                    $dataRow['no'] = $no_urut;
                    $dataRow['order_number'] = $row['order_number'];
                    $dataRow['money'] = $this->helper->cetakRupiah($row['money']);
					$dataRow['total'] = $this->helper->cetakRupiah($row['total']);
                    $dataRow['change_money'] = $this->helper->cetakRupiah($row['change_money']);
                    $dataRow['status'] = $status;
                    $dataRow['option'] = $option;

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
        public function get_edit_profile($username) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if($username == '' || empty($username) || !$username) { die(ACCESS_DENIED); }
                else {
                    $data = !empty($this->UserModel->getById($username)) ?
                        $this->UserModel->getById($username) : false;

                    if($data) { 
                        $this->success = true;
                        unset($data['password']);
                        unset($data['level_id']);
                        unset($data['level_name']);
                        unset($data['status_id']);
                        unset($data['status_name']);
                    }
                    else {
                        $this->notif = array(
                            'type' => 'warning',
                            'title' => 'Warning message',
                            'message' => "Sorry we can't find any data"
                        );
                    }

                    $result = array(
                        'success' => $this->success,
                        'notif' => $this->notif,
                        'data' => $data
                    );

                    echo json_encode($result);
                }
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function update_profile() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = isset($_POST) ? $_POST : false;

                if(!$data) {
                    $this->notif = array(
                        'type' => 'error',
                        'title' => 'Error Message',
                        'message' => 'Please try again'
                    );
                }
                else {
                    // data validation
                    $validation = $this->set_validation($data);
                    $cek = $validation['cek'];
                    $this->error = $validation['error'];

                    if($cek) {
                        $dataUpdate = array(
                            'name' => $data['name'],
                            'modified_by' => $_SESSION['sess_id']
                        );

                        $update = $this->UserModel->update($dataUpdate);
                        if($update['success']) {
                            $this->success = true;
                            $this->notif = array(
                                'type' => 'success',
                                'title' => 'Success Message',
                                'message' => 'Success edit profile'
                            );
                        }
                        else {
                            $this->notif = array(
                                'type' => 'error',
                                'title' => 'Error Message',
                                'message' => 'Please try again'
                            );
                            $this->message = $update['error'];
                        }
                    }
                    else {
                        $this->notif = array(
                            'type' => 'warning',
                            'title' => 'Warning Message',
                            'message' => 'Please check your form'
                        );
                    }
                }

                $result = array(
                    'success' => $this->success,
                    'notif' => $this->notif,
                    'error' => $this->error,
                    'message' => $this->message,
                    // 'data' => array(
                    //     'post' => $data,
                    // )
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
    