<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class User
     */
    class User extends Controller
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
            if($_SESSION['sess_level'] === 'ADMIN') { $this->list(); }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        private function list() {
            $config = array(
                'title' => 'User List',
                'property' => array(
                    'main' => 'User List', 'sub' => ''
                ),
                'css' => array(
                    "assets/dist/modules/datatables/datatables.min.css",
                    "assets/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css",
                    "assets/dist/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css",
                ),
                'js' => array(
                    "assets/dist/modules/input-mask/jquery.inputmask.bundle.js",
                    "assets/dist/modules/datatables/datatables.min.js",
                    "assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
                    "assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js",
                    "app/views/user/js/initList.js"
                ),
            );        
            $this->layout('user/list', $config);
        }

        /**
         * 
         */
        public function get_list() {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                $config = array(
					'tabel' => 'v_user',
					'kolomOrder' => array(null, 'username', 'name', 'level_id', 'status_id', null),
					'kolomCari' => array('username', 'name', 'level_name', 'status_name'),
					'orderBy' => array('level_id' => 'asc', 'status_id' => 'asc'),
                    'kondisi' => false,
				);

				$dataUser = $this->DataTableModel->getAllDataTable($config);

				$data = array();
				$no_urut = $_POST['start'];
				foreach($dataUser as $row){
					$no_urut++;

                    // button aksi
					// $aksiDetail = '<button onclick="getView('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fa fa-eye"></i></button>';
					$btnEdit = '<button onclick="getEdit('."'".strtolower($row["username"])."'".')" type="button" class="btn btn-sm btn-success" title="Update Status"><i class="fa fa-edit"></i></button>';
					// $aksiHapus = '<button onclick="getDelete('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></button>';
					
					$option = '<div class="btn-group">'.$btnEdit.'</div>';

                    if($row['status_name'] == 'ACTIVE') { $status = '<div class="badge badge-success">'; }
                    else { $status = '<div class="badge badge-danger">'; }
                    $status .= $row['status_name'].'</div>';

                    if($row['level_name'] == 'ADMIN') { $level = '<div class="badge badge-success">'; }
                    else { $level = '<div class="badge badge-primary">'; }
                    $level .= $row['level_name'].'</div>';

                    $dataRow = array();
                    $dataRow[] = null;
                    $dataRow['no'] = $no_urut;
                    $dataRow['username'] = $row['username'];
                    $dataRow['name'] = $row['name'];
                    $dataRow['level'] = $level;
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
        public function get_edit_status($username) {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                $result = array(
                    'success' => $this->success,
                    'notif' => $this->notif,
                    'data' => '',
                    'username' => $username
                );

                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function action_edit_status() {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {

            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        private function set_validation($data) {

        }
    }
    