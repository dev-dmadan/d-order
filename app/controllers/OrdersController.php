<?php

    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
    /**
     * Class Orders
     * Default class
     */
    class Orders extends Controller
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
            $this->model('OrdersModel');
            $this->model('DataTableModel');
        }
        
        /**
         * Method index
         */
        public function index() {
            if($_SESSION['sess_level'] === 'ADMIN') { $this->list(); }
            else if($_SESSION['sess_level'] === 'MEMBERS') { $this->form(); }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        private function list() {
            $config = array(
                'title' => 'Order List',
                'property' => array(
                    'main' => 'Order List Today..', 'sub' => ''
                ),
                'css' => array(
                    "assets/dist/modules/datatables/datatables.min.css",
                    "assets/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css",
                    "assets/dist/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css",
                    "app/views/orders/css/dataTable_detail.css"
                ),
                'js' => array(
                    "assets/dist/modules/input-mask/jquery.inputmask.bundle.js",
                    "assets/dist/modules/datatables/datatables.min.js",
                    "assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
                    "assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js",
                    "app/views/orders/js/initList.js"
                ),
            );

            $this->layout('orders/list', $config);
        }

        /**
         * 
         */
        public function get_list() {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['sess_level'] === 'ADMIN') {
                $config = array(
					'tabel' => 'v_orders',
					'kolomOrder' => array(null, null, 'order_number', 'user', 'money', 'total', 'change_money', 'status_id', null),
					'kolomCari' => array('order_number', 'order_date', 'total', 'money', 'change_money', 'status_name'),
					'orderBy' => array('order_number' => 'desc', 'status_id' => 'asc'),
                    'kondisi' => "WHERE order_date = CURDATE()",
				);

				$dataOrder = $this->DataTableModel->getAllDataTable($config);

				$data = array();
				$no_urut = $_POST['start'];
				foreach($dataOrder as $row){
					$no_urut++;

                    // button aksi
					// $aksiDetail = '<button onclick="getView('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fa fa-eye"></i></button>';
					$aksiEdit = '<button onclick="getEdit('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-success" title="Update Status"><i class="fa fa-edit"></i></button>';
					// $aksiHapus = '<button onclick="getDelete('."'".strtolower($row["order_number"])."'".')" type="button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></button>';
					
					$aksi = '<div class="btn-group">'.$aksiEdit.'</div>';

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
                    $dataRow['user'] = $row['user'];
                    $dataRow['money'] = $this->helper->cetakRupiah($row['money']);
					$dataRow['total'] = $this->helper->cetakRupiah($row['total']);
                    $dataRow['change_money'] = $this->helper->cetakRupiah($row['change_money']);
                    $dataRow['status'] = $status;
                    $dataRow['option'] = $aksi;

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
        public function get_list_detail() {
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                $order_number = (isset($_GET['order_number']) && !empty($_GET['order_number'])) ? strtoupper($_GET['order_number']) : false;
                $dataDetail = !empty($this->OrdersModel->getDetailById($order_number)) ? $this->OrdersModel->getDetailById($order_number) : false;
                
                if(!$order_number || !$dataDetail) { die(ACCESS_DENIED); }
                else {
                    $this->success = true;
                    
                    $data = array();
                    foreach($dataDetail as $row) {
                        $temp = $row;
                        $temp['subtotal_full'] = $this->helper->cetakRupiah($row['subtotal']);
                        $data[] = $temp;
                    }

                    $output = array(
                        'success' => $this->success,
                        'data' => $data
                    );

                    echo json_encode($output);
                }
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function history() {
            $config = array(
                'title' => 'Order History',
                'property' => array(
                    'main' => 'List All My Order', 'sub' => ''
                ),
                'css' => array(
                    "assets/dist/modules/datatables/datatables.min.css",
                    "assets/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css",
                    "assets/dist/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css",
                    "app/views/orders/css/dataTable_detail.css"
                ),
                'js' => array(
                    "assets/dist/modules/datatables/datatables.min.js",
                    "assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
                    "assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js",
                    "app/views/orders/js/initHistory.js"
                ),
            );

            $this->layout('orders/history', $config);
        }

        /**
         * 
         */
        public function get_list_history() {
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
        public function form() {
            $this->add();
        }

        /**
         * 
         */
        private function add() {
            $config = array(
                'title' => 'Order Form',
                'property' => array(
                    'main' => 'Please Order..', 'sub' => ''
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
                    "app/views/orders/js/initForm.js"
                ),
            );

            $data = array(
                'action' => 'action-add',
                'order_number' => $this->getIncrement(),
                'order_date' => date('Y-m-d'),
                'money' => 0,
                'notes' => '',
                'status' => $this->getStatusOrder('PENDING')
            );
            $this->layout('orders/form', $config, $data);
        }

        /**
         * 
         */
        public function action_add() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = isset($_POST) ? $_POST : false;
                $dataOrder = isset($_POST['dataOrder']) ? json_decode($_POST['dataOrder'], true) : false;
                $dataDetail = isset($_POST['dataDetail']) ? json_decode($_POST['dataDetail'], true) : false;
                
                $cekDetail = true;

                if(!$data) {
                    $this->notif['order'] = array(
                        'type' => 'error',
                        'title' => 'Error Message',
                        'message' => 'Please try again'
                    );
                }
                else {
                    // data validation
                    $validation = $this->set_validation($dataOrder, $data['action']);
                    $cek = $validation['cek'];
                    $this->error = $validation['error'];

                    if(!$this->helper->cekArray($dataDetail)) {
                        $cek = $cekDetail = false;
                    }

                    if($cek) {
                        $data_insertOrder = array(
                            'id' => $dataOrder['id'],
                            'date' => $dataOrder['date'],
                            'money' => $dataOrder['money'],
                            'notes' => $dataOrder['notes'],
                            'change_money' => $dataOrder['change_money'],
                            'total' => $dataOrder['total'],
                            'status' => $dataOrder['status'],
                            'user' => $_SESSION['sess_id']
                        );

                        $dataInsert = array(
                            'dataOrder' => $data_insertOrder,
                            'dataDetail' => $dataDetail
                        );

                        $insert = $this->OrdersModel->insert($dataInsert);
                        if($insert['success']) {
                            $this->success = true;
                            $_SESSION['notif'] = array(
                                'type' => 'success',
                                'title' => 'Success Message',
                                'message' => 'Success to order, please wait, your order will be process'
                            );
                            $this->notif['order'] = $_SESSION['notif'];
                        }
                        else {
                            $this->notif['order'] = array(
                                'type' => 'error',
                                'title' => 'Error Message',
                                'message' => 'Please try again'
                            );
                            $this->message = $insert['error'];
                        }
                    }
                    else {
                        if(!$cekDetail) {
                            $this->notif['order_detail'] = array(
                                'type' => 'warning',
                                'title' => 'Warning Message',
                                'message' => 'Please check your order detail'
                            );
                        }

                        $this->notif['order'] = array(
                            'type' => 'warning',
                            'title' => 'Warning Message',
                            'message' => 'Please check your form'
                        );
                    }
                }

                $result = array(
                    'success' => $this->success,
                    'cek' => array(
                        'order_detail' => $cekDetail
                    ),
                    'notif' => $this->notif,
                    'error' => $this->error,
                    'message' => $this->message,
                    'data' => array(
                        'post' => $data,
                        'dataOrder' => $dataOrder,
                        'dataDetail' => $dataDetail
                    )
                );

                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function action_add_detail() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = isset($_POST) ? $_POST : false;

				$validation = $this->set_validation_detail($data);
				$cek = $validation['cek'];
				$this->error = $validation['error'];

				if($cek) {
                    $this->success = true;
                    $data['delete'] = ($data['delete'] === 'true') ? true : false;
                    $data['price_full'] = $this->helper->cetakRupiah($data['price']);
                    $data['subtotal_full'] = $this->helper->cetakRupiah($data['subtotal']);
				}

				$output = array(
					'success' => $this->success,
					'error' => $this->error,
					'data' => $data
				);

				echo json_encode($output);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function set_rupiah($value) {
            echo json_encode($this->helper->cetakRupiah($value));
        }

        private function getStatusOrder($name) {
            $result = false;

            $this->model('Status_orderModel');
            $statusOrder = !empty($this->Status_orderModel->getByName($name)) ? 
                $this->Status_orderModel->getByName($name) : false;
            
            if($statusOrder) {
                $result = array(
                    'id' => $statusOrder['id'],
                    'name' => $statusOrder['name']
                );
            }

            return $result;
        }

        /**
         * 
         */
        private function getIncrement() {
            $this->model('IncrementModel');
            $order_number = '';
            $increment = $this->IncrementModel->get_increment('orders');
            
            if($increment['success']) {
                $getYear = date('Y');
                $getMask = explode('-', $increment['mask']);
                $order_number = $getMask[0].'-'.$getYear.sprintf("%03s", $increment['increment']);
            }

            return $order_number;
        }

        /**
         * 
         */
        private function set_validation($data) {
            $this->validation->set_rules($data['id'], 'Order Number', 'order_number', 'string | 1 | 50 | required');
            $this->validation->set_rules($data['date'], 'Order Date', 'order_date', 'string | 10 | 10 | required');
            $this->validation->set_rules($data['money'], 'Money', 'money', 'nilai | 1 | 999999 | required');
            $this->validation->set_rules($data['notes'], 'Notes', 'notes', 'string | 1 | 999 | not_required');

            return $this->validation->run();
        }

        /**
         * 
         */
        private function set_validation_detail($data) {
            // $required = strtolower($data['menu_name']) == 'others' ? 'required' : 
            $this->validation->set_rules($data['item'], 'Menu', 'menu', 'angka | 1 | 10 | required');
            $this->validation->set_rules($data['order_item'], 'Others Menu', 'menu_name', 'string | 1 | 255 | required');
            $this->validation->set_rules($data['price'], 'Price', 'price', 'nilai | 1 | 9999999 | required');
            $this->validation->set_rules($data['qty'], 'Qty', 'qty', 'nilai | 1 | 999 | required');

            return $this->validation->run();
        }
    }
    