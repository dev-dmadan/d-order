<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);

	/**
	 * Class Register
     * Proses melakukan register ke sistem
	 */
	class Register extends Controller {

        private $message = NULL;
        private $error = array();
        private $notif = array();
        private $success = false;

		/**
		 * Construct. 
         * Load class Auth
		 */
		public function __construct() {
            $this->validation();
            $this->model('UserModel');
            $this->model('LookupModel');
		}

		/**
		 * Method index
         * Default method
		 */
		public function index() {
            $this->doRegister();
		}

		/**
         * 
         */
        private function doRegister() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
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
                    $validation = $this->set_validation($data);
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
                        else { $valueImage = md5($data['username']).$validImage['namaFile']; }
                    }
                    else { $valueImage = NULL; }

                    if(!$this->checkUsername($data['username'])) {
                        $cek = false;
                        $this->error['username_register'] = 'Username already exists, please use another username';
                    }

                    if($data['password'] != $data['confirm_password']) {
                        $cek = false;
                        $this->error['password_register'] = $this->error['confirm_password'] = 'Password and confirm password is different';
                    }

                    if($cek) {
                        $dataInsert = array(
                            'username' => $data['username'],
                            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                            'name' => $data['name'],
                            'level' => $this->getLevel('MEMBERS')['id'],
                            'status' => $this->getActiveStatus('NON ACTIVE')['id'],
                            'image' => $valueImage,
                            'created_by' => NULL
                        );

                        if($image) {
                            $path = ROOT.DS.'assets'.DS.'images'.DS.'user'.DS.$valueImage;
                            if(!move_uploaded_file($image['tmp_name'], $path)){
                                $this->error['image'] = "Fail upload image";
                                $this->success = $checkImage = false;
                            }
                        }
                        
                        if($checkImage) {
                            $insert = $this->UserModel->insert($dataInsert);
                            if($insert['success']) {
                                $this->success = true;
                                $this->notif = array(
                                    'type' => 'success',
                                    'title' => 'Success Message',
                                    'message' => 'Success Register new Account'
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
        private function checkUsername($username) {
            $check = true;
            $user = $this->UserModel->getById($username);
            if(!empty($user)) {
                $check = false;
            }
            
            return $check;
        }

        /**
         * 
         */
        private function getLevel($level) {
            $result = false;

            $levelUser = !empty($this->LookupModel->getByName_level($level)) ? 
                $this->LookupModel->getByName_level($level) : false;
            
            if($levelUser) {
                $result = array(
                    'id' => $levelUser['id'],
                    'name' => $levelUser['name']
                );
            }

            return $result;
        }

        /**
         * 
         */
        private function getActiveStatus($status) {
            $result = false;

            $this->model('LookupModel');
            $statusActive = !empty($this->LookupModel->getByName_activeStatus($status)) ? 
                $this->LookupModel->getByName_activeStatus($status) : false;
            
            if($statusActive) {
                $result = array(
                    'id' => $statusActive['id'],
                    'name' => $statusActive['name']
                );
            }

            return $result;
        }

        /**
         * 
         */
        private function set_validation($data) {
            $this->validation->set_rules($data['username'], 'Username', 'username_register', 'string | 1 | 50 | required');
            $this->validation->set_rules($data['password'], 'Password', 'password_register', 'string | 5 | 255 | required');
            $this->validation->set_rules($data['confirm_password'], 'Confirm Password', 'confirm_password', 'string | 5 | 255 | required');
            $this->validation->set_rules($data['name'], 'Full Name', 'fullname', 'string | 1 | 255 | required');

            return $this->validation->run();
        }
	}
