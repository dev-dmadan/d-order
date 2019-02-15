<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class Items
     */
    class Items extends Controller
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
            $this->model('ItemsModel');
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
                'title' => 'Menu Item List',
                'property' => array(
                    'main' => 'Menu Item List', 'sub' => ''
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
                    "app/views/items/js/initList.js",
                    "app/views/items/js/initForm.js"
                ),
            );        
            $this->layout('items/list', $config);
        }

        /**
         * 
         */
        public function get_list() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $config = array(
					'tabel' => 'v_items',
					'kolomOrder' => array(null, 'name', 'price', 'status_name', null),
					'kolomCari' => array('name', 'price', 'status_name', 'description'),
					'orderBy' => array('id' => 'desc', 'status_id' => 'asc'),
					'kondisi' => false,
                );
                
                $dataItems = $this->DataTableModel->getAllDataTable($config);

                $data = array();
                $no_urut = $_POST['start'];
                foreach($dataItems as $row) {
                    $no_urut++;

                    $status = (strtolower($row['status_name']) == 'active') ? 
                        '<div class="badge badge-success">'.$row['status_name'].'</div>' : 
                        (
                            ($row['status_name'] == '' || empty($row['status_name'])) ? 
                                '<div class="badge badge-danger">NOT SET</div>' :
                                '<div class="badge badge-danger">'.$row['status_name'].'</div>'
                        );

                    $btnView = '<button onclick="getView('."'".$row["id"]."'".')" type="button" class="btn btn-sm btn-primary" title="View Detail"><i class="fa fa-eye"></i></button>';
                    $btnEdit = '<button onclick="getEdit('."'".$row["id"]."'".')" type="button" class="btn btn-sm btn-success" title="Update Item"><i class="fa fa-edit"></i></button>';
                    $btnDelete = '<button onclick="getDelete('."'".$row["id"]."'".')" type="button" class="btn btn-sm btn-danger" title="Delete Item"><i class="fa fa-trash"></i></button>';
                    $btnAction = '<div class="btn-group">'.$btnView.$btnEdit.$btnDelete.'</div>';

                    $dataRow = array();
                    $dataRow['no'] = $no_urut;
                    $dataRow['name'] = $row['name'];
                    $dataRow['price'] = $this->helper->cetakRupiah($row['price']);
                    $dataRow['status'] = $status;
                    $dataRow['option'] = $btnAction;

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
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                $data = isset($_POST) ? $_POST : false;
                $image = isset($_FILES['image']) ? $_FILES['image'] : false;

                $checkImage = true;

                if(!$data) {
                    $this->notif = array(
                        'type' => 'error',
                        'title' => 'Error Message',
                        'message' => 'Please try again'
                    );
                }
                else {
                    // data validation
                    $validation = $this->set_validation($data, $data['action']);
                    $cek = $validation['cek'];
                    $this->error = $validation['error'];

                    if($image) {
                        $config = array(
                            'jenis' => 'gambar',
							'error' => $image['error'],
							'size' => $image['size'],
							'name' => $image['name'],
							'tmp_name' => $image['tmp_name'],
							'max' => 2*1048576,
                        );
                        $validImage = $this->validation->validFile($config);
                        if(!$validImage['cek']) {
                            $cek = $checkImage = false;
                            $this->error['image'] = $validImage['error'];
                        }
                        else { $valueImage = md5($data['id']).$validImage['namaFile']; }
                    }
                    else { $valueImage = NULL; }

                    if($cek) {
                        $dataInsert = array(
                            'id' => $data['id'],
                            'name' => $data['name'],
                            'price' => $data['price'],
                            'description' => $data['description'],
                            'image' => $valueImage,
                            'status' => $data['status'],
                            'created_by' => $_SESSION['sess_id']
                        );

                        if($image) {
                            $path = ROOT.DS.'assets'.DS.'images'.DS.'items'.DS.$valueImage;
							if(!move_uploaded_file($image['tmp_name'], $path)){
								$this->error['image'] = "Fail upload image";
								$this->success = $checkImage = false;
							}
                        }
                        
                        if($checkImage) {
                            $insert = $this->ItemsModel->insert($dataInsert);
                            if($insert['success']) {
                                $this->success = true;
                                $this->notif = array(
                                    'type' => 'success',
                                    'title' => 'Success Message',
                                    'message' => 'Success add new menu item'
                                );
                            }
                            else {
                                $this->notif = array(
                                    'type' => 'error',
                                    'title' => 'Error Message',
                                    'message' => 'Please try again'
                                );
                                $this->message = $insert['error'];
                            }
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
                    'data' => array(
                        'post' => $data,
                        'image' => $image
                    )
                );

                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function edit($id) {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                if($id == '' || empty($id) || !$id) { die(ACCESS_DENIED); }
                else {
                    $data = !empty($this->ItemsModel->getById($id)) ?
                        $this->ItemsModel->getById($id) : false;

                    if($data) { $this->success = true; }
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
        public function action_edit() {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
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
                    $validation = $this->set_validation($data, $data['action']);
                    $cek = $validation['cek'];
                    $this->error = $validation['error'];

                    if($cek) {
                        $dataUpdate = array(
                            'id' => $data['id'],
                            'name' => $data['name'],
                            'price' => $data['price'],
                            'description' => $data['description'],
                            'status' => $data['status'],
                            'modified_by' => $_SESSION['sess_id']
                        );

                        $update = $this->ItemsModel->update($dataUpdate);
                        if($update['success']) {
                            $this->success = true;
                            $this->notif = array(
                                'type' => 'success',
                                'title' => 'Success Message',
                                'message' => 'Success edit menu item'
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
                    'data' => array(
                        'post' => $data,
                    )
                );

                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function action_edit_status() {

        }

        /**
         * 
         */
        public function action_edit_foto() {

        }

        /**
         * 
         */
        public function delete($id) {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                if($id == '' || empty($id) || !$id) { die(ACCESS_DENIED); }
                else {
                    $delete = $this->ItemsModel->delete($id);
                    if($delete['success']) {
                        $this->success = true;
                        $this->notif = array(
                            'type' => 'success',
                            'title' => 'Success Message',
                            'message' => 'Data deleted successfully',
                        );
                    }
                    else {
                        $this->message = $delete['error'];
                        $this->notif = array(
                            'type' => 'error',
                            'title' => 'Error Message',
                            'message' => 'Please try again'
                        );
                    }
                    
                    echo json_encode(array(
                        'success' => $this->success,
                        'message' => $this->message,
                        'notif' => $this->notif
                    ));
                }
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function detail($id) {
            $data_detail = !empty($this->ItemsModel->getById($id)) 
                ? $this->ItemsModel->getById($id) : false;

            if(!$data_detail || (empty($id) || $id == "")) { $this->redirect(BASE_URL."items/"); }
            
            $config = array();
            
            if(!empty($data_detail['image'])) {
                $filename = ROOT.DS.'assets'.DS.'images'.DS.'items'.DS.$data_detail['image'];
                if(!file_exists($filename)) { $image = BASE_URL.'assets/images/items/default.jpg'; }
                else { $image = BASE_URL.'assets/images/items/'.$data_detail['image']; }
            }
            else {$image = BASE_URL.'assets/images/items/default.jpg'; }

            $status = ($data_detail['status'] == 'ACTIVE') ?
                '<div class="badge badge-success">'.$data_detail['status'].'</span>' :
                '<div class="badge badge-danger">'.$data_detail['status'].'</span>';

            $data = array(
                'id' => $data_detail['id'],
                'name' => $data_Detail['name'],
                'price' => $data_detail['price'],
                'description' => $data_detail['description'],
                'image' => $image,
                'status' => $status
            );

            $this->layout('items/view', $config, $data);
        }

        /**
         * 
         */
        public function get_menu_select() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data_menu = $this->ItemsModel->getAll();
                $data = array();

                foreach($data_menu as $row) {
                    if($row['status_name'] === 'ACTIVE') {
                        $dataRow = array();
                        $dataRow['id'] = $row['id'];
                        $dataRow['text'] = $row['name'];

                        $data[] = $dataRow;
                    }
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
                $menu = $this->ItemsModel->getById($id);
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
        private function set_validation($data, $action) {
            $this->validation->set_rules($data['name'], 'Name', 'name', 'string | 1 | 255 | required');
            $this->validation->set_rules($data['price'], 'Price', 'price', 'nilai | 1 | 9999999 | required');
            $this->validation->set_rules($data['description'], 'Description', 'description', 'string | 1 | 255 | not_required');
            $this->validation->set_rules($data['status'], 'Status', 'status', 'angka | 1 | 10 | required');

            return $this->validation->run();
        }
    }
    