<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);

	/**
	 * Class login
     * Proses melakukan login ke sistem, lockscreen dan logout 
	 */
	class Login extends Controller {

		private $username;
        private $password;
        private $error = array();
        private $notif = array();
        private $success = false;

		/**
		 * Construct. 
         * Load class Auth
		 */
		public function __construct() {
            $this->auth();
            $this->validation();
            $this->model('UserModel');
		}

		/**
		 * Method index
         * Default method
		 */
		public function index() {
			if($this->auth->isLogin()) { $this->redirect(); }
			else {
				$_SESSION['sess_lockscreen'] = false;
				
				if($_SERVER['REQUEST_METHOD'] == "POST") { $this->doLogin(); } // jika request post login
				else { $this->view('auth/login'); } // jika bukan, atau hanya menampilkan halaman login
			}
		}

		/**
		 * Method doLogin
         * Proses pengecekan user dan password berdasarkan jenis user
		 * pemberian hak akses berdasarkan level
		 * set session default
         * @param callback {boolean} default false
		 * @return result {object} 
		 */
		private function doLogin($callback = false) {

            $this->username = (isset($_POST['username']) && (empty($_POST['username']) || $_POST['username'] != "")) ? 
                $this->validation->validInput($_POST['username'], false) : false;
            $this->password = (isset($_POST['password']) && (empty($_POST['password']) || $_POST['password'] != "")) ? 
                $this->validation->validInput($_POST['password'], false) : false;

            // Get Data User
            $dataUser = $this->UserModel->getById($this->username);
            if(!$dataUser) {
                $this->error = array(
                    'username' => 'Username and your password is wrong !', 
                    'password' => 'Username and your password is wrong !'
                );
                $this->notif = array(
                    'type' => 'error',
                    'title' => 'Warning Message',
                    'message' => 'Please check the form !'
                );
            }
            else {
                $username = $dataUser['username'];
                $password = $dataUser['password'];

                // if(($username === $this->username) && (password_verify($this->password, $password)) {
				if((($username === $this->username) && ($password === $this->password)) 
					&& $dataUser['status_name'] === 'ACTIVE') {
                    $this->setSession($dataUser);
                    $this->success = true;
                }
                else {
                    $this->error = array(
                        'username' => 'Username and your password is wrong !', 
                        'password' => 'Username and your password is wrong !'
                    );
                    $this->notif = array(
                        'type' => 'error',
                        'title' => 'Warning Message',
                        'message' => 'Please check the form !'
                    );
                }
            }

			$result = array(
				'success' => $this->success,
				'callback' => $callback,
				'error' => $this->error,
                'notif' => $this->notif,
                'data' => $dataUser
			);

			echo json_encode($result);
		}

		/**
		 * 
		 */
		private function setSession($user){
			// cek kondisi foto
            if(!empty($user['image'])) {
                // cek foto di storage
                $filename = ROOT.DS.'assets'.DS.'images'.DS.'user'.DS.$user['image'];
                if(!file_exists($filename)) { $images = BASE_URL.'assets/images/user/default.jpg'; }
                else { $images = BASE_URL.'assets/images/user/'.$user['image']; }
            }
            else { $images = BASE_URL.'assets/images/user/default.jpg'; }

			$_SESSION['sess_login'] = true;
			$_SESSION['sess_lockscreen'] = false;
			$_SESSION['sess_id'] = $user['username'];
			$_SESSION['sess_name'] = $user['name'];
			$_SESSION['sess_images'] = $images;
			$_SESSION['sess_level_id'] = $user['level_id'];
			$_SESSION['sess_level'] = $user['level_name'];
			$_SESSION['sess_status_id'] = $user['status_id'];
			$_SESSION['sess_status'] = $user['status_name'];
			$_SESSION['sess_welcome'] = true;
			$_SESSION['sess_timeout'] = date('Y-m-d H:i:s', time()+(60*60)); // 1 jam idle
			$_SESSION['sess_menu'] = $this->auth->getListMenu($user['level_id']);
		}

		/**
		 * Fungsi lockscreen
		 * set ulang session login dan session lockscreen saja
		 */
		public function lockscreen() {
			$lockscreen = isset($_SESSION['sess_lockscreen']) ? $_SESSION['sess_lockscreen'] : false;
			$callback = isset($_GET['callback']) ? $_GET['callback'] : false;

			if(!$lockscreen) { $this->redirect(); }
			else{
				if($_SERVER['REQUEST_METHOD'] == "POST") { $this->doLogin($callback); } // jika request post login
				else { $this->view('lockscreen'); } // jika bukan, atau hanya menampilkan halaman login
			}
		}

		/**
		 * Fungsi logout
		 * menghapus semua session yang ada
		 */
		public function logout() {
			session_unset();
			session_destroy();

			$this->redirect();
		}
	}
