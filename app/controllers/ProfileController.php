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
                    "app/views/orders/css/dataTable_detail.css"
                ),
                'js' => array(
                    "assets/dist/modules/input-mask/jquery.inputmask.bundle.js",
                    "assets/dist/modules/datatables/datatables.min.js",
                    "assets/dist/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
                    "assets/dist/modules/datatables/Select-1.2.4/js/dataTables.select.min.js",
                    "assets/dist/modules/chart.min.js",
                    "app/views/profile/js/initView.js"
                ),
            );
            
            $getAnalytics = $this->get_analytics_order();
            $getAverage = $this->get_average_amount_spend($_SESSION['sess_id']);
            $data = array(
                'total_orders' => $getAnalytics['total_orders'],
                'amount_spend' => $this->helper->cetakRupiah($getAnalytics['amount_spend']),
                'top_orders' => $getAnalytics['top_orders'],
                'total_status' => $getAnalytics['total_status'],
                'average' => $getAverage
            );

            // echo '<pre>';
            // var_dump($data);
            // echo '</pre>';
            // die();

            $this->layout('profile/view', $config, $data);
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

                    switch ($row['status_name']) {
                        // pending
                        case 'PENDING' :
                            $status = '<div class="badge badge-primary">';
                            break;
                        
                        // process
                        case 'PROCESS' :
                            $status = '<div class="badge badge-info">';
                            break;

                        // delivered
                        case 'DONE' :
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
        private function get_analytics_order() {
            $this->model('OrdersModel');
            $total_orders = $this->OrdersModel->getTotalOrders_byId($_SESSION['sess_id']) ? 
                $this->OrdersModel->getTotalOrders_byId($_SESSION['sess_id'])['total_orders'] : 0;
            $amount_spend =  $this->OrdersModel->getAmountSpend_byId($_SESSION['sess_id']) ? 
                $this->OrdersModel->getAmountSpend_byId($_SESSION['sess_id'])['amount_spend'] : 0;
            $top_orders = !empty($this->OrdersModel->getTopOrders_byId($_SESSION['sess_id'])) ?
                $this->OrdersModel->getTopOrders_byId($_SESSION['sess_id']) : false;
            $total_status = array(
                'DONE' => $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'DONE') ? 
                    $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'DONE')['total_status'] : 0,
                'PROCESS' => $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'PROCESS') ? 
                    $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'PROCESS')['total_status'] : 0,
                'PENDING' => $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'PENDING') ? 
                    $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'PENDING')['total_status'] : 0,
                'REJECT' => $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'REJECT') ? 
                    $this->OrdersModel->getTotalStatus_byId($_SESSION['sess_id'], 'REJECT')['total_status'] : 0
            );
            
            if($top_orders) {
                $temp_top_orders = array();
                foreach($top_orders as $item) {
                    $temp = $item;
                    if(!empty($item['image'])) {
                        // cek foto di storage
                        $filename = ROOT.DS.'assets'.DS.'images'.DS.'user'.DS.$item['image'];
                        if(!file_exists($filename)) { $temp['image'] = BASE_URL.'assets/images/user/default.jpg'; }
                        else { $temp['image'] = BASE_URL.'assets/images/user/'.$item['image']; }
                    }
                    else { $temp['image'] = BASE_URL.'assets/images/user/default.jpg'; }
                    $temp_top_orders[] = $temp;
                }
                $top_orders = $temp_top_orders;
            }

            $data = array(
                'total_orders' => $total_orders,
                'amount_spend' => $amount_spend,
                'top_orders' => $top_orders,
                'total_status' => $total_status,
            );

            return $data;
        }

        /**
         * 
         */
        private function get_average_amount_spend($username) {
            $this->model('OrdersModel');
            // get today
            $interval = ($this->helper->getDate(date('Y-m-d'), 'day', 'english') == 'Monday') ? 3 : 1;
            $getYesterday = $this->OrdersModel->getAmountSpend_todayById($username, $interval) ? 
                $this->OrdersModel->getAmountSpend_todayById($username, $interval)['average'] : 0;
            $getToday = $this->OrdersModel->getAmountSpend_todayById($username, 0) ? 
                $this->OrdersModel->getAmountSpend_todayById($username, 0)['average'] : 0;
            $percentToday = ($getYesterday == 0) ? 
                0 : ($getToday - $getYesterday) / $getYesterday * 100;

            // get week
            $getWeek = $this->OrdersModel->getaverage_amountSpend_weekById($username) ? 
                $this->OrdersModel->getaverage_amountSpend_weekById($username) : array('average_current_week' => 0, 'average_last_week' => 0);
            $percentWeek = ($getWeek['average_last_week'] == 0) ? 
                0 : ($getWeek['average_current_week'] - $getWeek['average_last_week']) / $getWeek['average_last_week'] * 100;

            // get month
            $getMonth = $this->OrdersModel->getaverage_amountSpend_monthById($username) ? 
                $this->OrdersModel->getaverage_amountSpend_monthById($username) : array('average_current_month' => 0, 'average_last_month' => 0);
            $percentMonth = ($getMonth['average_last_month'] == 0) ? 
                0 : ($getMonth['average_current_month'] - $getMonth['average_last_month']) / $getMonth['average_last_month'] * 100;

            // get year
            $getYear = $this->OrdersModel->getaverage_amountSpend_yearById($username) ? 
                $this->OrdersModel->getaverage_amountSpend_yearById($username) : array('average_current_year' => 0, 'average_last_year' => 0);
            $percentYear = ($getYear['average_last_year'] == 0) ? 
                0 : ($getYear['average_current_year'] - $getYear['average_last_year']) / $getYear['average_last_year'] * 100;

            $data = array(
                'today' => array(
                    'color' => ($percentToday == 0) ? '' : (($percentToday < 0) ? 'text-success' : 'text-danger'),
                    'icon' => ($percentToday == 0) ? '' : (($percentToday < 0) ? 'fas fa-caret-down' : 'fas fa-caret-up'),
                    'value' => $this->helper->cetakRupiah($getToday),
                    'percent' => $this->helper->cetakAngka($percentToday).' %'
                ),
                'week' => array(
                    'color' => ($percentWeek == 0) ? '' : (($percentWeek < 0) ? 'text-success' : 'text-danger'),
                    'icon' => ($percentWeek == 0) ? '' : (($percentWeek < 0) ? 'fas fa-caret-down' : 'fas fa-caret-up'),
                    'value' => $this->helper->cetakRupiah($getWeek['average_current_week']),
                    'percent' => $this->helper->cetakAngka($percentWeek).' %'
                ),
                'month' => array(
                    'color' => ($percentMonth == 0) ? '' : (($percentMonth < 0) ? 'text-success' : 'text-danger'),
                    'icon' => ($percentMonth == 0) ? '' : (($percentMonth < 0) ? 'fas fa-caret-down' : 'fas fa-caret-up'),
                    'value' => $this->helper->cetakRupiah($getMonth['average_current_month']),
                    'percent' => $this->helper->cetakAngka($percentMonth).' %'
                ),
                'year' => array(
                    'color' => ($percentYear == 0) ? '' : (($percentYear < 0) ? 'text-success' : 'text-danger'),
                    'icon' => ($percentYear == 0) ? '' : (($percentYear < 0) ? 'fas fa-caret-down' : 'fas fa-caret-up'),
                    'value' => $this->helper->cetakRupiah($getYear['average_current_year']),
                    'percent' => $this->helper->cetakAngka($percentYear).' %'
                )
            );

            return $data;
        }

        /**
         * 
         */
        public function get_chart($username) {
            if($_SERVER['REQUEST_METHOD'] === 'POST' && $username === $_SESSION['sess_id']) {
                $action = isset($_POST['action']) ? $_POST['action'] : 'week';
                $this->model('OrdersModel');
                if($action == 'week') {
                    $getData = !empty($this->OrdersModel->getOrder_currentWeek_byId($username)) ? 
                        $this->OrdersModel->getOrder_currentWeek_byId($username) : false;
                    $steps = 20000;
                }
                else if($action == 'month') {
                    $getData = !empty($this->OrdersModel->getOrder_currentMonth_byId($username)) ? 
                        $this->OrdersModel->getOrder_currentMonth_byId($username) : false;
                    $steps = 50000;
                }
                else { die(ACCESS_DENIED); }

                if($getData) {
                    $this->success = true;
                    $labels = $data = array();
                    foreach($getData as $item) {
                        if($action == 'month') { $labels[] = $this->helper->getDate($item['order_date'], 'month', 'english'); }
                        else { $labels[] = $this->helper->getDate($item['order_date'], 'day', 'english'); }
                        $data[] = $item['total'];
                    }

                    $datasets = array(
                        'data' => $data,
                    );
                }
                else {
                    
                }

                $result = array(
                    'success' => $this->success,
                    'data' => array(
                        'labels' => $labels,
                        'datasets' => $datasets,
                        'steps' => $steps
                    )
                );
                
                echo json_encode($result);
            }
            else { die(ACCESS_DENIED); }
        }

        /**
         * 
         */
        public function get_edit_profile($username) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if($username == '' || empty($username) || !$username) { die(ACCESS_DENIED); }
                else if($username === $_SESSION['sess_id']) {
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
                else { die(ACCESS_DENIED); }
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
    